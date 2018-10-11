#!/bin/sh
#process any injected/added configs by container runtime when running container
cd $VOLUME_PATH
cp -f injected/.env $VOLUME_PATH
cp -f injected/webpack-path-base.config.js $VOLUME_PATH
rm -r injected