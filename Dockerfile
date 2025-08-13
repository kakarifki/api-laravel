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

WORKDIR /var/www/html

# Install system dependencies
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
    && docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy application files with vendor from the first stage
COPY --from=composer /app .

# Build frontend assets if you are using them (e.g., Vite)
RUN npm install && npm run build

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port 80 and start Apache
EXPOSE 80
CMD ["apache2-foreground"]