#!/usr/bin/env bash
set -euo pipefail

# Push the latest DB backup into the git repo database/backups and prune old ones
# Expected layout:
#   - Source backups (.sql.gz) at /var/www/shared/backups/sk_sharif_YYYYMMDD_HHMMSS.sql.gz
#   - Git repo at /var/www/sk_sharif_github (remote "github" → https://github.com/taponbiswas007/sk_sharif_project.git)
#   - Destination inside repo: database/backups/sk_sharif_YYYYMMDD_HHMMSS.sql

REPO_DIR="/var/www/sk_sharif_github"
SRC_DIR="/var/www/shared/backups"
DEST_DIR="$REPO_DIR/database/backups"
MAX_GITHUB_BACKUPS=5

log() { echo "[$(date -u +'%Y-%m-%d %H:%M:%S UTC')] $*"; }

log "Starting backup-to-git push"

# Ensure repo exists and mark safe to fix 'dubious ownership'
if [[ ! -d "$REPO_DIR/.git" ]]; then
  log "ERROR: $REPO_DIR is not a git repository"
  exit 1
fi

# Make directory safe for cron user
git config --global --add safe.directory "$REPO_DIR" || true

# Find latest .sql.gz created by the nightly backup job
LATEST_GZ=$(ls -t "$SRC_DIR"/sk_sharif_*.sql.gz 2>/dev/null | head -1 || true)
if [[ -z "${LATEST_GZ:-}" ]]; then
  log "ERROR: No .sql.gz files found in $SRC_DIR"
  exit 1
fi

BASENAME=$(basename "$LATEST_GZ" .gz)          # sk_sharif_YYYYMMDD_HHMMSS.sql
TARGET_SQL="$DEST_DIR/$BASENAME"

# Prepare destination dir in repo
mkdir -p "$DEST_DIR"

# Decompress into repo as .sql
log "Decompressing $LATEST_GZ → $TARGET_SQL"
gunzip -c "$LATEST_GZ" > "$TARGET_SQL"
chmod 644 "$TARGET_SQL"

# Enter repo and ensure 'github' remote exists
cd "$REPO_DIR"
if ! git remote | grep -q "^github$"; then
  git remote add github https://github.com/taponbiswas007/sk_sharif_project.git
fi

# Add new backup and prune older ones beyond MAX_GITHUB_BACKUPS
log "Staging new backup"
git add "database/backups/$(basename "$TARGET_SQL")"

log "Pruning backups to last $MAX_GITHUB_BACKUPS"
COUNT=$(ls -t database/backups/*.sql 2>/dev/null | wc -l | tr -d ' ')
if [[ "$COUNT" -gt "$MAX_GITHUB_BACKUPS" ]]; then
  TO_DELETE=$(ls -t database/backups/*.sql | tail -n +$((MAX_GITHUB_BACKUPS+1)))
  for f in $TO_DELETE; do
    log "Removing old backup $f"
    git rm -f "$f" || rm -f "$f"
  done
fi

# Commit and push if there are changes
if ! git diff --cached --quiet || ! git diff --quiet; then
  COMMIT_MSG="Database backup: $(date -u +'%Y-%m-%d %H:%M:%S UTC')"
  log "Committing: $COMMIT_MSG"
  git commit -m "$COMMIT_MSG" || true
  log "Pushing to GitHub (origin)"
  git push origin master
  log "Push complete"
else
  log "No changes to commit"
fi

log "Done"
