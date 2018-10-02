#!/bin/sh
cd $SCRIPTS_DIR
sh composer-install.sh
sh permission-set.sh
sh laravel-common-dev.sh
sh permission-set.sh
mv /scripts/xdebug.ini tmp && envsubst '${XDEBUG_REMORT_PORT}' < tmp > /usr/local/etc/php/conf.d/xdebug.ini && rm tmp > /dev/null
sh start-php.sh