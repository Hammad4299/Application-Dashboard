<?php

return [
    'host'=>env('SOCKETCLUSTER_HOST'),
    'port'=>env('SOCKETCLUSTER_PORT'),
    'secure'=>env('SOCKETCLUSTER_SECURE'),
    'authKey'=>env('SOCKET_CLUSTER_JWT_AUTH_KEY'),
    'algo'=>env('SOCKET_CLUSTER_JWT_ALGO')
];
