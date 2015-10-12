安装nginx rpm -ivh http://nginx.org/packages/centos/6/noarch/RPMS/nginx-release-centos-6-0.el6.ngx.noarch.rpm

yum info nginx #查看yum的nginx信息

yum install nginx #安装nginx

service nginx start #启动nginx

安装其他程序

```
yum check-update

yum -y install mysql mysql-server php-fpm php-cli php-pdo php-mysql php-mcrypt php-mbstring php-gd php-tidy php-xml php-xmlrpc php-pear php-pecl-memcache php-eaccelerator
```
添加nginx 默认主页index.php

vim /etc/nginx/conf.d/default.conf

```
location / {
      root   /usr/share/nginx/html;
      index  index.html index.htm index.php;
  }
```
配置nginx支持php

vim /etc/nginx/conf.d/default.conf

```
  # pass the PHP scripts to FastCGI server listening on 127.0.0.1:9000

  #

  location ~ .php$ {
      root           html;
      fastcgi_pass   127.0.0.1:9000;
      fastcgi_index  index.php;
      fastcgi_param  SCRIPT_FILENAME  /usr/share/nginx/html$fastcgi_script_name;
      include        fastcgi_params;
  }
```

配置php-fpm

vim /etc/php-fpm.d/www.conf

```
; Unix user/group of processes

; Note: The user is mandatory. If the group is not set, the default user’s group

; will be used.

; RPM: apache Chose to be able to access some dir as httpd

user = nginx

; RPM: Keep a group allowed to write in log dir.

group = nginx
```

chkconfig php-fpm on #设置php-fpm自启动

chkconfig mysqld on #设置mysqld自启动

service nginx restart #重新启动nginx

service php-fpm start #启动php-fpm

service mysqld start #启动mysqld

Open port 80 cd /etc/sysconfig system-config-firewall

Or

Add code in iptables -A INPUT -m state –state NEW -m tcp -p tcp –dport 80 -j ACCEPT

 

<http://macshuo.com/?p=547>
