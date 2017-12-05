FROM composer:1.5

COPY ./composer.json ./composer.lock /app/

RUN composer install

COPY . /app

RUN ./vendor/bin/phpunit
