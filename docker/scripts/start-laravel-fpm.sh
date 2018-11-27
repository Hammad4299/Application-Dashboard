#!/bin/sh
cd $SCRIPTS_DIR
LARAVEL_PATH=$VOLUME_PATH
sh init-laravel.sh

if [ $APP_MODE = "production" ]; then
    #since need to serve webrequests, make sure that replacements are made.
    sh substitute-static-content-url.sh
    #cache so that config retrieval speeds up
    php $LARAVEL_PATH/artisan config:cache
    php $LARAVEL_PATH/artisan route:cache || echo 'Routing caching failed'    
    sh rollbar-deploy.sh
    sh rollbar-sourcemap-tracking.sh
fi

#set correct permissions for any files generated as result of init/caching process. e.g. laravel.log could be created with root:www-data 755. below will fix that.
sh set-permissions.sh
php-fpm