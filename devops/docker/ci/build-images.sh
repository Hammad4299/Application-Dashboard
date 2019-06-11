#/bin/sh

# exit when any command fails
set -e

source devops/docker/ci/variables.sh

#appcode
docker build $DOCKER_BUILD_PARAMS --build-arg COMMIT_HASH=$CI_COMMIT_SHA $COMMON_DOCKER_CACHE_SOURCES -f devops/docker/other/files/Dockerfile -t $DEFAULT_FILES_IMAGE .
docker build $DOCKER_BUILD_PARAMS --build-arg COMMIT_HASH=$CI_COMMIT_SHA $COMMON_DOCKER_CACHE_SOURCES -f devops/docker/other/nodedeps/Dockerfile -t $DEFAULT_NODEDEPS_IMAGE .
docker build $DOCKER_BUILD_PARAMS --build-arg COMMIT_HASH=$CI_COMMIT_SHA $COMMON_DOCKER_CACHE_SOURCES -f devops/docker/other/composerdeps/Dockerfile -t $DEFAULT_COMPOSERDEPS_IMAGE .
docker build $DOCKER_BUILD_PARAMS --build-arg COMMIT_HASH=$CI_COMMIT_SHA $COMMON_DOCKER_CACHE_SOURCES -f devops/docker/main/appcode/Dockerfile --target=webpack_frontend -t $WEBPACK_FRONTEND_IMAGE -t $DEFAULT_FRONTEND_IMAGE .
docker build $DOCKER_BUILD_PARAMS --build-arg COMMIT_HASH=$CI_COMMIT_SHA $COMMON_DOCKER_CACHE_SOURCES -f devops/docker/main/appcode/Dockerfile --target=composer_build -t $COMPOSERBUILD_IMAGE -t $DEFAULT_COMPOSERBUILD_IMAGE .
docker build $DOCKER_BUILD_PARAMS --build-arg COMMIT_HASH=$CI_COMMIT_SHA $COMMON_DOCKER_CACHE_SOURCES -f devops/docker/main/appcode/Dockerfile -t $APPCODE_IMAGE -t $DEFAULT_APPCODE_IMAGE .

#webserver
# docker build $DOCKER_BUILD_PARAMS --build-arg COMMIT_HASH=$CI_COMMIT_SHA $COMMON_DOCKER_CACHE_SOURCES --cache-from=$APPCODE_WEBSERVER_IMAGE -f ./devops/docker/main/webserver/Dockerfile -t $DEFAULT_WEBSERVER .
# docker build $DOCKER_BUILD_PARAMS --build-arg COMMIT_HASH=$CI_COMMIT_SHA $COMMON_DOCKER_CACHE_SOURCES --cache-from=$APPCODE_WEBSERVER_IMAGE -f ./devops/docker/main/appcode-webserver/Dockerfile -t $APPCODE_WEBSERVER_IMAGE -t $APPCODE_WEBSERVER_IMAGE:$PACKAGE_VERSION .

#without cache-from
docker build $DOCKER_BUILD_PARAMS --build-arg COMMIT_HASH=$CI_COMMIT_SHA $COMMON_DOCKER_CACHE_SOURCES -f ./devops/docker/main/webserver/Dockerfile -t $DEFAULT_WEBSERVER .
docker build $DOCKER_BUILD_PARAMS --build-arg COMMIT_HASH=$CI_COMMIT_SHA $COMMON_DOCKER_CACHE_SOURCES -f ./devops/docker/main/appcode-webserver/Dockerfile -t $APPCODE_WEBSERVER_IMAGE -t $APPCODE_WEBSERVER_IMAGE:$PACKAGE_VERSION .

#executor
# docker build $DOCKER_BUILD_PARAMS --build-arg COMMIT_HASH=$CI_COMMIT_SHA $COMMON_DOCKER_CACHE_SOURCES --cache-from=$APPCODE_EXECUTOR_IMAGE -f ./devops/docker/main/executor/Dockerfile -t $DEFAULT_EXECUTOR .
# docker build $DOCKER_BUILD_PARAMS --build-arg COMMIT_HASH=$CI_COMMIT_SHA $COMMON_DOCKER_CACHE_SOURCES --cache-from=$APPCODE_EXECUTOR_IMAGE -f ./devops/docker/main/appcode-executor/Dockerfile -t $APPCODE_EXECUTOR_IMAGE -t $APPCODE_EXECUTOR_IMAGE:$PACKAGE_VERSION .

#without cache-from
docker build $DOCKER_BUILD_PARAMS --build-arg COMMIT_HASH=$CI_COMMIT_SHA $COMMON_DOCKER_CACHE_SOURCES -f ./devops/docker/main/executor/Dockerfile -t $DEFAULT_EXECUTOR .
docker build $DOCKER_BUILD_PARAMS --build-arg COMMIT_HASH=$CI_COMMIT_SHA $COMMON_DOCKER_CACHE_SOURCES -f ./devops/docker/main/appcode-executor/Dockerfile -t $APPCODE_EXECUTOR_IMAGE -t $APPCODE_EXECUTOR_IMAGE:$PACKAGE_VERSION .