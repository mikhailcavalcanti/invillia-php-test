FROM php:7.2.9-fpm-alpine3.8

#RUN apk update; apk upgrade;
RUN docker-php-ext-install mysqli pdo_mysql

# Instala o Composer (https://github.com/geshan/docker-php-composer-alpine)
RUN apk --no-cache add curl git openssh \
    && curl -sSL https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# Instala o Xdebug
RUN apk add --no-cache $PHPIZE_DEPS \
    && pecl install xdebug-2.6.0 \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_connect_back=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && docker-php-ext-enable xdebug
