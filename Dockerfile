FROM php:7.4-apache


COPY PHPMailer-master /var/www/html/PHPMailer-master

COPY . /var/www/html/

EXPOSE 80
