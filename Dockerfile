FROM php:8.2-fpm

COPY php.conf.ini /usr/local/etc/php/conf.d/custom.ini

RUN apt-get update
RUN apt-get install -y libpq-dev libpng-dev curl unzip zip git jq supervisor
RUN docker-php-ext-install bcmath

# install composer v2
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=2.7.7

WORKDIR /var/www/html