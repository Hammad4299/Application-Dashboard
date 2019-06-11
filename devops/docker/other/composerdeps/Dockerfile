#depends on
# - application-dashboard-web/files

FROM composer:1.8.5
WORKDIR /data
COPY --from=application-dashboard-web/files ["/data/composer.json","/data/composer.lock", "./"]
RUN composer install --prefer-dist --no-scripts --no-autoloader