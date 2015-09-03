#!/bin/bash
 # from docker-entrypoint on mautic/docker file

# Write the database connection to the config so the installer prefills it
if ! [ -e /app/app/config/local.php ]; then
        php /build/.docker/makeconfig.php "$MAUTIC_DB_HOST" "$MAUTIC_DB_USER" "$MAUTIC_DB_PASSWORD" "$MAUTIC_DB_NAME"

        # Make sure our web user owns the config file if it exists
        chown www-data:www-data /app/app/config/local.php
fi

