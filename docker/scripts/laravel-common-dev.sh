#!/bin/sh
cd $VOLUME_PATH

php artisan cache:clear
php artisan clear-compiled
php artisan config:clear
php artisan route:clear
php artisan view:clear

if [ $SHOULD_MIGRATE = "true" ]; then
    php artisan migrate --force
fi

if [ $SHOULD_SEED = "true" ]; then
    php artisan db:seed --force
fi