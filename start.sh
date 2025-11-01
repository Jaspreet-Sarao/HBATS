#!/bin/bash
set -e

echo " Waiting for MySQL to be ready..."

# Keep checking until the database responds
until php -r "try {
    \$dbh = new PDO('mysql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT') . ';dbname=' . getenv('DB_DATABASE'),
                    getenv('DB_USERNAME'),
                    getenv('DB_PASSWORD'));
    echo ' Database connection successful';
    exit(0);
} catch (Exception \$e) {
    echo ' Waiting for DB...';
    exit(1);
}"; do
  sleep 5
done

echo " Running migrations and seeders..."
php artisan migrate --force || true
php artisan db:seed --force || true

echo " Starting Apache..."
exec apache2-foreground
