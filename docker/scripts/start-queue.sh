#!/bin/sh
cd $VOLUME_PATH
php artisan queue:work $QUEUEWORKER_DRIVER