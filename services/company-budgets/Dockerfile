FROM php:7.4.10-apache-buster

RUN mkdir /var/www/app

RUN docker-php-ext-install pdo pdo_mysql
RUN a2enmod rewrite