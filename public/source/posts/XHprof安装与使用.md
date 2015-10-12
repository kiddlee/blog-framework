XHProf是一个分层PHP性能分析工具。它报告函数级别的请求次数和各种指标，包括阻塞时间，CPU时间和内存使用情况。一个函数的开销，可细分成调用者和被调用者的开销，XHProf数据收集阶段，它记录调用次数的追踪和包容性的指标弧在动态callgraph的一个程序。它独有的数据计算的报告/后处理阶段。在数据收集时，XHProfd通过检测循环来处理递归的函数调用，并通过给递归调用中每个深度的调用一个有用的命名来避开死循环。XHProf分析报告有助于理解被执行的代码的结构，它有一个简单的HTML的用户界面（ PHP写成的）。基于浏览器的性能分析用户界面能更容易查看，或是与同行们分享成果。也能绘制调用关系图。

###安装
在Ubuntu下安装XHprof的过程如下：

```
git clone https://github.com/facebook/xhprof.git
apt-get upgrade
apt-get install php5-dev
apt-get update
apt-get install php5-dev —fix-missing
cd extension
phpize
./configure -with-php-config=/usr/bin/php-config
make&&make install
make test
```

然后找到php.ini添加：

```
[xhprof]
extension=xhprof.so
;#
;# directory used by default implementation of the iXHProfRuns
;# interface (namely, the XHProfRuns_Default class) for storing
;# XHProf runs.
;#
xhprof.output_dir=/var/log/xhprof/
```

创建目录

```
sudo mkdir /var/log/xhprof
```
更改目录权限

```
sudo chown www-data:www-data /var/log/xhprof
```

安装graphviz ，以图形形式查看结果

```
apt-get install graphviz
```

###检测

检查是否安装成功 通常可使用extension_loaded函数进行检测：

```
$ php -r "var_dump(extension_loaded('xhprof'));"
```
返回结果为true表示安装成功。
或者：

```
$ php -m | grep xhprof
```
如果有匹配结果也表示安装成功了
或者:web中调用phpinfo查看是否成功安装xhprof（需要重启php服务，如果独立的php-fpm，需重启php-fpm，如果以module挂载在web服务器上，需重启web服务器）

###XHProf测试

XHProf自带了一个sample.php测试的例子,稍微修改一下就可以使用了

```
cp -rf examples/ [可访问目录]
```
修改sample.php让它也显示cpu和内存信息

```
vim /var/www/html/examples/sample.php
```
将xhprof_enable()改为 

```
xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY)
```
将最后一段echo一行修改为：

```
echo 'count';
```
刷新页面后会在/var/log/xhprof中生成新的文件，配置号xhprof/xhprof_html就可以查看


###XHProf输出说明

* Inclusive Time ： 包括子函数所有执行时间。
* Exclusive Time/Self Time ： 函数执行本身花费的时间，不包括子树执行时间。
* Wall Time ： 花去了的时间或挂钟时间。
* CPU Time ： 用户耗的时间+ 内核耗的时间
* Inclusive CPU ： 包括子函数一起所占用的CPU
* Exclusive CPU ： 函数自身所占用的CPU


###参考资料

* [知名博主：xhprof简介和安装](http://stenote.com/2013/09/xhprof简介和安装/)
* [php性能测试工具--xhprof](http://blog.chinaunix.net/uid-10449864-id-3013810.html)
