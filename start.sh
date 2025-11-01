#!/bin/bash
set -e

echo "Running migrations and seeds..."
php artisan migrate --force
php artisan db:seed --force

echo "Starting Apache..."
apache2-foreground
