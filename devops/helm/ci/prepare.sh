# exit when any command fails
set -e

export image_repo=${DOCKER_REGISTRY_PROJECT_PATH}/appcode-webserver
export image_tag=$PACKAGE_VERSION
export image_executor_repo=${DOCKER_REGISTRY_PROJECT_PATH}/appcode-executor
export image_executor_tag=$PACKAGE_VERSION

apk add --update libintl && \
    apk add --virtual build_deps gettext git &&  \
    cp /usr/bin/envsubst /usr/local/bin/envsubst

mv devops/helm/charts/application-dashboard-web/values.yaml devops/helm/charts/application-dashboard-web/tmpvalues.yaml \
    && envsubst '${image_repo} ${image_tag} ${image_executor_repo} ${image_executor_tag}' < devops/helm/charts/application-dashboard-web/tmpvalues.yaml > devops/helm/charts/application-dashboard-web/values.yaml \
    && rm devops/helm/charts/application-dashboard-web/tmpvalues.yaml