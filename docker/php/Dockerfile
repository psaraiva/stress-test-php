FROM php:7.4.27-zts

# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    iputils-ping \
    htop \
    nmap \
    curl \
    git \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    libmagickwand-dev --no-install-recommends \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

RUN printf "\n" | pecl install imagick
RUN docker-php-ext-enable imagick

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY ./src /var/www/

RUN chmod 755 /var/www/

WORKDIR /var/www/
