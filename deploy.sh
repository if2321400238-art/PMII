#!/bin/bash

echo "🚀 Memulai proses deployment..."

# 1. Ambil perubahan terbaru dari GitHub
echo "📥 Pulling latest code from GitHub..."
git pull origin main

# 2. Rebuild container (Hanya jika ada perubahan Dockerfile/Config)
echo "📦 Rebuilding containers..."
docker compose up -d --build

# 3. Jalankan migrasi database (Otomatis skip jika tidak ada migrasi baru)
echo "🗄️ Running migrations..."
docker compose exec app php artisan migrate --force

# 4. Bersihkan dan optimalkan cache Laravel
echo "🧹 Clearing and optimizing cache..."
docker compose exec app php artisan config:cache
docker compose exec app php artisan route:cache
docker compose exec app php artisan view:cache

# 5. Perbaiki permission (Opsional, untuk jaga-jaga)
echo "🔒 Fixing permissions..."
docker compose exec app chown -R www-data:www-data storage bootstrap/cache
docker compose exec app chmod -R 775 storage bootstrap/cache

echo "✅ Deployment selesai! Website ISKAB sudah update."
