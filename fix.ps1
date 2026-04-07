Write-Host "========================================" -ForegroundColor Cyan
Write-Host "FIXING MIDDLEWARE - POWERSHELL VERSION" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan

Write-Host "`n1. Stopping PHP processes..." -ForegroundColor Yellow
Get-Process php -ErrorAction SilentlyContinue | Stop-Process -Force

Write-Host "`n2. Deleting cache directories..." -ForegroundColor Yellow
Remove-Item -Path "bootstrap\cache" -Recurse -Force -ErrorAction SilentlyContinue
Remove-Item -Path "storage\framework\cache" -Recurse -Force -ErrorAction SilentlyContinue
Remove-Item -Path "storage\framework\sessions" -Recurse -Force -ErrorAction SilentlyContinue
Remove-Item -Path "storage\framework\views" -Recurse -Force -ErrorAction SilentlyContinue

Write-Host "`n3. Recreating cache directories..." -ForegroundColor Yellow
New-Item -Path "bootstrap\cache" -ItemType Directory -Force | Out-Null
New-Item -Path "storage\framework\cache" -ItemType Directory -Force | Out-Null
New-Item -Path "storage\framework\sessions" -ItemType Directory -Force | Out-Null
New-Item -Path "storage\framework\views" -ItemType Directory -Force | Out-Null

Write-Host "`n4. Creating middleware files..." -ForegroundColor Yellow

# Créer AdminMiddleware.php
$adminMiddleware = @'
<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403);
        }
        return $next($request);
    }
}
'@
$adminMiddleware | Out-File -FilePath "app\Http\Middleware\AdminMiddleware.php" -Encoding UTF8 -Force

# Créer OwnerMiddleware.php
$ownerMiddleware = @'
<?php

namespace App\Http\Middleware;

use Closure;

class OwnerMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->role !== 'owner') {
            abort(403);
        }
        return $next($request);
    }
}
'@
$ownerMiddleware | Out-File -FilePath "app\Http\Middleware\OwnerMiddleware.php" -Encoding UTF8 -Force

Write-Host "   ✅ Middleware files created" -ForegroundColor Green

Write-Host "`n5. Clearing all caches..." -ForegroundColor Yellow
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

Write-Host "`n6. Rebuilding autoload..." -ForegroundColor Yellow
composer dump-autoload

Write-Host "`n7. Rebuilding caches..." -ForegroundColor Yellow
php artisan config:cache
php artisan route:cache

Write-Host "`n8. Verifying middleware registration..." -ForegroundColor Yellow
php artisan tinker --execute="echo 'Admin middleware: ' . (app('router')->getMiddleware()['admin'] ?? 'NOT FOUND'); echo PHP_EOL; echo 'Owner middleware: ' . (app('router')->getMiddleware()['owner'] ?? 'NOT FOUND');"

Write-Host "`n========================================" -ForegroundColor Cyan
Write-Host "FIX COMPLETE!" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "`nNow run: php artisan serve" -ForegroundColor Yellow