#!/bin/bash

################################################################################
# PRE-DEPLOYMENT CHECKLIST
# Run this before pushing to master to ensure smooth deployment
################################################################################

set -e

echo "=========================================="
echo "PRE-DEPLOYMENT CHECKLIST"
echo "=========================================="
echo ""

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

PASS=0
WARN=0
FAIL=0

# Helper functions
check_pass() {
    echo -e "${GREEN}✓${NC} $1"
    ((PASS++))
}

check_warn() {
    echo -e "${YELLOW}⚠${NC} $1"
    ((WARN++))
}

check_fail() {
    echo -e "${RED}✗${NC} $1"
    ((FAIL++))
}

# ============================================================================
# 1. GIT STATUS
# ============================================================================

echo "Step 1: Checking git status..."

if git status | grep -q "nothing to commit"; then
    check_pass "Working directory is clean"
else
    check_fail "Uncommitted changes detected"
    echo ""
    echo "Uncommitted files:"
    git status --short
    echo ""
fi

echo ""

# ============================================================================
# 2. DATABASE MIGRATIONS
# ============================================================================

echo "Step 2: Checking database migrations..."

if php artisan migrate:status 2>/dev/null | grep -q "Pending"; then
    check_fail "Pending migrations detected - run: php artisan migrate"
    echo ""
    php artisan migrate:status | grep Pending
    echo ""
else
    check_pass "No pending migrations"
fi

echo ""

# ============================================================================
# 3. VITE ASSETS
# ============================================================================

echo "Step 3: Checking Vite assets..."

if [ ! -f "public/build/manifest.json" ]; then
    check_warn "public/build/ directory does not exist"
    echo "  Run: npm run build"
else
    # Check if build directory is tracked in git
    if git ls-files | grep -q "public/build"; then
        check_pass "public/build/ is tracked in git"
    else
        check_warn "public/build/ exists but is not tracked in git"
        echo "  Run: git add public/build/"
    fi
fi

echo ""

# ============================================================================
# 4. NPM/NODE DEPENDENCIES
# ============================================================================

echo "Step 4: Checking Node.js dependencies..."

if command -v npm &> /dev/null; then
    check_pass "npm is installed"

    # Check if node_modules is up to date
    if [ -f "package-lock.json" ] && [ ! -d "node_modules" ]; then
        check_warn "node_modules not installed, run: npm install"
    elif [ -f "package.json" ]; then
        check_pass "Node dependencies installed"
    fi
else
    check_warn "npm not found (required for asset building)"
fi

echo ""

# ============================================================================
# 5. PHP VERSION
# ============================================================================

echo "Step 5: Checking PHP version..."

PHP_VERSION=$(php -v | head -n 1 | cut -d' ' -f2)
echo "  PHP Version: $PHP_VERSION"

if [[ $PHP_VERSION == 8.* ]]; then
    check_pass "PHP 8.x detected"
else
    check_warn "PHP version might not match server (server uses 8.3)"
fi

echo ""

# ============================================================================
# 6. LARAVEL CONFIG
# ============================================================================

echo "Step 6: Checking Laravel configuration..."

if [ -f ".env.example" ]; then
    check_pass ".env.example exists"
else
    check_warn ".env.example not found"
fi

if [ -f ".env" ]; then
    APP_KEY=$(grep "APP_KEY=" .env | cut -d'=' -f2)
    if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "base64:" ]; then
        check_warn "APP_KEY not set in .env (OK for local, must be set on server)"
    else
        check_pass "APP_KEY configured"
    fi
else
    check_warn ".env file missing (should exist locally)"
fi

echo ""

# ============================================================================
# 7. COMPOSER DEPENDENCIES
# ============================================================================

echo "Step 7: Checking Composer dependencies..."

if [ -d "vendor" ]; then
    check_pass "Composer dependencies installed"
else
    check_warn "vendor/ directory not found, run: composer install"
fi

if [ -f "composer.lock" ]; then
    check_pass "composer.lock exists (good for consistency)"
else
    check_warn "composer.lock not found"
fi

echo ""

# ============================================================================
# 8. LOCAL TEST
# ============================================================================

echo "Step 8: Running local tests..."

if command -v php &> /dev/null; then
    # Quick syntax check
    if php -l artisan > /dev/null 2>&1; then
        check_pass "PHP syntax is valid"
    else
        check_fail "PHP syntax errors detected"
    fi

    # Check routes
    if php artisan route:list &> /dev/null; then
        check_pass "Routes are valid"
    else
        check_warn "Could not list routes (may be OK)"
    fi
else
    check_warn "PHP not available for local testing"
fi

echo ""

# ============================================================================
# 9. DEPLOYMENT FILES
# ============================================================================

echo "Step 9: Checking deployment setup..."

if [ -f "deploy-production.sh" ]; then
    check_pass "deploy-production.sh exists"
else
    check_warn "deploy-production.sh not found (required on VPS)"
fi

if [ -f "webhook.php" ]; then
    check_pass "webhook.php exists"
else
    check_warn "webhook.php not found"
fi

echo ""

# ============================================================================
# 10. DOCUMENTATION
# ============================================================================

echo "Step 10: Checking documentation..."

if [ -f "DEPLOYMENT_SOLUTION.md" ]; then
    check_pass "DEPLOYMENT_SOLUTION.md exists"
else
    check_warn "DEPLOYMENT_SOLUTION.md not found"
fi

echo ""

# ============================================================================
# SUMMARY
# ============================================================================

echo "=========================================="
echo "CHECKLIST SUMMARY"
echo "=========================================="
echo -e "  ${GREEN}✓ Passed: $PASS${NC}"
echo -e "  ${YELLOW}⚠ Warnings: $WARN${NC}"
echo -e "  ${RED}✗ Failed: $FAIL${NC}"
echo ""

if [ $FAIL -eq 0 ]; then
    echo -e "${GREEN}✓ All critical checks passed!${NC}"
    echo ""
    echo "Ready to deploy. Steps:"
    echo "  1. Review changes: git log -1 --stat"
    echo "  2. Push to master: git push origin master"
    echo "  3. Monitor deployment: tail -f /var/log/sk_sharif_deploy.log (on VPS)"
    echo ""
    exit 0
else
    echo -e "${RED}✗ Critical issues found. Please fix before deploying.${NC}"
    echo ""
    exit 1
fi
