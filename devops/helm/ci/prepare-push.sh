# exit when any command fails
set -e

sh devops/helm/ci/prepare.sh
helm init --client-only
helm plugin install https://github.com/chartmuseum/helm-push
helm repo add chart-repo $TERACEPTION_HELM_CHARTS