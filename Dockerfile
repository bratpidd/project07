FROM bitnami/php-fpm:7.3
RUN apt-get update
RUN apt-get -y install php7.3-xdebug
RUN apt-get -y install php-pgsql
COPY ./composer.* ./

COPY ./bin ./bin
COPY ./.env ./.env
COPY . .

COPY ./php.ini /opt/bitnami/php/lib/php.ini
RUN composer install --no-interaction -o