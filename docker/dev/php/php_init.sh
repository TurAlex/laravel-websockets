#!/usr/bin/env bash

chmod +x artisan

composer install --no-progress --prefer-dist --working-dir=/app

#php artisan key:generate
#php artisan migrate --no-interaction
#php artisan db:seed
#php artisan locotrade:translates

#php artisan key:generate --env=testing
#php artisan migrate --no-interaction --env=testing
#php artisan db:seed --env=testing
#php artisan locotrade:translates --env=testing
echo "* * * * * cd /app && php artisan schedule:run >> /dev/null 2>&1" > /etc/cron.d/ikura.cron
/etc/init.d/cron start


exec php-fpm --nodaemonize