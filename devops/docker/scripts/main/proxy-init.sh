#!/bin/sh
sh /scripts/pre-init.sh

# exit when any command fails
set -e

subst_path=/etc/nginx/conf.d
mv $subst_path/proxy.conf $subst_path/tmp.conf \
    && envsubst '${upsteam_url} ${listen_port} ${webserver_root}' < $subst_path/tmp.conf > $subst_path/proxy.conf \
    && rm $subst_path/tmp.conf

echo 'starting nginx';
nginx -g 'daemon off;'
echo 'nginx stopped';