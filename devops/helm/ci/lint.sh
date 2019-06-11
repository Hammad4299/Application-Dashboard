#/bin/sh
# exit when any command fails
set -e

sh devops/helm/ci/prepare-lint.sh
for i in $(ls devops/helm/charts); do
    helm lint devops/helm/charts/$i
done