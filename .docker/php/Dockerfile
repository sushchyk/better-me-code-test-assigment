FROM php:8.4-fpm
RUN apt-get update
RUN apt-get install zip libzip-dev libicu-dev libcurl4-openssl-dev pkg-config libssl-dev  libpq-dev -y
ARG UID
ARG GID
ENV UID=${UID}
ENV GID=${GID}
RUN addgroup --gid ${GID} --system symfony
RUN adduser --ingroup symfony --system --disabled-password --shell /bin/sh -u ${UID} symfony
RUN sed -i "s/user = www-data/user = symfony/g" /usr/local/etc/php-fpm.d/www.conf
RUN sed -i "s/group = www-data/group = symfony/g" /usr/local/etc/php-fpm.d/www.conf

COPY . /var/www

RUN chown symfony:symfony /var/www -R
USER symfony

WORKDIR /var/www
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN ls -lart
RUN composer install -vvv --no-scripts

CMD ["php-fpm"]
