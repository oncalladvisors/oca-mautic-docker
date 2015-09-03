#!/bin/bash
# these are actions that need to be done after boot, not after build.  This is because we don't have DB access in build
#    because env vars aren't available yet.
APPDIR="/app"

#run composer and log to syslog.
cd /app
COMPOSER_HOME="/root" composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction

## run composer in each plugin directory

# http://stackoverflow.com/questions/3769137/use-git-log-command-in-another-folder
# http://briancoyner.github.io/blog/2013/06/05/git-sparse-checkout/
# note: https://github.com/dokku-alt/dokku-alt/issues/74
# run composer at boot so that it goes faster b/c vendor is a docker volumes
cd /app && COMPOSER_HOME="/root" composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction

for d in $APPDIR/plugins/*/*/ ; do
    if [ -f "${d}composer.json" ]; then
        echo "--------------------------------------"
        echo "Running composer for $d"
        echo "--------------------------------------"
        cd $d
        COMPOSER_HOME="/root" composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction
    fi
done

# Back to the main main directory
#cd $APPDIR

### Some laravel cleanup and optimizing
##clear laravel cache
#/usr/bin/php artisan cache:clear
## run october migrations if there is new code
#/usr/bin/php artisan october:up
## optimize it.
#mkdir -p $APPDIR/resources/views #artisan optimize needs this dir
#/usr/bin/php artisan optimize

#make everyting read/writable from www-data
chown -R www-data:www-data /app

/build/docker-entrypoint.sh

