#Stage
FROM application-dashboard-web/executor
    
ENV SCRIPTS_DIR /scripts
ENV VOLUME_PATH /var/www
ENV QUEUECOMMAND_PARAMS database
ENV APP_MODE production
ENV CRON_MODE background
ENV STATIC_CONTENT_URL /
ENV SHOULD_MIGRATE true
ENV SHOULD_SEED false
ENV ROLLBAR_SOURCE_BASE_URL https://dynamichost

#this can cause code caching. So live changes in production code might not be visible for some time
#COPY --from=application-dashboard-web/files /devops/resources/php/opcode_cache.ini /usr/local/etc/php/conf.d/php.ini
COPY --from=application-dashboard-web/files /devops/docker/scripts /scripts

#build-laravel
#www-data has uid and gid 33
COPY --from=application-dashboard-web/appcode --chown=root:www-data /data /var/www
RUN cd $VOLUME_PATH && php artisan cache:clear \
    && php artisan clear-compiled \
    && php artisan view:clear \
    && php artisan config:clear \
    && php artisan route:clear

#permission-set
RUN cd $VOLUME_PATH && chown -R root:www-data bootstrap/cache \
    && chown -R root:www-data storage/logs    \
    && chown -R root:www-data storage/framework   \
    && chmod -R 2775 bootstrap/cache   \
    && chmod -R 2775 storage

WORKDIR /var/www

ARG COMMIT_HASH=""
ENV GIT_REVISION_HASH $COMMIT_HASH
CMD [ "sh", "/scripts/main/start-laravel-fpm.sh" ]