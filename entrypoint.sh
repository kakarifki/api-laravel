#!/bin/sh
set -e

cd /var/www/html

# Wait for database to be ready
until php artisan db:monitor > /dev/null 2>&1; do
  echo "Waiting for database connection..."
  sleep 1
done

# Run migrations with force
php artisan migrate:fresh --force
php artisan migrate --force

# Set proper permissions for the storage directory
chmod -R 775 /var/www/html/storage
chown -R www-data:www-data /var/www/html/storage

# Run cache commands for production performance
php artisan config:cache
php artisan route:cache
php artisan view:cache

exec apache2-foreground