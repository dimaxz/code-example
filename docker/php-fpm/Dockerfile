FROM php:8.0.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y git sendmail libzip-dev zip libpq-dev libpng-dev libjpeg-dev libwebp-dev redis

# Install PHP extensions
RUN docker-php-ext-configure gd --enable-gd --with-webp --with-jpeg  \
    && docker-php-ext-install gd \
    && docker-php-ext-install zip \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install sockets

RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql

RUN apt-get install -y libc-client-dev libkrb5-dev  && rm -r /var/lib/apt/lists/*
RUN docker-php-ext-configure imap --with-imap-ssl --with-kerberos && docker-php-ext-install imap

#RUN docker-php-ext-install imap

# Install xdebug
RUN pecl install xdebug \
 && docker-php-ext-enable xdebug

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy php conf
COPY ./conf.d /usr/local/etc/php/conf.d
COPY ./sendmail/fake_sendmail.sh /usr/local/bin/fake_sendmail.sh
COPY ./sendmail/ /var/mail/sendmail/new/

RUN usermod -u 1000 www-data \
  && chown -R www-data /var/www

RUN mkdir -p /var/mail/sendmail/new/

USER www-data

# Set working directory
WORKDIR /
