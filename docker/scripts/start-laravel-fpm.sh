#!/bin/sh
cd $SCRIPTS_DIR
LARAVEL_PATH=$VOLUME_PATH
sh init-laravel.sh

if [ $APP_MODE = "production" ]; then
    #since need to serve webrequests, make sure that replacements are made.
    sh substitute-static-content-url.sh
    #cache so that config retrieval speeds up
    php $LARAVEL_PATH/artisan config:cache
    sh rollbar-deploy.sh
    sh rollbar-sourcemap-tracking.sh
fi

php-fpm