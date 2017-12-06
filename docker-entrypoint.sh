#!/bin/bash
set -e

if [[ -d /app/vendor ]]; then
    diff -r /vendor/vendor/ /app/vendor/ || rm -rf /app/vendor
fi

if [[ ! -d /app/vendor ]]; then
    cp -r /vendor/vendor/ /app/vendor/
fi

bash
