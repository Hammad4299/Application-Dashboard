#!/bin/sh
cd $SCRIPTS_DIR
LARAVEL_PATH=$VOLUME_PATH
#create any missing folders with correct permissions if not already created. 
#Existing folder permissions are handled by volume mounting manager. e.g. k8s securityContext fsGroup 33(www-data)
#It should ensure that www-data group has write permission to all writable directories/files.
su -c "mkdir -m 2775 -p $LARAVEL_PATH/storage/logs" -s /bin/sh www-data
su -c "mkdir -m 2775 -p $LARAVEL_PATH/storage/framework/cache" -s /bin/sh www-data
su -c "mkdir -m 2775 -p $LARAVEL_PATH/storage/framework/sessions" -s /bin/sh www-data
su -c "mkdir -m 2775 -p $LARAVEL_PATH/storage/framework/testing" -s /bin/sh www-data
su -c "mkdir -m 2775 -p $LARAVEL_PATH/storage/framework/views" -s /bin/sh www-data
su -c "mkdir -m 2775 -p $LARAVEL_PATH/storage/app" -s /bin/sh www-data
sh composer-install.sh

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