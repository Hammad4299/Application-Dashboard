#!/bin/sh
curl https://api.rollbar.com/api/1/deploy/ \
  -F access_token=$ROLLBAR_TOKEN \
  -F environment=$APP_ENV \
  -F rollbar_username=$ROLLBAR_USERNAME \
  -F local_username=$LOCAL_USERNAME \
  -F revision=$GIT_REVISION_HASH