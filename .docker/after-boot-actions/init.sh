#!/bin/bash
# these are actions that need to be done after boot, not after build.  This is because we don't have DB access in build
#    because env vars aren't available yet.
APPDIR="/app"

#run composer
cd /app && COMPOSER_HOME="/root" composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction


# Write the config so env variables are used
if ! [ -e /app/app/config/parameters_local.php ]; then
        php /build/.docker/makeconfig.php

        # Make sure our web user owns the config file if it exists
        chown www-data:www-data /app/app/config/parameters_local.php
        /app/app/console cache:clear && chown -R www-data:www-data /app/app/cache/
fi

# set the local config to be in a location thats easy to use a docker volume.
mv /build/.docker/paths_local.php /app/app/config/paths_local.php

chown -R www-data:www-data /app

