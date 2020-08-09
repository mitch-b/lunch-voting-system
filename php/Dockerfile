FROM php:7.1-fpm-alpine3.4

# runtime dependencies
RUN apk update --no-cache \
    && apk add --no-cache $PHPIZE_DEPS \
    && apk add --no-cache mysql-dev \
    && docker-php-ext-install pdo pdo_mysql \
    && pear install Mail

WORKDIR /app
