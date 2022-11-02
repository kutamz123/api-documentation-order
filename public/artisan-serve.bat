@echo off
for /f "delims=[] tokens=2" %%a in ('ping -4 -n 1 %ComputerName% ^| findstr [') do set NetworkIP=%%a
cd C:/xampp/htdocs/api-documentation-order
php artisan serve --host=%NetworkIP%