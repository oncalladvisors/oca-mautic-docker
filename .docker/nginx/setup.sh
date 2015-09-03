#!/bin/sh
cp -a /build/.docker/nginx/nginx.conf /etc/nginx/nginx.conf
cp -a /build/.docker/nginx/site-default /etc/nginx/sites-available/default

#sed -i 's/client_max_body_size 10m;/client_max_body_size 50M;/g' /etc/nginx/nginx.conf
sed -i 's/post_max_size = 8M/post_max_size = 50M/g' /etc/php5/fpm/php.ini
sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 50M/g' /etc/php5/fpm/php.ini
