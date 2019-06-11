#!/bin/sh
OLD_PATH=$(pwd)

cd /scripts

#envsubst doesn't perform inplace substitution
mv /usr/local/etc/php-fpm.d/www.conf tmp \
    && envsubst '${FPM_POOL_MODE} ${FPM_POOL_MAX_SPARE} ${FPM_POOL_MIN_SPARE} ${FPM_POOL_START} ${FPM_POOL_MAX}' < tmp > /usr/local/etc/php-fpm.d/www.conf \
    && rm tmp  > /dev/null

cd $OLD_PATH