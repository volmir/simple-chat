# Simple chat application

### Install

```sh
$ cd /var/www
$ git clone https://github.com/volmir/simple-chat.git
$ composer install
$ cp /var/www/simple-chat/config/config.dist.php /var/www/simple-chat/config/config.php
$ vi /var/www/simple-chat/config/config.php
$ mysql -u root -p < /var/www/simple-chat/dump/db_dump.sql
```

Virtual host example (Apache):

```apache
<VirtualHost *:80>
    <Directory "/var/www/simple-chat/web">
        AllowOverride All
    </Directory>
    ServerName simple.chat.local
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/simple-chat/web
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

Virtual host example (Nginx):

```nginx
server {
    listen 80;
    root /var/www/simple-chat/web;
    index index.php index.html;

    server_name simple.chat.local;

    location / {
	try_files $uri /index.php$is_args$args;
    }

    location ~ ^/(index)\.php(/|$) {
	fastcgi_pass unix:/var/run/php/php7.3-fpm.sock;
	fastcgi_split_path_info ^(.+\.php)(/.*)$;
	include fastcgi_params;

	fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
	fastcgi_param DOCUMENT_ROOT $realpath_root;
    }

    location ~ /\.ht {
	deny all;
    }
}
```   


### RedBeanPHP ORM

https://www.redbeanphp.com/index.php
https://prowebmastering.ru/redbeanphp-orm-dlya-php.html


