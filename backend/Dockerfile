FROM php:8.5-apache

# Install PDO MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Enable mod_rewrite
RUN a2enmod rewrite

WORKDIR /var/www/html
