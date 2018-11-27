#!/bin/sh
cd $SCRIPTS_DIR
sh init-laravel.sh
LARAVEL_PATH=$VOLUME_PATH

if [ $APP_MODE = "production" ]; then
    #cache so that config retrieval speeds up
    php $LARAVEL_PATH/artisan config:cache
fi

#set correct permissions for any files generated as result of init/caching process. e.g. laravel.log could be created with root:www-data 755. below will fix that.
sh set-permissions.sh
su -c "php $LARAVEL_PATH/artisan queue:work $QUEUEWORKER_DRIVER" -s /bin/sh www-data