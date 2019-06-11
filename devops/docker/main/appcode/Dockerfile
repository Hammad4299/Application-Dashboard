#depends on
# - application-dashboard-web/nodedeps
# - application-dashboard-web/files

FROM application-dashboard-web/nodedeps as webpack_frontend
WORKDIR /data
COPY --from=application-dashboard-web/files ["/data/.babelrc","/data/tsconfig*.json","./"]
COPY --from=application-dashboard-web/files ["/data/webpack","./webpack"]
COPY --from=application-dashboard-web/files ["/data/resources","./resources"]

#single quotes very important
ENV STATIC_CONTENT_URL '${STATIC_CONTENT_URL}'
#increase allowed memory for node
ENV NODE_OPTIONS --max_old_space_size=3400
RUN yarn run build && rm -r node_modules

FROM application-dashboard-web/composerdeps as composer_build
COPY --from=application-dashboard-web/files ["/data", "./"]
RUN composer dumpautoload --optimize

FROM alpine:3.6
WORKDIR /data
COPY --from=composer_build /data .
COPY --from=webpack_frontend ["/data","./"]
ARG COMMIT_HASH=""
ENV GIT_REVISION_HASH $COMMIT_HASH
CMD [ "sh" ]