set -e
helm init --client-only
helm repo add chart-repo $TERACEPTION_HELM_CHARTS
helm upgrade $HELM_RELEASE_NAME chart-repo/$HELM_CHART_NAME -f $HELM_CHART_VALUES_FILE --install --version $PACKAGE_VERSION  --tls --tls-ca-cert $HELM_CA_CERT --tls-cert $HELM_CERT --tls-key $HELM_CERT_KEY