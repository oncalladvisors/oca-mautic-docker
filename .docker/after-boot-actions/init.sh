#!/bin/bash
# these are actions that need to be done after boot, not after build.  This is because we don't have DB access in build
#    because env vars aren't available yet.
APPDIR="/app"

#run composer
cd /app && COMPOSER_HOME="/root" composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction

 # from docker-entrypoint on mautic/docker file

# Write the database connection to the config so the installer prefills it
if ! [ -e /app/app/config/config_local.php ]; then
        php /build/.docker/makeconfig.php "$MAUTIC_DB_HOST" "$MAUTIC_DB_USER" "$MAUTIC_DB_PASSWORD" "$MAUTIC_DB_NAME"

        # Make sure our web user owns the config file if it exists
        chown www-data:www-data /app/app/config/config_local.php
fi

chown -R www-data:www-data /app

