#/bin/sh

# exit when any command fails
set -e

source devops/docker/ci/variables.sh

docker push $APPCODE_EXECUTOR_IMAGE:latest
docker push $APPCODE_EXECUTOR_IMAGE:$PACKAGE_VERSION

docker push $APPCODE_WEBSERVER_IMAGE:latest
docker push $APPCODE_WEBSERVER_IMAGE:$PACKAGE_VERSION