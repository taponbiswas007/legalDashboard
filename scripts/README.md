# Scripts Quick Guide

## backup-to-git.sh

-   Decompresses latest `/var/www/shared/backups/*.sql.gz` into `/var/www/sk_sharif_github/database/backups`
-   Commits, prunes to last 5, and pushes to GitHub
-   Cron: 20:05 UTC (2:05 AM Bangladesh)

Run manually:

```
/home/sk_sharif/backup-to-git.sh
```

Logs:

```
tail -50 /var/log/sk_sharif_backup_git.log
```

## deploy.sh (robust)

-   Zero-downtime deploy into `/var/www/releases/<timestamp>`
-   Links shared storage + `.env`
-   Installs Composer deps (or copies vendor from current)
-   Runs migrations + optimization
-   Switches `/var/www/sk_sharif` symlink

Prereqs:

-   `REPO_URL` must be set to an authenticated GitHub URL (PAT) or the live repo must have `origin` remote with PAT
-   Composer optional; copies vendor from current if not present

Run manually:

```
REPO_URL="https://<PAT>@github.com/taponbiswas007/sk_sharif_project.git" \
/home/sk_sharif/deploy.sh
```

Logs:

```
tail -100 /var/log/sk_sharif_deploy.log
```
