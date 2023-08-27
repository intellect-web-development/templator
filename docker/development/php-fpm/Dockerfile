FROM php:8.2-fpm-alpine

RUN apk add --update linux-headers

RUN apk add --no-cache fcgi bash coreutils libmcrypt-dev autoconf g++ make \
    && pecl install xdebug \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable xdebug

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

RUN chmod 555 /usr/local/bin/wait-for-it

COPY ./development/php-fpm/entrypoint.sh /usr/local/bin/docker-php-entrypoint
RUN chmod +x /usr/local/bin/docker-php-entrypoint

WORKDIR /app