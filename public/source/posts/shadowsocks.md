之前常常用ppptp在vps上搭建vpn，或者购买vpn。今天看到一篇文章将如何搭建shadowsocks，突然想起[知名博主](stenote.com)强力推荐的vpn工具。于是按照文档试了一下。果然很easy。

* 首先在vps上安装shadowsocks服务端，脚本如下：

```
$ sudo apt-get install python-pip
$ pip install shadowsocks
// 注意以下的 PORT 和 PASSWORD 自定义。
$ ssserver -p PORT -k PASSWORD -m rc4-md5 -d start
```
* 安装shadowsocks客户端: [shadowsocks](http://shadowsocks.org/en/index.html)
* 启动，客户端，进行简单设置，OK了。

如果设置多用户的话，维护 /etc/shadowsocks.json：

```
{
    "server":"VPS服务器的IP",
    "local_address": "127.0.0.1",
    "local_port":1080,
    "port_password":{
         // 设置多个用户
         "9000":"PASSWORD9000",
         "9001":"PASSWORD9001",
         "9002":"PASSWORD9002",
         "9003":"PASSWORD9003",
         "9004":"PASSWORD9004"
    },
    "timeout":300,
    "method":"rc4-md5",
    "fast_open": false
}
```