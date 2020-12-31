FROM php:7.4.13-fpm

RUN apt-get update -y && apt-get install -y libmcrypt-dev openssl git unzip

RUN docker-php-ext-install pdo pdo_mysql mysqli

RUN pecl install mcrypt-1.0.3

RUN docker-php-ext-enable mcrypt mysqli pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

CMD bash -c "composer install && php artisan migrate --force && php artisan serve --host 0.0.0.0 --port 8000"

EXPOSE 8000

