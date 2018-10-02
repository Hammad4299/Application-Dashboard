FROM registry.gitlab.com/teraception/inhouse/application-dashboard/teraception-application-dashboard-web/appcode as appcode

#Stage
FROM registry.gitlab.com/teraception/php/fpm/lite:7.2.7
WORKDIR /scripts

COPY ./docker/appcode-executor/php.ini /usr/local/etc/php/php.ini
COPY ./docker/appcode-executor/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY --from=appcode /data /var/www
#permissions set
RUN chown -R root:www-data /var/www \
    && chmod -R 755 /var/www \
    && chmod -R 775 /var/www/bootstrap/cache
    
ENV SCRIPTS_DIR /scripts
ENV VOLUME_PATH /var/www
ENV QUEUEWORKER_DRIVER database
ENV STATIC_CONTENT_URL /
ENV SHOULD_MIGRATE true
ENV SHOULD_SEED false
#this can cause code caching. So live changes in production code might not be visible for some time
#COPY ./docker/appcode-executor/opcdoe_cache.ini /usr/local/etc/php/conf.d/php.ini
COPY /docker/scripts /scripts
CMD [ "sh", "init-prod-php.sh" ]