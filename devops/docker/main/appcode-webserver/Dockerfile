FROM application-dashboard-web/webserver

WORKDIR /var/www
ENV listen_port 8080
ENV executor executor
ENV executor_port 9000
ENV webserver_root /var/www
ENV STATIC_CONTENT_URL /
COPY --from=application-dashboard-web/files ["/devops/docker/main/webserver/nginx","/etc/nginx/conf.d"]
COPY --from=application-dashboard-web/files ["/devops/docker/scripts","/scripts"]
COPY --from=application-dashboard-web/appcode /data/public /var/www/public
ARG COMMIT_HASH=""
ENV GIT_REVISION_HASH $COMMIT_HASH
CMD [ "sh", "/scripts/main/webserver-init.sh" ]