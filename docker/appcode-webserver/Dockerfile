FROM registry.gitlab.com/teraception/inhouse/application-dashboard/teraception-application-dashboard-web/appcode as appcode

#Stage
FROM nginx:1.14.0-alpine

RUN apk add --update libintl && \
    apk add --virtual build_deps gettext &&  \
    cp /usr/bin/envsubst /usr/local/bin/envsubst && \
    apk del build_deps

WORKDIR /var/www
ENV listen_port 8080
ENV executor risevision-executor
ENV executor_port 9000
ENV SCRIPTS_DIR /scripts
ENV VOLUME_PATH /var/www
ENV STATIC_CONTENT_URL /
COPY ./docker/appcode-webserver/conf /etc/nginx/conf.d
COPY --from=appcode /data/public /var/www/public
COPY ./docker/scripts /scripts
CMD [ "sh", "/scripts/webserver-init.sh" ]