FROM php:7.2-fpm-stretch

RUN apt-get update \
        && apt-get install -y curl apt-transport-https gnupg2 \
        && curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add - \
        && curl https://packages.microsoft.com/config/debian/9/prod.list > /etc/apt/sources.list.d/mssql-release.list \
        && apt-get update \
        && ACCEPT_EULA=Y apt-get install -y msodbcsql17 mssql-tools unixodbc-dev

RUN apt update \
	&& apt install -y \
	    sudo \
		zip \
		unzip \
		nano \
		wget \
		mysql-client \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libwebp-dev \
        libvpx-dev \
		zlib1g-dev \
		libicu-dev \
		libpng-dev \
		libxpm-dev \
		libmemcached-dev \
		g++ \
		cron \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

# Run docker-php-ext-install for available extensions
RUN docker-php-ext-configure intl \
    && docker-php-ext-configure gd \
           --with-gd \
           --with-webp-dir \
           --with-jpeg-dir \
           --with-png-dir \
           --with-zlib-dir \
           --with-xpm-dir \
           --with-freetype-dir \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo pdo_mysql opcache zip intl sockets


ADD ./docker/dev/php/php.ini /usr/local/etc/php/php.ini

# install xdebug
RUN pecl install xdebug sqlsrv pdo_sqlsrv
RUN docker-php-ext-enable xdebug sqlsrv pdo_sqlsrv \
    && echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_enable = 1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_connect_back = 1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.idekey = \"PHPSTORM\"" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
#    && echo "xdebug.remote_port = 9001" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "memory_limit = 1024M" >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini

COPY ./docker/dev/php/php_init.sh /usr/bin/
RUN chmod +x /usr/bin/php_init.sh
