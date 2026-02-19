#!/usr/bin/env bash

set -Eeuo pipefail

FORCE_RESET=false

for arg in "$@"; do
	case "$arg" in
		--force-reset)
			FORCE_RESET=true
			;;
		*)
			echo "Argumen tidak dikenal: $arg"
			echo "Gunakan: ./deploy.sh [--force-reset]"
			exit 1
			;;
	esac
done

log() {
	echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1"
}

run_dc() {
	docker compose "$@"
}

log "🚀 Memulai deployment Docker PMII"

if [[ ! -f docker-compose.yml ]]; then
	log "❌ File docker-compose.yml tidak ditemukan. Jalankan script dari root project."
	exit 1
fi

log "🔍 Cek perubahan lokal repository"
if [[ -n "$(git status --porcelain)" ]]; then
	if [[ "$FORCE_RESET" == true ]]; then
		log "⚠️ Repository kotor, menjalankan hard reset karena --force-reset"
		git fetch origin
		git reset --hard origin/main
		git clean -fd
	else
		log "❌ Repository punya perubahan lokal."
		log "   Jalankan ./deploy.sh --force-reset untuk pakai state origin/main sepenuhnya."
		exit 1
	fi
else
	log "📥 Pull code terbaru"
	git pull origin main
fi

log "🏗️ Build image app terbaru"
run_dc build app

log "⬆️ Jalankan/update container"
run_dc up -d

log "⏳ Tunggu service app siap"
for _ in {1..20}; do
	if run_dc exec -T app php -v >/dev/null 2>&1; then
		break
	fi
	sleep 2
done

log "🧩 Install dependency Node + build assets (di dalam container app)"
run_dc exec -T app npm ci
run_dc exec -T app npm run build

log "🔒 Perbaiki permission storage dan cache"
run_dc exec -T -u root app sh -lc "chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache /var/www/public/build && chmod -R ug+rwX /var/www/storage /var/www/bootstrap/cache /var/www/public/build"

log "🗄️ Jalankan migrasi"
run_dc exec -T app php artisan migrate --force

log "🧹 Bersihkan dan bangun ulang cache Laravel"
run_dc exec -T app php artisan optimize:clear
run_dc exec -T app php artisan storage:link || true
run_dc exec -T app php artisan config:cache
run_dc exec -T app php artisan route:cache
run_dc exec -T app php artisan view:cache

log "✅ Deployment selesai"
log "📌 Verifikasi cepat: docker compose ps"
