FROM php:8.3-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip curl libpng-dev libonig-dev libxml2-dev zip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Node.js (LTS) + npm
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create working directory
WORKDIR /var/www

# Start Laravel dev server
CMD php artisan serve --host=0.0.0.0 --port=8000