FROM php:fpm-alpine

RUN set -ex \
  && apk --no-cache add \
    postgresql-dev

RUN docker-php-ext-install pdo pdo_pgsql

WORKDIR /var/www/html

