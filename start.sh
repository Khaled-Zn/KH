#!/bin/sh

php artisan key:generate
php artisan route:cache
php artisan config:cache

service cron start