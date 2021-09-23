FROM bitnami/php-fpm:7.3
RUN apt-get update
RUN apt-get -y install php7.3-xdebug
RUN apt-get -y install php-pgsql
COPY ./composer.* ./
RUN composer install --no-dev --no-interaction -o --ignore-platform-reqs --no-scripts