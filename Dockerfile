FROM php:7.2-apache

WORKDIR /var/www/

RUN rmdir /var/www/html && \
    apt-get update && \
    apt-get install -y libpng-dev jpegoptim optipng pngquant gifsicle && \
    docker-php-ext-install gd pdo_mysql && \
    a2enmod rewrite remoteip && \
    rm -rf /var/lib/apt/lists/*

COPY docker/webserver/000-default.conf /etc/apache2/sites-available/
COPY docker/webserver/ports.conf /etc/apache2/
COPY src /var/www/
