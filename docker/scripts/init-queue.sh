#!/bin/sh
cd $SCRIPTS_DIR
sh substitute-static-content-url.sh
sh permission-set.sh
sh laravel-common.sh
sh start-queue.sh