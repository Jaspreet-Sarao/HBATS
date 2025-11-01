#!/bin/sh
set -e

# run migrations
php artisan migrate --force

# seed
php artisan db:seed

# start apache (change this if your image uses something else)
apache2-foreground
