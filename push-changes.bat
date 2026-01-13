@echo off
cd C:\Users\tapon\sk_sharif_project
echo.
echo ========================================
echo  Committing Icon Updates
echo ========================================
echo.

git add resources/views/layouts/app.blade.php
git commit -m "Update billing section icons for better visual clarity"
git push origin master

echo.
echo ========================================
echo  Push Complete!
echo  Deployment will trigger automatically
echo ========================================
echo.
pause
