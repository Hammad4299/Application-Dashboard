#!/bin/sh
cd $SCRIPTS_DIR
sh init-laravel.sh
LARAVEL_PATH=$VOLUME_PATH

# if [ $APP_MODE = "production" ]; then
# fi

#set correct permissions for any files generated as result of init/caching process. e.g. laravel.log could be created with root:www-data 755. below will fix that.
sh set-permissions.sh
su -c "php $LARAVEL_PATH/artisan schedule:run" -s /bin/sh www-data