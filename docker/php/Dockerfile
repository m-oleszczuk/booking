FROM php:8-fpm-alpine

RUN apk add --update nodejs npm yarn

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions

RUN apk add --update \
    postgresql-dev && \
    docker-php-ext-install pdo pdo_pgsql

RUN wget https://getcomposer.org/installer -O - | php -- --install-dir=/usr/local/bin --filename=composer

ADD php.ini /usr/local/etc/php/php.ini
ADD php-fpm.conf /etc/php/php-fpm.d/

WORKDIR /var/www/booking

EXPOSE 9000

CMD ["php-fpm", "-F"]