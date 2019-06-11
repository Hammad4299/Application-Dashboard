#!/bin/sh
sh /scripts/pre-init.sh

# exit when any command fails
set -e

cd /scripts
export SHOULD_MIGRATE=false
export SHOULD_SEED=false
sh init-laravel.sh
LARAVEL_PATH=/var/www

#set correct permissions for any files generated as result of init/caching process. e.g. laravel.log could be created with root:www-data 755. below will fix that.
sh set-permissions.sh
sh /scripts/substitute-php-config.sh


if [ $CRON_MODE = "background" ]; then
    #IMPORTANT. The best way to gracefully handle termination signals seems to be to immediately queue a job from within cronjob in separate queue/connection and have a dedicated queueworker work on those jobs. Queueworker are foreground process and can handle term signals
    while [ true ]
    do
        su -c "php $LARAVEL_PATH/artisan schedule:run --no-interaction &" -s /bin/sh www-data
        sleep 60
    done
else
    su -c "php $LARAVEL_PATH/artisan schedule:run" -s /bin/sh www-data
fi