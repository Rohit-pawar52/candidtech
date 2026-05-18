FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    curl \
    libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip

# Enable rewrite and allow .htaccess
RUN a2enmod rewrite
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

WORKDIR /var/www/html
COPY . /var/www/html

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Point Apache to /public
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Proper permissions for Laravel at RUNTIME
RUN chown -R www-data:www-data /var/www/html

# Startup script to fix permissions every container start
RUN echo '#!/bin/bash\n\
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache\n\
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache\n\
apache2-foreground' > /start.sh

RUN php artisan migrate --force || true

RUN chmod +x /start.sh

EXPOSE 80
CMD ["/start.sh"]