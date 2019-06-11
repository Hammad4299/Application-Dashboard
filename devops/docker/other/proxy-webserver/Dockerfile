FROM application-dashboard-web/webserver

COPY --from=application-dashboard-web/files ["/devops/docker/other/proxy-webserver/proxy.conf","/etc/nginx/conf.d"]
COPY --from=application-dashboard-web/files ["/devops/docker/scripts","/scripts"]
ENV upsteam_url http://*
CMD [ "sh", "/scripts/main/proxy-init.sh" ]