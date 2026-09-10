#!/usr/bin/env bash

set -Eeuo pipefail

echo "======================================"
echo " GitHub Repository Setup (HTTPS)"
echo "======================================"
echo

read -rp "GitHub Username: " INPUT_USER
read -rp "GitHub Repository: " INPUT_REPO
read -rp "Branch name [main]: " BRANCH

BRANCH="${BRANCH:-main}"

# Strip trailing slashes, .git suffix, and full URL prefixes if pasted by mistake
GITHUB_USERNAME="$(echo "$INPUT_USER" | sed -E 's|^https?://github\.com/||; s|/$||')"
GITHUB_REPO="$(echo "$INPUT_REPO" | sed -E 's|^https?://github\.com/[^/]+/||; s|^https?://github\.com/||; s|\.git$||; s|/$||')"

if [[ -z "$GITHUB_USERNAME" || -z "$GITHUB_REPO" ]]; then
    echo "ERROR: Username and repository are required."
    exit 1
fi

REMOTE_URL="https://github.com/${GITHUB_USERNAME}/${GITHUB_REPO}.git"

echo
echo "======================================"
echo " Configuration"
echo "======================================"
echo "Username : $GITHUB_USERNAME"
echo "Repo     : $GITHUB_REPO"
echo "Branch   : $BRANCH"
echo "Remote   : $REMOTE_URL"
echo

read -rp "Continue? [y/N]: " CONFIRM

if [[ ! "$CONFIRM" =~ ^[Yy]$ ]]; then
    echo "Cancelled."
    exit 0
fi

# Initialize Git if needed
if [[ ! -d ".git" ]]; then
    echo
    echo "[1/4] Initializing Git..."
    git init
else
    echo
    echo "[1/4] Git repository already initialized."
fi

# Ensure at least an initial commit branch reference exists before renaming branch
echo "[2/4] Setting default branch: $BRANCH"
git config user.name >/dev/null 2>&1 || git config user.name "Deploy Script"
git config user.email >/dev/null 2>&1 || git config user.email "deploy@localhost"
git branch -M "$BRANCH"

# Configure remote
echo "[3/4] Configuring GitHub remote..."

if git remote get-url origin >/dev/null 2>&1; then
    CURRENT_REMOTE="$(git remote get-url origin)"

    echo "Existing origin: $CURRENT_REMOTE"

    read -rp "Replace origin with $REMOTE_URL? [y/N]: " REPLACE

    if [[ "$REPLACE" =~ ^[Yy]$ ]]; then
        git remote set-url origin "$REMOTE_URL"
    else
        echo "Keeping existing origin."
    fi
else
    git remote add origin "$REMOTE_URL"
fi

echo "[4/4] Git configuration complete."

echo
echo "======================================"
echo " Result"
echo "======================================"

echo "Remote:"
git remote -v

echo
echo "Branch:"
git branch --show-current 2>/dev/null || echo "$BRANCH"

echo
echo "======================================"
echo " GitHub setup completed!"
echo "======================================"
echo
echo "Next steps:"
echo "  git add -A"
echo "  git commit -m \"Initial commit\""
echo "  git push -u origin $BRANCH"
echo
