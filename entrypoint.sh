#!/bin/sh

# Set the working directory to the Laravel project root
cd /var/www/html

# Clear any lingering cache from previous deployments
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Run one-time setup tasks
# Create the sessions table migration file
php artisan session:table

# Run all pending migrations
php artisan migrate --force

# Set proper permissions for the storage directory
chmod -R 775 /var/www/html/storage
chown -R www-data:www-data /var/www/html/storage

# Run cache commands for production performance
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start the Apache web server
exec apache2-foreground