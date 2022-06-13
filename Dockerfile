FROM php:8.1-apache-buster

RUN apt update && apt install -y libzip-dev
RUN docker-php-ext-install zip

COPY src/ /var/www/html/
