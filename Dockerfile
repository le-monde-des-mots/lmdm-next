FROM php:8-alpine
RUN apk add --update linux-headers make
RUN apk add --no-cache --virtual .build-deps \
    autoconf \
    g++ \
    libzip-dev \
    zlib-dev \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug