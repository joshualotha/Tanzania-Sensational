#!/bin/sh
set -eu

SCRIPT_DIR=$(CDPATH= cd -- "$(dirname -- "$0")" && pwd)
count=0
for test_file in "$SCRIPT_DIR"/*.php; do
	php -l "$test_file"
	php "$test_file"
	count=$((count + 1))
done
printf 'PASS: %s WordPress migration PHP test scripts.\n' "$count"
