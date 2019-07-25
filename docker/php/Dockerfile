FROM php:7.2-fpm

# Install required librairies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zlib1g-dev \
    libjpeg-dev \
    libpng-dev \
    libfreetype6-dev \
    libpq-dev \
    libgd-dev \
    libwebp-dev \
    libjpeg62-turbo-dev \
    libicu-dev g++

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

# Instal exif for reading data from images
RUN docker-php-ext-install exif

RUN docker-php-ext-install gd

# Configure PHP extensions
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-webp-dir=/usr/include/
RUN docker-php-ext-install -j$(nproc) gd


# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql zip intl

# Import custom php.ini
COPY ./php.ini /usr/local/etc/php/

WORKDIR /var/www/public
