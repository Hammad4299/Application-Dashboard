FROM teraception.azurecr.io/application-dashboard/appcode as appcode

#Stage
FROM nginx:1.14.0-alpine

RUN apk add --update libintl && \
    apk add --virtual build_deps gettext &&  \
    cp /usr/bin/envsubst /usr/local/bin/envsubst && \
    apk del build_deps

WORKDIR /var/www
ENV listen_port 8080
ENV executor application-dashboard-executor
ENV executor_port 9000
ENV SCRIPTS_DIR /scripts
ENV VOLUME_PATH /var/www
ENV STATIC_CONTENT_URL /
COPY ./docker/appcode-webserver/conf /etc/nginx/conf.d
COPY ./docker/scripts /scripts
COPY --from=appcode /data/public /var/www/public
ARG COMMIT_HASH=""
ENV GIT_REVISION_HASH $COMMIT_HASH
CMD [ "sh", "/scripts/webserver-init.sh" ]