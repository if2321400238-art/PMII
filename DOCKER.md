# Laravel on Docker

Project Laravel ini telah dikonfigurasi untuk berjalan di Docker.

## Struktur File Docker

```
.
├── Dockerfile              # Image definition untuk aplikasi Laravel
├── docker-compose.yml      # Orchestration file untuk menjalankan container
├── .dockerignore          # File yang diabaikan saat build
├── .env.docker            # Environment variables untuk Docker
└── docker/
    ├── nginx.conf         # Konfigurasi Nginx
    ├── supervisord.conf   # Konfigurasi Supervisor (manage processes)
    ├── php-fpm.conf       # Konfigurasi PHP-FPM
    └── php.ini            # Konfigurasi PHP
```

## Persiapan

1. **Copy environment file**
   ```bash
   cp .env.docker .env
   ```

2. **Generate Application Key**
   ```bash
   docker-compose run --rm app php artisan key:generate
   ```

3. **Run Migrations**
   ```bash
   docker-compose run --rm app php artisan migrate --force
   ```

## Menjalankan Aplikasi

### Development
```bash
# Build dan start containers
docker-compose up -d

# Lihat logs
docker-compose logs -f

# Stop containers
docker-compose down
```

### Production Build
```bash
# Build dengan no-cache
docker-compose build --no-cache

# Start dalam production mode
docker-compose up -d
```

## Akses Aplikasi

Setelah container berjalan, aplikasi dapat diakses di:
- **URL**: http://localhost:8000

## Perintah Berguna

### Artisan Commands
```bash
# Jalankan artisan command
docker-compose exec app php artisan <command>

# Contoh: Clear cache
docker-compose exec app php artisan cache:clear

# Contoh: Run migrations
docker-compose exec app php artisan migrate
```

### Composer Commands
```bash
# Install dependencies
docker-compose exec app composer install

# Update dependencies
docker-compose exec app composer update
```

### Database
```bash
# Akses SQLite database
docker-compose exec app sqlite3 /var/www/database/database.sqlite
```

### Logs
```bash
# View all logs
docker-compose logs -f

# View specific service logs
docker-compose logs -f app
```

### Shell Access
```bash
# Masuk ke container
docker-compose exec app sh

# Atau sebagai root
docker-compose exec -u root app sh
```

## Services dalam Container

Container menjalankan beberapa services menggunakan Supervisor:
- **PHP-FPM**: Menjalankan aplikasi PHP
- **Nginx**: Web server
- **Queue Worker**: Menjalankan Laravel queue jobs

## Volume Mounts

Data berikut di-mount ke host untuk persistence:
- `./storage` - Application storage
- `./database` - SQLite database file

## Environment Variables

Edit file `.env` untuk mengubah konfigurasi:
- `APP_NAME` - Nama aplikasi
- `APP_ENV` - Environment (local/production)
- `APP_DEBUG` - Debug mode (true/false)
- `APP_URL` - URL aplikasi

## Troubleshooting

### Permission Issues
```bash
# Fix storage permissions
docker-compose exec app chown -R www-data:www-data /var/www/storage
docker-compose exec app chmod -R 775 /var/www/storage
```

### Rebuild Container
```bash
# Rebuild dari scratch
docker-compose down
docker-compose build --no-cache
docker-compose up -d
```

### Clear All Caches
```bash
docker-compose exec app php artisan optimize:clear
```

## Port Configuration

Jika port 8000 sudah digunakan, ubah di `docker-compose.yml`:
```yaml
ports:
  - "8080:80"  # Ubah 8000 ke port lain
```

## Stack Teknologi

- **PHP**: 8.2 (FPM)
- **Web Server**: Nginx
- **Database**: SQLite (default)
- **Process Manager**: Supervisor
- **Node.js**: 20 (untuk build assets)
- **FFmpeg**: untuk kompres video otomatis saat upload
