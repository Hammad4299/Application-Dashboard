set -e
kubectl config set-cluster k8s --server="${K8S_SERVER}"
kubectl config set clusters.k8s.certificate-authority-data ${K8S_CERTIFICATE_AUTHORITY_DATA}
kubectl config set-credentials ${K8S_USER} --token="${K8S_USER_TOKEN}" --client-certificate="${K8S_USER_CERT_FILE}" --client-key="${K8S_USER_CERT_KEY_FILE}"
kubectl config set-context default --cluster=k8s --user=${K8S_USER}
kubectl config use-context default