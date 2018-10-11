#!/bin/sh
cd $SCRIPTS_DIR
sh composer-install.sh
LARAVEL_PATH=$VOLUME_PATH

if [ $APP_MODE = "production" ]; then
    sh prepare-to-run.sh
else
    php "$LARAVEL_PATH/artisan" cache:clear
    php "$LARAVEL_PATH/artisan" clear-compiled
    php "$LARAVEL_PATH/artisan" config:clear
    php "$LARAVEL_PATH/artisan" route:clear
    php "$LARAVEL_PATH/artisan" view:clear
fi

if [ $SHOULD_MIGRATE = "true" ]; then
    php "$LARAVEL_PATH/artisan" migrate --force
fi

if [ $SHOULD_SEED = "true" ]; then
    php "$LARAVEL_PATH/artisan" db:seed --force
fi