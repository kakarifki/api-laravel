#!/bin/sh

cd /var/www/html

# Bersihkan cache Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Atur izin direktori
chmod -R 775 /var/www/html/storage
chown -R www-data:www-data /var/www/html/storage

# Mulai server
exec apache2-foreground