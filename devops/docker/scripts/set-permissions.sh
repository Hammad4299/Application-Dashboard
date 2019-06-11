#!/bin/sh

# exit when any command fails
set -e

LARAVEL_PATH=/var/www
#dynamic application data e.g. uploaded files shouldn't be chown/chmod since they can be a lot increasing startup time. 
#Permissions for existing files are managed by volume mounting manager e.g. k8s security context fsGroup 33(www-data)
chown -R root:www-data $LARAVEL_PATH/bootstrap/cache \
    && chown -R root:www-data $LARAVEL_PATH/storage/logs    \
    && chown -R root:www-data $LARAVEL_PATH/storage/framework   \
    && chmod -R 2775 $LARAVEL_PATH/bootstrap/cache   \
    && chmod -R 2775 $LARAVEL_PATH/storage/framework \
    && chmod -R 2775 $LARAVEL_PATH/storage/logs