#!/bin/bash

echo "🔧 Running composer install..."
composer install --no-interaction --prefer-dist

echo "📦 Running npm install..."
npm install

echo "🗝 Generating app key if needed..."
php artisan key:generate --quiet || true

echo "🚀 Starting Laravel development server..."
exec php artisan serve --host=0.0.0.0 --port=8000