FROM php:7.4-fpm-alpine
RUN docker-php-ext-install mysqli pdo pdo_mysql
WORKDIR /4room
#EXPOSE 8000
COPY . .
RUN php composer.phar install
RUN php artisan key:generate && \
    php artisan storage:link && \
    php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider" && \
    php artisan jwt:secret
#CMD ["php", "artisan", "serve", "--host=0.0.0.0"]
CMD ["php-fpm"]
