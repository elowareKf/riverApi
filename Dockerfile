FROM php:7-fpm-alpine
RUN docker-php-ext-install mysqli
COPY ./src/composer.phar .
RUN chmod +x composer.phar
CMD [ "./composer.phar install" ]