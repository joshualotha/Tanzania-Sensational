from pathlib import Path
import re
import unittest


ROOT = Path(__file__).resolve().parents[1]
CSS_PATH = ROOT / "staging-plugin" / "public-layout.css"
PLUGIN_PATH = ROOT / "staging-plugin" / "tanzania-sensational-design.php"


def block_after(source: str, marker: str, start: int = 0) -> tuple[str, int]:
    marker_at = source.find(marker, start)
    if marker_at < 0:
        raise AssertionError(f"Missing CSS marker: {marker}")
    opening = source.find("{", marker_at + len(marker))
    if opening < 0:
        raise AssertionError(f"Missing block after: {marker}")
    depth = 1
    for index in range(opening + 1, len(source)):
        if source[index] == "{":
            depth += 1
        elif source[index] == "}":
            depth -= 1
            if depth == 0:
                return source[opening + 1 : index], index + 1
    raise AssertionError(f"Unclosed CSS block after: {marker}")


def declarations_in(source: str, selector: str, start: int = 0) -> str:
    _, end = block_after(source, selector, start)
    opening = source.find("{", source.find(selector, start))
    return source[opening + 1 : end - 1]


class StagingHeaderResponsiveTests(unittest.TestCase):
    @classmethod
    def setUpClass(cls):
        cls.css = CSS_PATH.read_text(encoding="utf-8")
        cls.plugin = PLUGIN_PATH.read_text(encoding="utf-8")

    def test_desktop_hamburger_is_hidden_even_after_elementor_button_reset(self):
        rule = declarations_in(
            self.css, "#navbar .nav-island-inner > .mobile-hamburger"
        )
        self.assertRegex(rule, r"display\s*:\s*none\s*;")
        self.assertRegex(rule, r"border\s*:\s*0\s*;")

    def test_mobile_header_uses_booking_cta_without_contact_row_overflow(self):
        media, _ = block_after(self.css, "@media (max-width: 900px)")
        self.assertRegex(declarations_in(media, ".topbar"), r"padding\s*:\s*0\s+16px\s*;")
        self.assertRegex(declarations_in(media, ".topbar-left"), r"display\s*:\s*none\s*;")
        self.assertRegex(declarations_in(media, ".topbar-cta"), r"white-space\s*:\s*nowrap\s*;")
        hamburger = declarations_in(
            media, "#navbar .nav-island-inner > .mobile-hamburger"
        )
        self.assertRegex(hamburger, r"display\s*:\s*flex\s*;")

    def test_design_plugin_and_stylesheet_cache_versions_match(self):
        version_match = re.search(r"\* Version:\s*(\d+\.\d+\.\d+)", self.plugin)
        if version_match is None:
            self.fail("Design plugin version is missing.")
        version = version_match.group(1)
        style_start = self.plugin.index("'ts-public-layout'")
        style_call = self.plugin[style_start : self.plugin.index(");", style_start)]
        self.assertIn(f"'{version}'", style_call)


if __name__ == "__main__":
    unittest.main()
