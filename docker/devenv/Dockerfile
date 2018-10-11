FROM registry.gitlab.com/teraception/inhouse/application-dashboard/teraception-application-dashboard-web/appcode-executor

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

WORKDIR /scripts
ENV VOLUME_PATH /var/www
ENV SCRIPTS_DIR /scripts
ENV SKIP_COMPOSER true
ENV SHOULD_MIGRATE false
ENV SHOULD_SEED false
ENV APP_MODE development
COPY ["./docker/scripts", "/scripts/"]
COPY ./docker/devenv/xdebug.ini /scripts