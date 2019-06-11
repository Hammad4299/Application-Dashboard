# exit when any command fails
set -e

octo create-release --project="$OCTOPUS_PROJECT" --channel="kubernetes" --releaseNumber="$RELEASE_VERSION" --package="$OCTOPUS_PACKAGE_ID:$PACKAGE_VERSION" --server="$OCTOPUS_SERVER"  --apiKey="$OCTOPUS_API_KEY"
octo deploy-release --project="$OCTOPUS_PROJECT" --deployto="$DEPLOY_ENVIRONMENT" --variable="rollbar_code_version:$CI_COMMIT_SHA" --version="$RELEASE_VERSION" --server="$OCTOPUS_SERVER"  --apiKey="$OCTOPUS_API_KEY"