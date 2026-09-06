FROM php:8.2-apache

# Install PHP extensions your app needs
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip libpq-dev && \
    docker-php-ext-install pdo pdo_mysql pdo_pgsql zip


# Install composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy your Laravel app code to /var/www/html
COPY . /var/www/html/

# Change working directory
WORKDIR /var/www/html

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Set Apache to serve from public folder
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# Set permissions for storage and cache folders
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Copy entrypoint script and make it executable
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Expose port 80
EXPOSE 80

# Run the entrypoint script
CMD ["/usr/local/bin/docker-entrypoint.sh"]