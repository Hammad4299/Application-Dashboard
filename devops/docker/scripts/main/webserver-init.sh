#!/bin/sh
sh /scripts/pre-init.sh

# exit when any command fails
set -e

subst_path=/etc/nginx/conf.d
mv $subst_path/main.conf $subst_path/tmp.conf \
    && envsubst '${executor} ${executor_port} ${listen_port} ${webserver_root}' < $subst_path/tmp.conf > $subst_path/main.conf \
    && rm $subst_path/tmp.conf

sh /scripts/substitute-static-content.sh public
echo 'starting nginx';
nginx -g 'daemon off;'
echo 'nginx stopped';