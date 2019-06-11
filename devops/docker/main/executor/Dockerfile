FROM teraception.azurecr.io/php:fpm-lite-7.2.18
COPY --from=application-dashboard-web/files /devops/docker/main/executor/php.ini /usr/local/etc/php/php.ini
COPY --from=application-dashboard-web/files /devops/docker/main/executor/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY --from=application-dashboard-web/files /devops/docker/scripts /scripts

ENV FPM_POOL_MODE dynamic
ENV FPM_POOL_MAX_SPARE 3
ENV FPM_POOL_MIN_SPARE 1
ENV FPM_POOL_START 3
ENV FPM_POOL_MAX 10
