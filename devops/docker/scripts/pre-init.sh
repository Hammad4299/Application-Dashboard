#/bin/sh

# cp -r /var/www/injected/secret/.env /var/www  //-r bad command, -a bad command, * won't copy hidden (.) files but seems to work for other files
cp /var/www/injected/secret/.env /var/www
cp /var/www/injected/config/webpack-path-base.config.js /var/www