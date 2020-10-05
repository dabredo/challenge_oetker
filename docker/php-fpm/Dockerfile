FROM php:fpm-alpine
RUN apk --update --no-cache add git
RUN docker-php-ext-install pdo_mysql
RUN curl --insecure https://getcomposer.org/composer.phar -o /usr/bin/composer && chmod +x /usr/bin/composer

WORKDIR /var/www/app

EXPOSE 9000

CMD ["php-fpm", "-F"]
