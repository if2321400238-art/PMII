#!/bin/sh
set -e

mkdir -p \
  /var/www/storage/logs \
  /var/www/storage/framework/cache \
  /var/www/storage/framework/sessions \
  /var/www/storage/framework/views \
  /var/www/bootstrap/cache \
  /var/www/public/build

chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache /var/www/public/build || true
chmod -R ug+rwX /var/www/storage /var/www/bootstrap/cache /var/www/public/build || true

exec /usr/bin/supervisord -c /etc/supervisord.conf
