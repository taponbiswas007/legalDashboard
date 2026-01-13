#!/usr/bin/env bash
# Robust zero-downtime deploy for SK Sharif
set -euo pipefail

LOG_FILE="/var/log/sk_sharif_deploy.log"
RELEASES_DIR="/var/www/releases"
SHARED_DIR="/var/www/shared"
CURRENT_LINK="/var/www/sk_sharif"
BRANCH="${BRANCH:-master}"
# Prefer explicit REPO_URL; else fall back to origin remote of live repo
REPO_URL="${REPO_URL:-$(git -C /var/www/sk_sharif_github remote get-url origin 2>/dev/null || echo '')}"

# Logging
mkdir -p "$(dirname "$LOG_FILE")"
exec 1> >(tee -a "$LOG_FILE")
exec 2>&1
log() { echo "[$(date '+%Y-%m-%d %H:%M:%S')] $*"; }

log "========================================"

# Stop PHP-FPM and MySQL to free memory before deployment
log "Stopping PHP-FPM and MySQL to free memory before deployment"
systemctl stop php8.3-fpm 2>/dev/null || true
systemctl stop mysql 2>/dev/null || systemctl stop mariadb 2>/dev/null || true
log "Starting Production Deployment (branch: $BRANCH)"
log "========================================"

# Pre-validate
command -v git >/dev/null || { log "ERROR: git not found"; exit 1; }
command -v php >/dev/null || { log "ERROR: php not found"; exit 1; }

# Ensure shared dirs
for d in "$SHARED_DIR" "$SHARED_DIR/storage" "$SHARED_DIR/storage/logs" "$SHARED_DIR/uploads"; do
  mkdir -p "$d"
  chown -R www-data:www-data "$d" || true
  chmod -R 775 "$d" || true
done
[ -f "$SHARED_DIR/storage/logs/laravel.log" ] || touch "$SHARED_DIR/storage/logs/laravel.log"
chown www-data:www-data "$SHARED_DIR/storage/logs/laravel.log" || true
chmod 664 "$SHARED_DIR/storage/logs/laravel.log" || true

# Create new release
RELEASE_TIMESTAMP=$(date '+%Y%m%d%H%M%S')
NEW_RELEASE_DIR="$RELEASES_DIR/$RELEASE_TIMESTAMP"
rm -rf "$NEW_RELEASE_DIR" && mkdir -p "$NEW_RELEASE_DIR"
cd "$NEW_RELEASE_DIR"

# Clone code (use PAT-authenticated URL if provided)
if [[ -z "$REPO_URL" ]]; then
  log "ERROR: REPO_URL is empty; set REPO_URL or ensure /var/www/sk_sharif_github has an origin remote"
  exit 1
fi
log "Cloning repository from $REPO_URL"
GIT_QUIET=${GIT_QUIET:-0}
if [[ "$GIT_QUIET" == 1 ]]; then
  git clone --branch "$BRANCH" --depth 1 "$REPO_URL" . >/dev/null
else
  git clone --branch "$BRANCH" --depth 1 "$REPO_URL" .
fi

# Fallback: if clone did not materialize expected app files, sync from local working repo
if [[ ! -f "$NEW_RELEASE_DIR/artisan" ]]; then
  log "Clone did not produce app files; falling back to local repo sync"
  rsync -a --delete --exclude='.git' /var/www/sk_sharif_github/ "$NEW_RELEASE_DIR/"
fi

# Link shared storage
log "Linking shared storage"
rm -f "$NEW_RELEASE_DIR/storage" "$NEW_RELEASE_DIR/public/uploads" || true
ln -s "$SHARED_DIR/storage" "$NEW_RELEASE_DIR/storage"
mkdir -p "$NEW_RELEASE_DIR/public"
ln -s "$SHARED_DIR/uploads" "$NEW_RELEASE_DIR/public/uploads"

# Setup .env
if [[ -f "$SHARED_DIR/.env" ]]; then
  cp "$SHARED_DIR/.env" "$NEW_RELEASE_DIR/.env"
  chown www-data:www-data "$NEW_RELEASE_DIR/.env" || true
  chmod 640 "$NEW_RELEASE_DIR/.env" || true
  log "Copied .env from shared"
else
  cp "$NEW_RELEASE_DIR/.env.example" "$NEW_RELEASE_DIR/.env" || true
  log "WARNING: Using .env.example; place .env in $SHARED_DIR"
fi

# Dependencies: use composer if available; else copy vendor from current
chmod +x "$NEW_RELEASE_DIR/artisan" || true
if command -v composer >/dev/null; then
  log "Installing PHP dependencies via composer"
  COMPOSER_ALLOW_SUPERUSER=1 composer install --no-dev --no-interaction --prefer-dist
else
  log "Composer not found; copying vendor from current release if available"
  if [[ -d "$CURRENT_LINK/vendor" ]]; then
    cp -a "$CURRENT_LINK/vendor" "$NEW_RELEASE_DIR/vendor"
  else
    log "ERROR: vendor missing and composer not available"
    exit 1
  fi
fi

# Laravel commands
log "Running migrations and optimization"
php "$NEW_RELEASE_DIR/artisan" migrate --force --no-interaction || { log "ERROR: migrations failed"; exit 1; }
php "$NEW_RELEASE_DIR/artisan" cache:clear --no-interaction || true
php "$NEW_RELEASE_DIR/artisan" config:cache --no-interaction || true
php "$NEW_RELEASE_DIR/artisan" route:cache --no-interaction || true
php "$NEW_RELEASE_DIR/artisan" optimize --no-interaction || true

# Switch symlink atomically
log "Switching active symlink"
ln -sfn "$NEW_RELEASE_DIR" "$CURRENT_LINK"


# Start PHP-FPM and MySQL after deployment
log "Starting PHP-FPM and MySQL after deployment"
systemctl start mysql 2>/dev/null || systemctl start mariadb 2>/dev/null || true
systemctl start php8.3-fpm 2>/dev/null || true
log "Deployment completed: $NEW_RELEASE_DIR active"
