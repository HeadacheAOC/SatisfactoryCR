C:
cd C:\Program Files\php\php-8.3.12-nts-Win32-vs16-x64
php -t %~dp0\htdocs -S 127.0.0.1:80 -d extension_dir="ext" -d extension="mbstring"
