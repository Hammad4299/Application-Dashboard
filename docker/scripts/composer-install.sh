#!/bin/bash
cd $VOLUME_PATH

if [ ! $SKIP_COMPOSER = "true" ]; then
    composer install
fi