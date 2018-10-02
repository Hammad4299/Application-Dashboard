#!/bin/sh
targetPath=$VOLUME_PATH
chown -R root:www-data $targetPath/bootstrap/cache
chown -R root:www-data $targetPath/storage/logs
chown -R root:www-data $targetPath/storage/framework
chmod -R 775 $targetPath/bootstrap/cache
chmod -R 775 $targetPath/storage/logs
chmod -R 775 $targetPath/storage/framework