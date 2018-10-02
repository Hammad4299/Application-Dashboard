#!/bin/sh
cd $SCRIPTS_DIR
subst_path=/etc/nginx/conf.d
mv $subst_path/main.conf $subst_path/tmp.conf \
    && envsubst '${executor} ${executor_port} ${listen_port}' < $subst_path/tmp.conf > $subst_path/main.conf \
    && rm $subst_path/tmp.conf

sh substitute-static-content-url.sh
echo 'starting nginx';
nginx -g 'daemon off;'
echo 'nginx stopped';