#!/bin/bash

set -e  # Exit on error

echo "🚀 Memulai proses deployment..."

# 1. Ambil perubahan terbaru dari GitHub
echo "📥 Pulling latest code from GitHub..."
git pull origin main

# 2. Rebuild container
echo "📦 Rebuilding containers..."
docker compose down
docker compose build --no-cache
docker compose up -d

# 3. Tunggu MySQL ready
echo "⏳ Waiting for MySQL to be ready..."
sleep 10

# 4. Jalankan migrasi database
echo "🗄️ Running migrations..."
docker compose exec app php artisan migrate --force

# 5. Bersihkan dan optimalkan cache Laravel
echo "🧹 Clearing and optimizing cache..."
docker compose exec app php artisan config:cache
docker compose exec app php artisan route:cache
docker compose exec app php artisan view:cache
docker compose exec app php artisan storage:link 2>/dev/null || true

# 6. Perbaiki permission
echo "🔒 Fixing permissions..."
docker compose exec app chown -R www-data:www-data storage bootstrap/cache public/fonts
docker compose exec app chmod -R 775 storage bootstrap/cache
docker compose exec app chmod -R 755 public/fonts

echo "✅ Deployment selesai! Website PMII sudah update."
echo "🌐 Akses website di: http://$(hostname -I | awk '{print $1}')"
