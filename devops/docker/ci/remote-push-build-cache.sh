#/bin/sh

# exit when any command fails
set -e

source devops/docker/ci/variables.sh

docker push $WEBPACK_FRONTEND_IMAGE
docker push $COMPOSERBUILD_IMAGE
docker push $APPCODE_IMAGE