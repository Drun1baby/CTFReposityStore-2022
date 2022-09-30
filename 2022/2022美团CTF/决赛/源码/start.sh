#!/bin/bash
sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 10M/' /etc/php/7.4/fpm/php.ini
sed -i 's/post_max_size = 8M/upload_max_filesize = 15M/' /etc/php/7.4/fpm/php.ini
gcc -o readFlag readFlag.c
rm readFlag.c
chmod 700 /flag
chmod 755 /readFlag
chmod u+s /readFlag
chown -R www-data /var/www/mako
chmod -R 755 /var/www/mako
service php7.4-fpm start 
service nginx start
tail -f /var/log/nginx/access.log
