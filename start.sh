#!/usr/bin/env bash
set -euo pipefail

rm -f public/hot || true

php -v || true

# Ensure key exists via env; do not generate here.

# Run database migrations safely for review deployments.
php artisan migrate --force || true

# Ensure storage symlink (ignore if exists).
php artisan storage:link || true

# Generate Passport keys if missing (API only).
if [ ! -f storage/oauth-private.key ] || [ ! -f storage/oauth-public.key ]; then
  php artisan passport:keys --length=4096 --force || true
fi

# Serve the app from public/ using PHP's built-in server.
php -d variables_order=EGPCS -S 0.0.0.0:${PORT:-8000} -t public

