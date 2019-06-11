#depends on
# - application-dashboard-web/files

FROM node:10.13.0
WORKDIR /data
COPY --from=application-dashboard-web/files ["/data/package.json","/data/yarn.lock", "./"]
RUN yarn install