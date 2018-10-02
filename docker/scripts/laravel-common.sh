#!/bin/sh
cd $VOLUME_PATH
cp -f injected/.env $VOLUME_PATH
cp -f injected/webpack.env.ts $VOLUME_PATH
rm -r injected
php artisan cache:clear
php artisan clear-compiled
php artisan config:cache
php artisan route:cache
php artisan view:clear

if [ $SHOULD_MIGRATE = "true" ]; then
    php artisan migrate --force
fi

if [ $SHOULD_SEED = "true" ]; then
    php artisan db:seed --force
fi