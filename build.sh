#!/bin/bash

# Exit on any error
set -e

echo "🚀 Starting Netlify build process..."

# Install PHP dependencies
echo "📦 Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# Install Node.js dependencies
echo "📦 Installing Node.js dependencies..."
npm ci

# Build frontend assets
echo "🏗️ Building frontend assets..."
npm run build

# Create .env file from environment variables
echo "⚙️ Setting up environment..."
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Generate application key if not set
if ! grep -q "APP_KEY=base64:" .env; then
    echo "🔑 Generating application key..."
    php artisan key:generate --no-interaction
fi

# Set up database
echo "🗄️ Setting up database..."
php netlify-setup.php

# Cache configuration for production
echo "🗄️ Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create storage link
echo "🔗 Creating storage link..."
php artisan storage:link

# Set proper permissions
echo "🔒 Setting permissions..."
chmod -R 755 storage bootstrap/cache

echo "✅ Build completed successfully!"