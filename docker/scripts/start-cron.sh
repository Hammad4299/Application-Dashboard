#!/bin/sh
cd $SCRIPTS_DIR
sh init-laravel.sh
LARAVEL_PATH=$VOLUME_PATH

# if [ $APP_MODE = "production" ]; then
# fi

php $LARAVEL_PATH/artisan schedule:run