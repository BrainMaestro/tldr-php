FROM composer:1.5

COPY ./composer.json ./composer.lock /vendor/

WORKDIR /vendor

RUN composer install

WORKDIR /app

ENTRYPOINT ["./docker-entrypoint.sh"]
