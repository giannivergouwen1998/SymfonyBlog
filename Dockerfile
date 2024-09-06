FROM php:8.2.14-fpm as php

FROM php as composer
RUN apt-get update && apt-get install -y \
    git curl \
    zip
COPY --from=composer:2.6.6 /usr/bin/composer /usr/bin/composer
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions \
    pdo_pgsql
