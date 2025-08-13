# Stage 1: Build Image for dependencies
FROM composer:2 AS composer

WORKDIR /app

# Copy only composer files
COPY composer.json composer.lock ./

# Install dependencies WITHOUT running any scripts
# INI BAGIAN PENTING YANG DIUBAH
RUN composer install --no-dev --no-scripts --no-autoloader

# Copy the entire application to use its files
COPY . .

# Generate the autoloader based on the full application
RUN composer dump-autoload --optimize --no-dev

# Stage 2: Production Image with Apache
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Install necessary system dependencies...
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    nodejs \
    npm \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd

# Copy the entire application from the current directory
COPY . .

# Copy Composer dependencies from the build stage
COPY --from=composer /app/vendor /var/www/html/vendor

# Build frontend assets...
RUN npm install && npm run build


# Set permissions...
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

# Tambahan baru: copy konfigurasi Apache dan aktifkan mod_rewrite
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# Expose port 80 and start Apache
EXPOSE 80
CMD ["apache2-foreground"]