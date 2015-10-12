##安装
```
wget http://download.redis.io/redis-stable.tar.gz
tar xzf redis-stable.tar.gz
cd redis-stable
make
make install
```

* 编译后源代码目录的src文件夹中可以找到若干个可执行程序，make install命令将这些可执行程序复制到/usr/local/bin目录中
* 可以使用make test命令测试Redis是否编译正确。但是在实践过程中遇到了缺少tcl8.5的情况，直接运行apt-get install tcl就可以。然后再执行make test.

##启动
```
redis-server [/path/to/redis.conf]
```
##客户端
```
//查看链接是否正常
redis-cli ping

//链接
redis-cli -h localhost -p 6379
```