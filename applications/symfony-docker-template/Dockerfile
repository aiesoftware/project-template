FROM php:8.0-fpm

ARG XDEBUG
WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    git \
    libxml2-dev \
    libzip-dev \
    unzip \
    vim \
    zip

RUN docker-php-ext-install pdo_mysql zip intl

RUN if [ ${XDEBUG} ] ; then \
	pecl install xdebug && \
	docker-php-ext-enable xdebug \
	  && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
	  && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
	  && echo "xdebug.idekey=PHPSTORM" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
	  && echo "xdebug.client_host=docker.for.mac.localhost" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
	  && echo "xdebug.client_port=9002" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
	  && echo "xdebug.discover_client_host=true" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini ;\
fi;

COPY --from=composer /usr/bin/composer /usr/bin/composer

EXPOSE 9000
CMD ["php-fpm"]
