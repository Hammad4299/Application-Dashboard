#!/bin/sh
cd $SCRIPTS_DIR
sh substitute-static-content-url.sh
sh laravel-common.sh
sh permission-set.sh
sh start-cron.sh