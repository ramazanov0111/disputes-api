FROM php:8.0.3-fpm-alpine

RUN apk update && apk add --no-cache git zip postgresql-dev && \
    docker-php-ext-install pdo_pgsql opcache bcmath sockets
RUN mkdir -p /usr/src/php/ext/redis \
    && curl -L https://github.com/phpredis/phpredis/archive/5.3.4.tar.gz | tar xvz -C /usr/src/php/ext/redis --strip 1 \
    && echo 'redis' >> /usr/src/php-available-exts \
    && docker-php-ext-install redis
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./.docker/php/php.ini /usr/local/etc/php
WORKDIR /app
COPY ./ .
RUN composer install --ignore-platform-reqs --optimize-autoloader --no-scripts && rm -rf /root/.composer
CMD ["php-fpm"]
