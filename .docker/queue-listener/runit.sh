#!/bin/sh
cd /app && php artisan queue:listen --env=production --tries=3