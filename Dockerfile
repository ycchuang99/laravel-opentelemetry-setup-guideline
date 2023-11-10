FROM php:8.2-fpm-alpine3.18

ARG APP_ENV

WORKDIR /var/www/html

RUN set -eux \
    && apk update \
    && apk upgrade
    
RUN apk add $PHPIZE_DEPS zlib-dev linux-headers  curl unzip openssl-dev --no-cache

RUN set -eux \
    && pecl install redis opentelemetry-beta \
    && docker-php-ext-install pdo_mysql

RUN docker-php-ext-enable redis pdo_mysql opentelemetry

COPY . .

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN set -eux \
    && chmod -R 775 storage; \
    if [ "$APP_ENV" = "local" ]; then \
        composer install; \
    else \
        composer install --no-dev \
        && php artisan config:cache \
        && php artisan event:cache \
        && php artisan route:cache \
        && php artisan view:cache; \
    fi
