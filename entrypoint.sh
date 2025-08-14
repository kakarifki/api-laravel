#!/bin/sh

# Set the working directory to the Laravel project root
cd /var/www/html

# Run one-time setup tasks
# The 'fresh' command will DROP all tables and re-run migrations from scratch.
# This ensures a clean database state every deployment.
php artisan migrate:fresh --force

# Set proper permissions for the storage directory
chmod -R 775 /var/www/html/storage
chown -R www-data:www-data /var/www/html/storage

# Run cache commands for production performance
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start the Apache web server
exec apache2-foreground