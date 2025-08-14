# Stage 1: Build Image for dependencies
FROM composer:2 AS composer

# Set work directory
WORKDIR /app

# Copy only composer files
COPY composer.json composer.lock ./

# Install dependencies WITHOUT running any scripts
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

# Set permissions and fix storage directory ownership
# This is a robust way to ensure permissions are correct
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && find /var/www/html/storage -type f -exec chmod 664 {} \; \
    && find /var/www/html/storage -type d -exec chmod 775 {} \;

# Copy Apache config and enable mod_rewrite
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# Copy entrypoint script and make it executable
COPY entrypoint.sh .
RUN chmod +x ./entrypoint.sh

# Expose port 80
EXPOSE 80

# The CMD should only run the entrypoint script
CMD ["./entrypoint.sh"]