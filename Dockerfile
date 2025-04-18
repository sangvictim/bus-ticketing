FROM php:8.3-fpm

# Copy composer.lock and composer.json
COPY composer* /var/www/bus-ticketing/

# Set working directory
WORKDIR /var/www/bus-ticketing

# Install dependencies
RUN apt-get update && apt-get install -y \
  build-essential \
  libpng-dev \
  libonig-dev \
  libzip-dev \
  libjpeg62-turbo-dev \
  libfreetype6-dev \
  locales \
  zip \
  jpegoptim optipng pngquant gifsicle \
  unzip \
  curl \
  libicu-dev


# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_pgsql pgsql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd
RUN docker-php-ext-install intl

# Install the PHP pgsql extention
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
  && docker-php-ext-install pgsql pdo_pgsql

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY . .

# Copy existing application directory permissions
COPY --chown=www:www . .

# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000

CMD ["php-fpm"]