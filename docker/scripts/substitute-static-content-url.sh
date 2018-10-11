#!/bin/sh
cd $VOLUME_PATH

#envsubst doesn't perform inplace substitution
mv webpack-path-base.config.js tmp && envsubst '${STATIC_CONTENT_URL}' < tmp > webpack-path-base.config.js && rm tmp > /dev/null
mv webpack-assets.json tmp && envsubst '${STATIC_CONTENT_URL}' < tmp > webpack-assets.json && rm tmp  > /dev/null

REGEX=".*\.\(js\|js\.map\|css\|css\.map\)$"
find public -regex $REGEX | while read line; do
    mv $line tmp && envsubst '${STATIC_CONTENT_URL}' < tmp > $line && rm tmp
done