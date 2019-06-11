#!/bin/sh
OLD_PATH=$(pwd)

DIST_PATH=$1

cd /var/www

#envsubst doesn't perform inplace substitution
mv webpack-path-base.config.js tmp && envsubst '${STATIC_CONTENT_URL}' < tmp > webpack-path-base.config.js && rm tmp > /dev/null
mv webpack-assets.json tmp && envsubst '${STATIC_CONTENT_URL}' < tmp > webpack-assets.json && rm tmp  > /dev/null

REGEX=".*\.\(css\|css\.map\|js\|js\.map\)$"
find public -regex $REGEX | while read line; do
    mv $line tmp && envsubst '${STATIC_CONTENT_URL}' < tmp > $line && rm tmp
done

#since can't replace in compressed, remove them so that non compressed gets used
REGEX=".*\.\(css\.gz\|css\.map\.gz\|js\.gz\|js\.map\.gz\)$"
find public -regex $REGEX | while read line; do
    rm $line
done

cd $OLD_PATH