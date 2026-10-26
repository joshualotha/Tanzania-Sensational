#!/usr/bin/env python3
"""Read-only staging lock-contention probe using separate WP-CLI connections.

The probe performs temporary post and metadata updates inside separate transactions,
then rolls them back. It never commits or persistently changes content values.
Pass --confirm-staging-lock-probe to run it.
"""

from __future__ import annotations

import json
import shlex
import subprocess
import sys
import time

SSH_ALIAS = "Tss_web"
WP_PATH = "/home/tanzhihb/test.tanzaniasensational.com"
HOLD_SECONDS = 15
LOCK_ACQUIRE_DELAY_SECONDS = 6
MIN_WAIT_SECONDS = 2.0


def remote_wp_eval(code: str) -> list[str]:
    remote_command = f"wp --path={shlex.quote(WP_PATH)} eval {shlex.quote(code)}"
    return [
        "ssh",
        "-o",
        "BatchMode=yes",
        "-o",
        "ConnectTimeout=15",
        SSH_ALIAS,
        remote_command,
    ]


def run_capture(code: str, timeout: int = 30) -> subprocess.CompletedProcess[str]:
    return subprocess.run(remote_wp_eval(code), capture_output=True, text=True, timeout=timeout)


def phase_code(role: str, phase: str, post_id: int, meta_id: int) -> str:
    if role == "locker":
        if phase == "posts":
            lock_query = f'$locked = (int) $wpdb->get_var($wpdb->prepare("SELECT ID FROM {{$wpdb->posts}} WHERE ID = %d FOR UPDATE", {post_id})); if ({post_id} !== $locked) WP_CLI::error("Could not lock post row.");'
        else:
            lock_query = f'$locked = $wpdb->query($wpdb->prepare("SELECT meta_id FROM {{$wpdb->postmeta}} WHERE post_id = %d FOR UPDATE", {post_id})); if (false === $locked) WP_CLI::error("Could not lock postmeta rows.");'
        return (
            "global $wpdb; "
            'if (false === $wpdb->query("START TRANSACTION")) WP_CLI::error("START TRANSACTION failed."); '
            + lock_query
            + f' echo "LOCKED|{phase}\\n"; flush(); usleep({HOLD_SECONDS * 1_000_000}); '
            'if (false === $wpdb->query("COMMIT")) WP_CLI::error("COMMIT failed."); '
            f'echo "COMMITTED|{phase}\\n";'
        )

    if phase == "posts":
        operation = (
            f'$content = $wpdb->get_var($wpdb->prepare("SELECT post_content FROM {{$wpdb->posts}} WHERE ID = %d", {post_id})); '
            f'$updated = $wpdb->update($wpdb->posts, ["post_content" => $content . " lock-probe"], ["ID" => {post_id}], ["%s"], ["%d"]); '
            f'$original = $content; $read_back_sql = $wpdb->prepare("SELECT post_content FROM {{$wpdb->posts}} WHERE ID = %d", {post_id});'
        )
    else:
        operation = (
            f'$meta_value = $wpdb->get_var($wpdb->prepare("SELECT meta_value FROM {{$wpdb->postmeta}} WHERE meta_id = %d", {meta_id})); '
            f'$updated = $wpdb->update($wpdb->postmeta, ["meta_value" => $meta_value . " lock-probe"], ["meta_id" => {meta_id}], ["%s"], ["%d"]); '
            f'$original = $meta_value; $read_back_sql = $wpdb->prepare("SELECT meta_value FROM {{$wpdb->postmeta}} WHERE meta_id = %d", {meta_id});'
        )
    return (
        "global $wpdb; "
        'if (false === $wpdb->query("START TRANSACTION")) WP_CLI::error("START TRANSACTION failed."); '
        f'$started = microtime(true); {operation} $wait = microtime(true) - $started; '
        'if (false === $updated) { $wpdb->query("ROLLBACK"); WP_CLI::error("Temporary update failed."); } '
        '$rollback = $wpdb->query("ROLLBACK"); $after = $wpdb->get_var($read_back_sql); '
        'if ($after !== $original) WP_CLI::error("Rollback did not restore the original value."); '
        f'printf("WAIT|{phase}|%.3f|%s\\n", $wait, false === $rollback ? "rollback-failed" : "rollback-ok"); '
        f'if ($wait < {MIN_WAIT_SECONDS} || false === $rollback) WP_CLI::error("The update did not wait for the row lock.");'
    )


