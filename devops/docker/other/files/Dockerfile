#put all relevant files in /data. All unnecessary files should be removed or moved to elsewhere as not to mess with build cache
FROM alpine:3.6
WORKDIR /data
COPY . .
COPY ./devops /devops
RUN rm -rf devops