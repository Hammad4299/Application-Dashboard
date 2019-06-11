# exit when any command fails
set -e

sh devops/helm/ci/prepare-push.sh

for i in $(ls devops/helm/charts); do
    helm push devops/helm/charts/$i chart-repo --version=$PACKAGE_VERSION
done