FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl \
    && docker-php-ext-install pdo pdo_mysql zip

RUN a2enmod rewrite

WORKDIR /var/www/html
COPY . /var/www/html

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Apache → public folder
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# 🔥 AUTO Laravel setup (no shell needed)
RUN php artisan key:generate || true
RUN php artisan storage:link || true
RUN php artisan config:clear || true
RUN php artisan cache:clear || true

EXPOSE 80