def run_phase(phase: str, post_id: int, meta_id: int) -> float:
    locker = subprocess.Popen(
        remote_wp_eval(phase_code("locker", phase, post_id, meta_id)),
        stdout=subprocess.PIPE,
        stderr=subprocess.PIPE,
        text=True,
        bufsize=1,
    )
    time.sleep(LOCK_ACQUIRE_DELAY_SECONDS)
    if locker.poll() is not None:
        stdout, stderr = locker.communicate(timeout=5)
        raise RuntimeError(f"Locker exited before the competing update began in {phase} phase: {stdout} {stderr}")

    started = time.monotonic()
    editor = run_capture(phase_code("editor", phase, post_id, meta_id), timeout=35)
    elapsed = time.monotonic() - started
    locker_stdout, locker_stderr = locker.communicate(timeout=15)
    if locker.returncode != 0:
        raise RuntimeError(f"Locker failed in {phase} phase: {locker_stdout} {locker_stderr}")
    if f"LOCKED|{phase}" not in locker_stdout or f"COMMITTED|{phase}" not in locker_stdout:
        raise RuntimeError(f"Locker did not complete both transaction boundaries: {locker_stdout} {locker_stderr}")
    if editor.returncode != 0:
        raise RuntimeError(f"Editor update probe failed in {phase} phase: {editor.stdout} {editor.stderr}")
    if f"ROLLBACK|" in editor.stdout or "rollback-ok" not in editor.stdout:
        raise RuntimeError(f"The {phase} no-op update was not rolled back cleanly: {editor.stdout}")

    wait = None
    for line in editor.stdout.splitlines():
        parts = line.split("|")
        if len(parts) == 4 and parts[0] == "WAIT" and parts[1] == phase:
            wait = float(parts[2])
    if wait is None or wait < MIN_WAIT_SECONDS or elapsed < MIN_WAIT_SECONDS:
        raise RuntimeError(f"The {phase} update did not wait for the competing lock: {editor.stdout}")
    return wait


def main() -> int:
    if "--confirm-staging-lock-probe" not in sys.argv[1:]:
        print("Refusing to run without --confirm-staging-lock-probe.", file=sys.stderr)
        return 2

    lookup = run_capture(
        'global $wpdb; $row = $wpdb->get_row("SELECT p.ID AS post_id, m.meta_id FROM {$wpdb->posts} p INNER JOIN {$wpdb->postmeta} m ON m.post_id = p.ID WHERE p.post_type = \\\'ts_destination\\\' ORDER BY p.ID, m.meta_id LIMIT 1", ARRAY_A); if (!$row) $row = $wpdb->get_row("SELECT p.ID AS post_id, m.meta_id FROM {$wpdb->posts} p INNER JOIN {$wpdb->postmeta} m ON m.post_id = p.ID ORDER BY p.ID, m.meta_id LIMIT 1", ARRAY_A); if (!$row) WP_CLI::error("No post with metadata is available for the read-only probe."); echo wp_json_encode($row);'
    )
    if lookup.returncode != 0:
        print(lookup.stderr or lookup.stdout, file=sys.stderr)
        return lookup.returncode or 1
    try:
        row = json.loads(lookup.stdout.strip().splitlines()[-1])
        post_id = int(row["post_id"])
        meta_id = int(row["meta_id"])
    except (ValueError, KeyError, json.JSONDecodeError) as error:
        print(f"Could not parse staging probe target: {lookup.stdout!r} ({error})", file=sys.stderr)
        return 1

    waits = {}
    for phase in ("posts", "postmeta"):
        waits[phase] = run_phase(phase, post_id, meta_id)
    print(
        "PASS: independent WP-CLI connections blocked on InnoDB row locks for "
        "posts and postmeta ("
        f"{waits['posts']:.2f}s, {waits['postmeta']:.2f}s); both temporary updates rolled back."
    )
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
