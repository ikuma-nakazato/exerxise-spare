FROM php:7.2-apache
COPY php.ini /usr/local/etc/php/

RUN apt-get update \
    && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
        git \
        aptitude \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        mysqli \
        mbstring \
        gd \
        iconv
RUN aptitude install -y mecab
RUN aptitude install -y mecab-ipadic-utf8
RUN a2enmod rewrite
