#!/bin/sh

# Set the working directory to the Laravel project root
cd /var/www/html

# Run one-time setup tasks
# These commands will run when the container starts, and can access
# environment variables from Render.
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan session:table
php artisan migrate --force

# Start the Apache web server
# The 'exec' command ensures that the main process in the container is Apache.
exec apache2-foreground