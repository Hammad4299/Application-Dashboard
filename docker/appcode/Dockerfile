#Stage
FROM alpine:3.6 as files_preparation
WORKDIR /data
COPY . .
COPY ./docker/resources/* ./
RUN rm -rf docker helm deployment

FROM node:8.12.0 as webpack_builder
WORKDIR /data
COPY --from=files_preparation /data/package.json .
COPY --from=files_preparation /data/yarn.lock .
RUN yarn install
COPY --from=files_preparation /data/public ./public
COPY --from=files_preparation ["/data/*.ts","/data/.babelrc","/data/tsconfig.json","/data/postcss.config.js","./"]
COPY --from=files_preparation /data/resources ./resources
RUN yarn run build
RUN rm -r node_modules .awcache

#Stage. Should use same image/environment for building between production and development.
FROM composer:latest as composer_installer
WORKDIR /app
COPY --from=files_preparation /data ./
RUN composer install --optimize-autoloader

# #stage
FROM alpine:3.6
WORKDIR /data
COPY --from=composer_installer /app .
COPY --from=webpack_builder /data .
CMD [ "sh" ]