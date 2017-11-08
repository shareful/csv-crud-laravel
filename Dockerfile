FROM php:7.1-apache

RUN docker-php-ext-install mbstring
RUN a2enmod rewrite

ADD . /var/www
ADD ./public /var/www/html
