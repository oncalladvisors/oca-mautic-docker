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
fi

chown -R www-data:www-data /app

