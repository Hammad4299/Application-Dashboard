#/bin/sh

# exit when any command fails
set -e

DEFAULT_FRONTEND_IMAGE="application-dashboard-web/frontend"
DEFAULT_COMPOSERBUILD_IMAGE="application-dashboard-web/composerbuild"
DEFAULT_APPCODE_IMAGE="application-dashboard-web/appcode"
DEFAULT_APPCODE_WEBSERVER_IMAGE="application-dashboard-web/appcode-webserver"
DEFAULT_APPCODE_EXECUTOR_IMAGE="application-dashboard-web/appcode-executor"
DEFAULT_EXECUTOR="application-dashboard-web/executor"
DEFAULT_WEBSERVER="application-dashboard-web/webserver"
DEFAULT_FILES_IMAGE="application-dashboard-web/files"
DEFAULT_NODEDEPS_IMAGE="application-dashboard-web/nodedeps"
DEFAULT_COMPOSERDEPS_IMAGE="application-dashboard-web/composerdeps"

if [ -z "$CI_REGISTRY_IMAGE" ]
then
    WEBPACK_FRONTEND_IMAGE=$DEFAULT_FRONTEND_IMAGE
    COMPOSERBUILD_IMAGE=$DEFAULT_COMPOSERBUILD_IMAGE
    APPCODE_IMAGE=$DEFAULT_APPCODE_IMAGE
else
    WEBPACK_FRONTEND_IMAGE="$CI_REGISTRY_IMAGE/intermediate/webpack_frontend"
    COMPOSERBUILD_IMAGE="$CI_REGISTRY_IMAGE/intermediate/composer_build"
    APPCODE_IMAGE="$CI_REGISTRY_IMAGE/intermediate/appcode"
fi

if [ -z "$DOCKER_REGISTRY_PROJECT_PATH" ]
then
    APPCODE_WEBSERVER_IMAGE=$DEFAULT_APPCODE_WEBSERVER_IMAGE
    APPCODE_EXECUTOR_IMAGE=$DEFAULT_APPCODE_EXECUTOR_IMAGE
else
    APPCODE_WEBSERVER_IMAGE="$DOCKER_REGISTRY_PROJECT_PATH/appcode-webserver"
    APPCODE_EXECUTOR_IMAGE="$DOCKER_REGISTRY_PROJECT_PATH/appcode-executor"
fi

COMMON_DOCKER_CACHE_SOURCES=" "
#COMMON_DOCKER_CACHE_SOURCES=" --cache-from=$WEBPACK_FRONTEND_IMAGE --cache-from=$COMPOSERBUILD_IMAGE --cache-from=$APPCODE_IMAGE "