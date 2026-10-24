#!/usr/bin/env python3
"""Exercise isolated booking/inventory concurrency on staging.

Run from the migration checkout with the documented Tss_web SSH alias. The
script creates one uniquely named departure and synthetic bookings, sends no
email, and deletes only records tied to the departure it created.
"""
import concurrent.futures
import json
import shlex
import subprocess
import sys
import uuid

SSH_ALIAS = "Tss_web"
WP_ROOT = "/home/tanzhihb/test.tanzaniasensational.com"
SITE = "https://test.tanzaniasensational.com"
WP_BIN = "/usr/local/sbin/wp"
MARKER = "TSS_RESULT:"


def php_string(value):
    # Generated values are controlled ASCII strings; JSON string literals are
    # valid PHP double-quoted literals for these inputs.
    return json.dumps(value)


def wp_eval(code):
    remote = "cd {root} && {wp} eval {code} --path={root} --quiet".format(
        root=shlex.quote(WP_ROOT), wp=shlex.quote(WP_BIN), code=shlex.quote(code)
    )
    result = subprocess.run(
        ["ssh", "-o", "BatchMode=yes", "-o", "ConnectTimeout=10", SSH_ALIAS, remote],
        stdout=subprocess.PIPE,
        stderr=subprocess.PIPE,
        universal_newlines=True,
        timeout=120,
    )
    if result.returncode != 0:
        raise RuntimeError("WP-CLI failed (exit {}).".format(result.returncode))
    for line in result.stdout.splitlines():
        if line.startswith(MARKER):
            return json.loads(line[len(MARKER):])
    raise RuntimeError("WP-CLI did not return the expected test marker.")


def require(condition, message):
    if not condition:
        raise RuntimeError(message)


def build_cleanup_code(departure_id, route_name, booking_ids, token):
    """Build a transaction that deletes only this run's marked records."""
    recorded_ids = sorted({int(booking_id) for booking_id in booking_ids if int(booking_id) > 0})
    expected_ids = "[" + ",".join(str(booking_id) for booking_id in recorded_ids) + "]"
    marker = "TSS-QA-" + token
    customer_name = "Hermes QA synthetic " + token
    email_pattern = "qa-%" + token + "@example.invalid"
    marker_pattern = "%" + marker + "%"
    return (
        "global $wpdb;$id=" + str(int(departure_id)) + ";"
        "$route_name=" + php_string(route_name) + ";"
        "$customer_name=" + php_string(customer_name) + ";"
        "$email_pattern=" + php_string(email_pattern) + ";"
        "$marker_pattern=" + php_string(marker_pattern) + ";"
        "$expected_ids=" + expected_ids + ";"
        "$d=$wpdb->prefix.'ts_departures';$b=$wpdb->prefix.'ts_bookings';"
        "if(false===$wpdb->query('START TRANSACTION')){echo '" + MARKER + "'.wp_json_encode(['ok'=>false,'error'=>'transaction_start_failed']);exit;}"
        "$fail=function($error) use($wpdb){$wpdb->query('ROLLBACK');echo '" + MARKER + "'.wp_json_encode(['ok'=>false,'error'=>$error]);exit;};"
        "$departure=$wpdb->get_row($wpdb->prepare(\"SELECT * FROM {$d} WHERE id=%d AND route_name=%s FOR UPDATE\",$id,$route_name));"
        "if(!$departure){$fail('departure_not_owned');}"
        "$closed=$wpdb->update($d,['status'=>'closed','updated_at'=>current_time('mysql',true)],['id'=>$id,'route_name'=>$route_name]);"
        "if(false===$closed){$fail('departure_close_failed');}"
        "$test_ids=$wpdb->get_col($wpdb->prepare(\"SELECT id FROM {$b} WHERE departure_id=%d AND booking_type=%s AND customer_name=%s AND email LIKE %s AND special_requests LIKE %s FOR UPDATE\",$id,'departure',$customer_name,$email_pattern,$marker_pattern));"
        "$test_ids=array_map('intval',$test_ids?:[]);"
        "foreach($expected_ids as $expected_id){if(!in_array($expected_id,$test_ids,true)){$fail('recorded_booking_missing_or_marker_mismatch');}}"
        "$deleted_bookings=0;foreach($test_ids as $booking_id){"
        "$booking=$wpdb->get_row($wpdb->prepare(\"SELECT id,email,special_requests FROM {$b} WHERE id=%d AND departure_id=%d AND booking_type=%s AND customer_name=%s AND email LIKE %s AND special_requests LIKE %s FOR UPDATE\",$booking_id,$id,'departure',$customer_name,$email_pattern,$marker_pattern));"
        "if(!$booking){$fail('booking_marker_mismatch');}"
        "$deleted=$wpdb->delete($b,['id'=>(int)$booking->id,'departure_id'=>$id,'booking_type'=>'departure','customer_name'=>$customer_name,'email'=>$booking->email,'special_requests'=>$booking->special_requests],['%d','%d','%s','%s','%s','%s','%s']);"
        "if(1!==$deleted){$fail('booking_delete_failed');}$deleted_bookings+=$deleted;}"
        "$remaining=(int)$wpdb->get_var($wpdb->prepare(\"SELECT COUNT(*) FROM {$b} WHERE departure_id=%d\",$id));"
        "if(0!==$remaining){$fail('unmatched_bookings_present');}"
        "$deleted_departure=$wpdb->delete($d,['id'=>$id,'route_name'=>$route_name,'status'=>'closed'],['%d','%s','%s']);"
        "if(1!==$deleted_departure){$fail('departure_delete_failed');}"
        "if(false===$wpdb->query('COMMIT')){$wpdb->query('ROLLBACK');echo '" + MARKER + "'.wp_json_encode(['ok'=>false,'error'=>'transaction_commit_failed']);exit;}"
        "echo '" + MARKER + "'.wp_json_encode(['ok'=>true,'deleted_bookings'=>$deleted_bookings,'deleted_departure'=>$deleted_departure]);"
    )


