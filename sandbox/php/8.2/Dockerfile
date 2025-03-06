FROM php:8.2-fpm-alpine

# Установка необходимых зависимостей и расширений PHP
RUN apk add --no-cache \
    bash \
    git \
    icu-dev \
    libzip-dev \
    oniguruma-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql mysqli intl zip

# Clean
RUN rm -rf /var/cache/apk/* && docker-php-source delete

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    composer self-update

USER root

WORKDIR /var/www/
