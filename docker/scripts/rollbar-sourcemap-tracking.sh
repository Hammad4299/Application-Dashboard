#!/bin/sh
base_disk_path=$VOLUME_PATH/public
base_url=$APP_URL/
cd $base_disk_path

find -name '*.js.map' | while read line; do
	len=${#line}
    first=3
    ending=`expr $len - $first - 1`
	rel_path=$(echo $line | cut -c $first-)
    minrel_path=$(echo $line | cut -c $first-$ending)
   curl https://api.rollbar.com/api/1/sourcemap \
   -F access_token=$ROLLBAR_TOKEN \
   -F version=$GIT_REVISION_HASH \
   -F minified_url=${base_url}${minrel_path} \
   -F source_map=@$rel_path
done