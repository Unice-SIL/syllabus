#!/bin/sh
set -e

make composer_install
make build_assets
make db_migrate

symfony server:ca:install
symfony server:stop
exec symfony serve --listen-ip=0.0.0.0
