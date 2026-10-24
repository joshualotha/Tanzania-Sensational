"""Unit tests for the staging booking test's fail-closed cleanup builder."""
import importlib.util
import pathlib
import subprocess
import unittest

SCRIPT = pathlib.Path(__file__).with_name("staging-booking-integration.py")
SPEC = importlib.util.spec_from_file_location("staging_booking_integration", SCRIPT)
if SPEC is None or SPEC.loader is None:
    raise ImportError("Could not load staging booking integration script.")
MODULE = importlib.util.module_from_spec(SPEC)
SPEC.loader.exec_module(MODULE)


class CleanupCodeTests(unittest.TestCase):
    def test_cleanup_deletes_only_token_marked_test_bookings_and_owned_departure(self):
        code = MODULE.build_cleanup_code(
            departure_id=77,
            route_name="Hermes QA isolated ab12cd",
            booking_ids=[902, 901, 902],
            token="ab12cd",
        )
        compact = "".join(code.split())
        self.assertIn("global $wpdb;", code)
        self.assertIn("$expected_ids=[901,902]", compact)
        self.assertIn("TSS-QA-ab12cd", code)
        self.assertIn("qa-%ab12cd@example.invalid", code)
        self.assertIn("special_requestsLIKE%s", compact)
        self.assertIn("WHEREid=%dANDdeparture_id=%d", compact)
        self.assertIn("SELECTCOUNT(*)FROM{$b}WHEREdeparture_id=%d", compact)
        self.assertIn("$wpdb->query('ROLLBACK')", code)
        self.assertIn("$wpdb->query('COMMIT')", code)
        self.assertNotIn("$wpdb->delete($b,['departure_id'=>$id]", compact)
        self.assertIn("'route_name'=>$route_name", compact)

    def test_cleanup_builder_emits_syntactically_valid_php(self):
        code = MODULE.build_cleanup_code(77, "Hermes QA isolated ab12cd", [901], "ab12cd")
        result = subprocess.run(
            ["php", "-l"],
            input="<?php " + code,
            text=True,
            stdout=subprocess.PIPE,
            stderr=subprocess.PIPE,
            check=False,
        )
        self.assertEqual(result.returncode, 0, result.stderr or result.stdout)


if __name__ == "__main__":
    unittest.main()
