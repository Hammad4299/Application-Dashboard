#Stage
FROM application-dashboard-web/executor
    
ENV QUEUECOMMAND_PARAMS database
ENV APP_MODE local
ENV STATIC_CONTENT_URL /
ENV SHOULD_MIGRATE true
ENV SHOULD_SEED false
ENV ROLLBAR_SOURCE_BASE_URL https://dynamichost

COPY --from=application-dashboard-web/files /devops/docker/scripts /scripts

ARG COMMIT_HASH=""
ENV GIT_REVISION_HASH $COMMIT_HASH
CMD [ "sh", "/scripts/main/start-laravel-fpm.sh" ]