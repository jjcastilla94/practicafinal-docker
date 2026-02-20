FROM php:8.2-cli AS base

RUN apt-get update \
    && apt-get install -y git unzip libzip-dev \
    && docker-php-ext-install pdo_mysql zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

FROM base AS development

COPY composer.json composer.lock artisan ./
COPY app ./app
COPY bootstrap ./bootstrap
COPY config ./config
COPY database ./database
COPY routes ./routes
COPY storage ./storage
COPY tests ./tests
COPY public ./public
COPY resources ./resources

RUN composer install --no-interaction --no-scripts \
    && composer dump-autoload

EXPOSE 8000

CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000

FROM base AS production

COPY composer.json composer.lock artisan ./
COPY app ./app
COPY bootstrap ./bootstrap
COPY config ./config
COPY database ./database
COPY routes ./routes
COPY storage ./storage
COPY public ./public
COPY resources ./resources

RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts \
    && composer dump-autoload

EXPOSE 8000

CMD php artisan key:generate --force && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000
