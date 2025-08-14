#!/bin/sh

# Set the working directory to the Laravel project root
cd /var/www/html

# Clear and rebuild cache to ensure all changes are reflected
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Set proper permissions for the storage directory
# This is crucial for log files and session data
chmod -R 775 /var/www/html/storage
chown -R www-data:www-data /var/www/html/storage

# Run one-time setup tasks
php artisan session:table
php artisan migrate --force

# Run cache commands for production performance
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start the Apache web server
exec apache2-foreground