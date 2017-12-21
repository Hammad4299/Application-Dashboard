#!/bin/sh
site_available_dir="/disk-drive-1/nginx-config/sites-available/"
nginx_conf_name="application-dashboard.conf"
target_dir_base="/disk-drive-1/www/application_dashboard/"
shared_dir_base="${target_dir_base}shared/"
releaseNum=$1
current_dir_base="${target_dir_base}releases/$releaseNum/"

mkdir -p $current_dir_base

deployment_info_folder="deployment/"

cp -r * $current_dir_base
cd $current_dir_base
composer install

sudo chown -R root:www-data $target_dir_base

mkdir -p "${shared_dir_base}"

if [ ! -d "${shared_dir_base}storage" ]; then
	cp -r "${current_dir_base}storage" "${shared_dir_base}"
fi

rm -r "${current_dir_base}storage"
ln -sf "${shared_dir_base}storage" "${current_dir_base}"
sudo setfacl -R -m g:www-data:rwX,u:www-data:rwX "${shared_dir_base}storage"
sudo setfacl -R -m default:g:www-data:rwX,default:u:www-data:rwX "${shared_dir_base}storage"

php "${current_dir_base}artisan" cache:clear
php "${current_dir_base}artisan" config:cache
php "${current_dir_base}artisan" view:clear
php "${current_dir_base}artisan" storage:link
php "${current_dir_base}artisan" migrate

cp -rf "${current_dir_base}${deployment_info_folder}${nginx_conf_name}" "${site_available_dir}${nginx_conf_name}"
ln -sf "${site_available_dir}${nginx_conf_name}" "/etc/nginx/sites-enabled/${nginx_conf_name}"

rm -r "${target_dir_base}current"
ln -sf "${current_dir_base}" "${target_dir_base}current"

nginx -s reload