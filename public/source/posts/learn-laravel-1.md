##Install
* Install composer

	```
	curl -sS https://getcomposer.org/installer | php
	mv composer.phar /usr/local/bin/composer
	```
	[composer全量中国镜像](http://pkg.phpcomposer.com)
* create project
	```
	composer create-project laravel/laravel learnlaravel5
	```
* set web server(nginx)

	```
	server {
	listen 8000;

	root /vagrant/learnlaravel5/public;
	index index.php index.html index.htm;

	server_name localhost;

	charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    access_log off;
    error_log  /var/log/nginx/myapp-error.log error;

    sendfile off;

    client_max_body_size 100m;

    location ~ \.php$ {
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass unix:/var/run/php5-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_intercept_errors off;
        fastcgi_buffer_size 16k;
        fastcgi_buffers 4 16k;
    }

    location ~ /\.ht {
        deny all;
    }
}
	```
	Access http://localhost:8000
* Some folders need write permission: /storage /bootstrap/cache
##Route
Edit file 'app/Http/routes.php'

```
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
```