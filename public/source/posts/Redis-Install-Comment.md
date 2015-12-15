前两天[知名博主](http://stenote.com)问我为什么要用源码安装Redis，我一下子蒙住了，为什么啊？我从来没有问过，好像就是看了一下以前写的blog，然后把脚本写到shell里就随便pull到代码中了。这两天回顾了一下当初看的那本书。才想起书中确实推荐源码安装，源码下还有很多东西，有redis默认配置模板redis.conf，还有一个utils文件夹，下面有很多脚本，其中有一个官方推荐的启动redis脚本（书中写的官方推荐，我又懒了没考证过）redis_init_script

当我们设置好Redis的[配置](https://github.com/kiddlee/myutils/tree/master/linux/redis)，直接run一下命令

```
./redis_init_script start
```

这样我们不用在启动的时候考虑我的配置文件的问题

感谢博主，你的Challenge使我在技术的道路上越走越远，尽情的Challenge我吧!!!
