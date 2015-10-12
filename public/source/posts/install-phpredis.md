###编译安装

```
git clone https://github.com/phpredis/phpredis.git
cd phpredis
phpize
./configure
make && make install
```
添加 'extension=redis.so' 到 php.ini

```
service php5-fpm restart
```

在phpinfo中显示的信息应该有redis扩展信息。
###包安装

```
apt-get install php5-redis
```

###安装后遇到的问题：
安装后使用phpinfo打印不出redis信息，fpm中报错：找不到Redis Class，但是cli工作正常，搞了很久，重启php5-fpm，nginx，重新安装，编译安装。。。后来重启了一下虚拟机，我擦，可以了，Linux也可以这么做。我突然明白：

#不要放弃任何可能的办法