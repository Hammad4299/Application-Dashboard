#!/bin/sh
sh /scripts/pre-init.sh

# exit when any command fails
set -e

LARAVEL_PATH=/var/www
sh /scripts/init-laravel.sh

if [ $APP_MODE = "production" ]; then
    sh /scripts/rollbar/rollbar-sourcemap-tracking.sh /var/www/public
    sh /scripts/rollbar/rollbar-deploy.sh
fi

#set correct permissions for any files generated as result of init/caching process. e.g. laravel.log could be created with root:www-data 755. below will fix that.
sh /scripts/set-permissions.sh
sh /scripts/substitute-php-config.sh
php-fpm