def main():
    guard = wp_eval(
        "echo '" + MARKER + "'.wp_json_encode(["
        "'site'=>untrailingslashit(home_url('/')),'blog_public'=>(int)get_option('blog_public'),"
        "'core_version'=>TS_CORE_VERSION]);"
    )
    require(guard.get("site") == SITE, "Refusing to write: site URL is not the configured staging URL.")
    require(guard.get("blog_public") == 0, "Refusing to write: staging noindex is not active.")
    require(guard.get("core_version") == "0.5.0", "Refusing to write: expected tested core plugin 0.5.0.")

    token = uuid.uuid4().hex
    route_name = "Hermes QA isolated {}".format(token)
    test_marker = "TSS-QA-" + token
    test_customer_name = "Hermes QA synthetic " + token
    create = (
        "$input=['route_name'=>" + php_string(route_name) + ","
        "'route_url'=>'/trekking/kilimanjaro/lemosho-7-days',"
        "'departure_date'=>'2027-01-10','return_date'=>'2027-01-18',"
        "'price'=>'1.00','currency'=>'USD','total_seats'=>'2','inventory_state'=>'open'];"
        "$r=TS_Departure_Inventory::save(0,$input);"
        "if(is_wp_error($r)){echo '" + MARKER + "'.wp_json_encode(['ok'=>false,'error'=>$r->get_error_code()]);exit(1);}"
        "echo '" + MARKER + "'.wp_json_encode(['ok'=>true,'id'=>(int)$r->id]);"
    )
    departure_result = wp_eval(create)
    require(departure_result.get("ok") is True, "Could not create isolated test departure.")
    departure_id = int(departure_result["id"])
    test_booking_ids = []

    def cleanup():
        return wp_eval(build_cleanup_code(departure_id, route_name, test_booking_ids, token))

    try:
        common = (
            "$id=" + str(departure_id) + ";usleep(300000);"
            "$data=['departure_id'=>$id,'customer_name'=>" + php_string(test_customer_name) + ","
            "'email'=>EMAIL,'phone'=>'','country'=>'QA','group_size'=>2,"
            "'special_requests'=>" + php_string("Synthetic staging concurrency test; no customer data. " + test_marker) + "];"
            "$r=TS_Booking_Workflow::create_departure_booking($data);"
            "if(is_wp_error($r)){echo '" + MARKER + "'.wp_json_encode(['ok'=>false,'error'=>$r->get_error_code()]);}"
            "else{echo '" + MARKER + "'.wp_json_encode(['ok'=>true,'id'=>(int)$r->id]);}"
        )
        booking_code = common.replace("EMAIL", php_string("qa-{}@example.invalid".format(token)))
        inventory_code = (
            "$id=" + str(departure_id) + ";usleep(300000);"
            "$input=['route_name'=>" + php_string(route_name) + ","
            "'route_url'=>'/trekking/kilimanjaro/lemosho-7-days',"
            "'departure_date'=>'2027-01-10','return_date'=>'2027-01-18',"
            "'price'=>'1.00','currency'=>'USD','total_seats'=>'1','inventory_state'=>'open'];"
            "$r=TS_Departure_Inventory::save($id,$input);"
            "if(is_wp_error($r)){echo '" + MARKER + "'.wp_json_encode(['ok'=>false,'error'=>$r->get_error_code()]);}"
            "else{echo '" + MARKER + "'.wp_json_encode(['ok'=>true,'total_seats'=>(int)$r->total_seats]);}"
        )
        with concurrent.futures.ThreadPoolExecutor(max_workers=2) as pool:
            booking_future = pool.submit(wp_eval, booking_code)
            inventory_future = pool.submit(wp_eval, inventory_code)
            booking_result = booking_future.result()
            inventory_result = inventory_future.result()
        if booking_result.get("ok"):
            test_booking_ids.append(int(booking_result["id"]))
        require(booking_result.get("ok") != inventory_result.get("ok"), "The capacity/booking race must have exactly one winning operation.")
        state = wp_eval(
            "global $wpdb;$id=" + str(departure_id) + ";$d=$wpdb->prefix.'ts_departures';"
            "$r=$wpdb->get_row($wpdb->prepare(\"SELECT total_seats,booked_seats,held_seats FROM {$d} WHERE id=%d\",$id));"
            "echo '" + MARKER + "'.wp_json_encode(['total'=>(int)$r->total_seats,'booked'=>(int)$r->booked_seats,'held'=>(int)$r->held_seats]);"
        )
        require(state["booked"] + state["held"] <= state["total"], "Concurrent inventory mutation oversold the departure.")
        if booking_result.get("ok"):
            require(inventory_result.get("error") == "ts_capacity_below_reservations", "Booking-first race should reject capacity below its hold.")
            booking_id = test_booking_ids[0]
            expected_booked = 2
        else:
            require(booking_result.get("error") == "ts_insufficient_seats" and inventory_result.get("ok"), "Inventory-first race should leave the request short of capacity.")
            expected_booked = 1
            create_one = (
                "$r=TS_Booking_Workflow::create_departure_booking(['departure_id'=>" + str(departure_id) + ","
                "'customer_name'=>" + php_string(test_customer_name) + ",'email'=>" + php_string("qa-confirm-{}@example.invalid".format(token)) + ","
                "'phone'=>'','country'=>'QA','group_size'=>1,'special_requests'=>" + php_string("Synthetic staging idempotence test. " + test_marker) + "]);"
                "if(is_wp_error($r)){echo '" + MARKER + "'.wp_json_encode(['ok'=>false,'error'=>$r->get_error_code()]);exit(1);}"
                "echo '" + MARKER + "'.wp_json_encode(['ok'=>true,'id'=>(int)$r->id]);"
            )
            one = wp_eval(create_one)
            require(one.get("ok") is True, "Could not create isolated idempotence test hold.")
            booking_id = int(one["id"])
            test_booking_ids.append(booking_id)

        for _ in range(2):
            result = wp_eval(
                "$r=TS_Booking_Workflow::transition_status(" + str(booking_id) + ",'confirmed');"
                "echo '" + MARKER + "'.wp_json_encode(['ok'=>!is_wp_error($r)]);"
            )
            require(result.get("ok") is True, "Confirmation transition failed.")
        confirmed = wp_eval(
            "global $wpdb;$id=" + str(departure_id) + ";$d=$wpdb->prefix.'ts_departures';"
            "$r=$wpdb->get_row($wpdb->prepare(\"SELECT booked_seats,held_seats FROM {$d} WHERE id=%d\",$id));"
            "echo '" + MARKER + "'.wp_json_encode(['booked'=>(int)$r->booked_seats,'held'=>(int)$r->held_seats]);"
        )
        require(confirmed == {"booked": expected_booked, "held": 0}, "Repeated confirmation did not book seats exactly once.")
        for _ in range(2):
            result = wp_eval(
                "$r=TS_Booking_Workflow::transition_status(" + str(booking_id) + ",'cancelled');"
                "echo '" + MARKER + "'.wp_json_encode(['ok'=>!is_wp_error($r)]);"
            )
            require(result.get("ok") is True, "Cancellation transition failed.")
        cancelled = wp_eval(
            "global $wpdb;$id=" + str(departure_id) + ";$d=$wpdb->prefix.'ts_departures';"
            "$r=$wpdb->get_row($wpdb->prepare(\"SELECT booked_seats,held_seats FROM {$d} WHERE id=%d\",$id));"
            "echo '" + MARKER + "'.wp_json_encode(['booked'=>(int)$r->booked_seats,'held'=>(int)$r->held_seats]);"
        )
        require(cancelled == {"booked": 0, "held": 0}, "Repeated cancellation did not release seats exactly once.")

        create_expiring = (
            "$r=TS_Booking_Workflow::create_departure_booking(['departure_id'=>" + str(departure_id) + ","
            "'customer_name'=>" + php_string(test_customer_name) + ",'email'=>" + php_string("qa-expiry-{}@example.invalid".format(token)) + ","
            "'phone'=>'','country'=>'QA','group_size'=>1,'special_requests'=>" + php_string("Synthetic staging expiry test. " + test_marker) + "]);"
            "if(is_wp_error($r)){echo '" + MARKER + "'.wp_json_encode(['ok'=>false,'error'=>$r->get_error_code()]);exit(1);}"
            "echo '" + MARKER + "'.wp_json_encode(['ok'=>true,'id'=>(int)$r->id]);"
        )
        expiring = wp_eval(create_expiring)
        require(expiring.get("ok") is True, "Could not create isolated expiry test hold.")
        expiring_id = int(expiring["id"])
        test_booking_ids.append(expiring_id)
        expire_code = (
            "global $wpdb;$id=" + str(departure_id) + ";$booking_id=" + str(expiring_id) + ";$b=$wpdb->prefix.'ts_bookings';"
            "$updated=$wpdb->update($b,['hold_expires_at'=>gmdate('Y-m-d H:i:s',time()-600)],['id'=>$booking_id,'departure_id'=>$id]);"
            "if(false===$updated){echo '" + MARKER + "'.wp_json_encode(['ok'=>false]);exit(1);}"
            "$released=TS_Booking_Workflow::release_expired_holds();"
            "$brow=$wpdb->get_row($wpdb->prepare(\"SELECT status,held_seats,hold_expires_at FROM {$b} WHERE id=%d\",$booking_id));"
            "$d=$wpdb->prefix.'ts_departures';$drow=$wpdb->get_row($wpdb->prepare(\"SELECT booked_seats,held_seats FROM {$d} WHERE id=%d\",$id));"
            "$again=TS_Booking_Workflow::release_expired_holds();"
            "echo '" + MARKER + "'.wp_json_encode(['released'=>(int)$released,'status'=>$brow->status,'booking_held'=>(int)$brow->held_seats,'expiry'=>$brow->hold_expires_at,'departure_booked'=>(int)$drow->booked_seats,'departure_held'=>(int)$drow->held_seats,'repeat'=>(int)$again]);"
        )
        expired = wp_eval(expire_code)
        require(expired == {"released": 1, "status": "cancelled", "booking_held": 0, "expiry": None, "departure_booked": 0, "departure_held": 0, "repeat": 0}, "Expiry cleanup did not release the isolated hold exactly once.")
        print("PASS: isolated staging capacity race, confirm/cancel idempotence, and expiry release.")
    finally:
        cleaned = cleanup()
        if cleaned.get("ok") is not True:
            raise RuntimeError("Test cleanup failed for isolated departure id {}.".format(departure_id))


if __name__ == "__main__":
    try:
        main()
    except Exception as error:
        print("FAIL: {}".format(error), file=sys.stderr)
        sys.exit(1)
