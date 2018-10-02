#!/bin/sh
cd $SCRIPTS_DIR
sh substitute-static-content-url.sh
sh permission-set.sh
sh laravel-common.sh
sh permission-set.sh
sh rollbar-deploy.sh
sh rollbar-sourcemap-tracking.sh
sh start-php.sh