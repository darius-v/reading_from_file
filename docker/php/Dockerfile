FROM php:8.5-fpm

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# Sets the default directory when shelling into the container. The actual mount is defined in docker-compose.yml.
WORKDIR /var/www/html
