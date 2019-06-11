#!/bin/sh
# exit when any command fails
set -e

OLD_PATH=$(pwd)
cd $1

if [ ! $SKIP_COMPOSER = "true" ]; then
    composer install
fi

cd $OLD_PATH