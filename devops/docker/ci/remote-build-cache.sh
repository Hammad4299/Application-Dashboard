#/bin/sh

# exit when any command fails
set -e

source devops/docker/ci/variables.sh

docker pull $WEBPACK_FRONTEND_IMAGE || true
docker pull $COMPOSERBUILD_IMAGE || true
docker pull $APPCODE_IMAGE || true
docker pull $APPCODE_WEBSERVER_IMAGE || true
docker pull $APPCODE_EXECUTOR_IMAGE || true