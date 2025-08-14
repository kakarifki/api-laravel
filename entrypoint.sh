#!/bin/sh

# Set the working directory to the Laravel project root
cd /var/www/html

# Run one-time setup tasks
# Urutan ini KRUSIAL: Migrasi harus jalan pertama kali.
php artisan migrate --force
php artisan session:table
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set proper permissions for the storage directory
chmod -R 775 /var/www/html/storage
chown -R www-data:www-data /var/www/html/storage

# Start the Apache web server
exec apache2-foreground