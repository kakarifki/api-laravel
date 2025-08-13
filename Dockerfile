# Stage 1: Build Image for dependencies
FROM composer:2 AS composer

# Set work directory
WORKDIR /app

# Copy composer.json and composer.lock
COPY composer.json composer.lock ./

# Install Composer dependencies
RUN composer install --no-dev --optimize-autoloader

# Stage 2: Production Image with Apache
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Install necessary system dependencies
# Memasukkan ekstensi PostgreSQL (libpq-dev dan pdo_pgsql)
# Menambahkan npm untuk frontend
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

# Build frontend assets if you are using them (e.g., Vite)
# Jalankan ini jika Anda memiliki aset frontend yang perlu di-build
RUN npm install && npm run build

# Generate application key
RUN php artisan key:generate

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

# Expose port 80 and start Apache
EXPOSE 80
CMD ["apache2-foreground"]