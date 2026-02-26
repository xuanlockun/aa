#!/bin/sh
pecl install redis
php artisan migrate --force
php artisan db:seed --force
php-fpm