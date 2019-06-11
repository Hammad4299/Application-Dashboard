#!/bin/sh
# exit when any command fails
set -e

OLD_PATH=$(pwd)
cd $SCRIPTS_DIR
LARAVEL_PATH=/var/www
#create any missing folders with correct permissions if not already created. This can happen if following parent directory is volume mounted with empty source.
#Existing folder permissions are handled by volume mounting manager. e.g. k8s securityContext fsGroup 33(www-data)
#It should ensure that www-data group has write permission to all writable directories/files.
su -c "mkdir -m 2775 -p $LARAVEL_PATH/storage/logs" -s /bin/sh www-data
su -c "mkdir -m 2775 -p $LARAVEL_PATH/storage/framework/cache/data" -s /bin/sh www-data
su -c "mkdir -m 2775 -p $LARAVEL_PATH/storage/framework/sessions" -s /bin/sh www-data
su -c "mkdir -m 2775 -p $LARAVEL_PATH/storage/framework/testing" -s /bin/sh www-data
su -c "mkdir -m 2775 -p $LARAVEL_PATH/storage/framework/views" -s /bin/sh www-data
su -c "mkdir -m 2775 -p $LARAVEL_PATH/bootstrap/cache" -s /bin/sh www-data
su -c "mkdir -m 2775 -p $LARAVEL_PATH/storage/app" -s /bin/sh www-data
sh /scripts/composer-install.sh /var/www

if [ $APP_MODE = "production" ]; then
    sh substitute-static-content.sh public
    #cache so that config retrieval speeds up
    php $LARAVEL_PATH/artisan view:cache
    php $LARAVEL_PATH/artisan config:cache
    php $LARAVEL_PATH/artisan route:cache || echo 'Routing caching failed'    
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

cd $OLD_PATH