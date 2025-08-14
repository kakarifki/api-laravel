#!/bin/sh

# Set the working directory to the Laravel project root
cd /var/www/html

# Run one-time setup tasks
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan session:table
php artisan migrate --force

# Start the Apache web server
exec apache2-foreground