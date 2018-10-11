#!/bin/sh
cd $SCRIPTS_DIR
sh init-laravel.sh
LARAVEL_PATH=$VOLUME_PATH

if [ $APP_MODE = "production" ]; then
    #cache so that config retrieval speeds up
    php $LARAVEL_PATH/artisan config:cache
fi

php $LARAVEL_PATH/artisan queue:work $QUEUEWORKER_DRIVER