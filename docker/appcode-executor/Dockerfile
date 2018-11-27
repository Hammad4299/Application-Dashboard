FROM teraception.azurecr.io/application-dashboard/appcode as appcode

#Stage
FROM teraception.azurecr.io/php:fpm-lite-7.2.7
WORKDIR /scripts
COPY ./docker/appcode-executor/php.ini /usr/local/etc/php/php.ini
COPY ./docker/appcode-executor/www.conf /usr/local/etc/php-fpm.d/www.conf
    
ENV SCRIPTS_DIR /scripts
ENV VOLUME_PATH /var/www
ENV QUEUEWORKER_DRIVER database
ENV APP_MODE production
ENV STATIC_CONTENT_URL /
ENV SHOULD_MIGRATE true
ENV SHOULD_SEED false

#this can cause code caching. So live changes in production code might not be visible for some time
#COPY ./docker/appcode-executor/opcdoe_cache.ini /usr/local/etc/php/conf.d/php.ini

COPY /docker/scripts /scripts

#build-laravel
#www-data has uid and gid 33
COPY --from=appcode --chown=root:www-data /data /var/www
RUN cd $VOLUME_PATH && php artisan cache:clear \
    && php artisan clear-compiled \
    && php artisan view:clear \
    && php artisan config:clear \
    && php artisan route:clear

#permission-set
RUN cd $VOLUME_PATH && chown -R root:www-data bootstrap/cache \
    && chown -R root:www-data storage/logs    \
    && chown -R root:www-data storage/framework   \
    && chmod -R 775 bootstrap/cache   \
    && chmod -R 775 storage/logs  \
    && chmod -R 775 storage/framework
    
ARG COMMIT_HASH=""
ENV GIT_REVISION_HASH $COMMIT_HASH
CMD [ "sh", "start-laravel-fpm.sh" ]