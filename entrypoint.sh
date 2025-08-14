#!/bin/sh

cd /var/www/html

# Run one-time setup tasks
php artisan session:table

php artisan migrate:fresh --force

# Set proper permissions for the storage directory
chmod -R 775 /var/www/html/storage
chown -R www-data:www-data /var/www/html/storage

# Run cache commands for production performance
php artisan config:cache
php artisan route:cache
php artisan view:cache

exec apache2-foreground