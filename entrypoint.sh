#!/bin/sh

cd /var/www/html

chmod -R 775 /var/www/html/storage
chown -R www-data:www-data /var/www/html/storage

php artisan config:cache
php artisan route:cache
php artisan view:cache

exec apache2-foreground