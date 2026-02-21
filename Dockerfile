# Build stage for Node.js assets
FROM node:20-alpine AS node-builder
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build

# PHP production stage
FROM php:8.2-fpm-alpine

# Update dependencies
RUN apk add --no-cache \
    nginx \
    supervisor \
    zip \
    unzip \
    git \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    oniguruma-dev \
    libxml2-dev \
    libzip-dev \
    ffmpeg \
    imagemagick \
    imagemagick-dev

# Install Node.js & npm
RUN apk add --no-cache nodejs npm

# Install imagick from PECL
RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && apk del .build-deps

# Konfigurasi GD agar bisa memproses JPG/PNG
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy application files
COPY --chown=www-data:www-data . .

# Copy built assets from node-builder
COPY --from=node-builder --chown=www-data:www-data /app/public/build ./public/build

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# PERBAIKAN IZIN AKSES & OTOMATISASI STORAGE LINK
RUN mkdir -p /var/www/storage/logs \
    /var/www/storage/framework/{sessions,views,cache} \
    /var/www/bootstrap/cache \
    /var/lib/nginx/tmp/client_body \
    && chown -R www-data:www-data /var/www/storage \
    && chown -R www-data:www-data /var/www/bootstrap/cache \
    && chown -R www-data:www-data /var/lib/nginx \
    && chmod -R 775 /var/www/storage \
    && chmod -R 775 /var/www/bootstrap/cache \
    && chmod -R 775 /var/lib/nginx \
    # Membuat symlink otomatis di dalam image (hapus dulu jika sudah ada)
    && rm -f /var/www/public/storage \
    && ln -s /var/www/storage/app/public /var/www/public/storage

# Create SQLite database directory (jika pakai SQLite)
RUN mkdir -p /var/www/database && \
    touch /var/www/database/database.sqlite && \
    chown -R www-data:www-data /var/www/database && \
    chmod -R 775 /var/www/database

# Ensure fonts directory exists and has correct permissions
RUN mkdir -p /var/www/public/fonts && \
    chown -R www-data:www-data /var/www/public/fonts && \
    chmod -R 755 /var/www/public/fonts

# Copy configuration files
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisord.conf
COPY docker/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
COPY docker/php.ini /usr/local/etc/php/conf.d/custom.ini
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80
CMD ["/usr/local/bin/entrypoint.sh"]
