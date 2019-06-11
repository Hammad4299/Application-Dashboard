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
su -c "php $LARAVEL_PATH/artisan queue:work $QUEUECOMMAND_PARAMS" -s /bin/sh www-data