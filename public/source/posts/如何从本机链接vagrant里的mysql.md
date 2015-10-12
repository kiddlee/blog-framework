#我设置如下：

* 在Vagrantfile中设置ip与端口
```
config.vm.network "private_network", ip: "10.10.10.11"
config.vm.network "forwarded_port", guest: 3306, host: 3306
```
* vagrant reload

进入vagrant做如下设置
* 在/etc/hosts.allow里加上：mysqld: ALL : ALLOW 和 mysqld-max: ALL : ALLOW
* 在/etc/mysql/my.cnf里注释掉skip-external-locking, 并且把bind-address设置为0.0.0.0
* 在mysql里GRANT权限: 
```
GRANT ALL PRIVILEGES ON *.* TO 'myuser'@'%' WITH GRANT OPTION;
```
