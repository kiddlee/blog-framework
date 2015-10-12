刚开始php工作时，Boss要我研究一下关于PHP加密部署的问题，但是当时对PHP只是初步了解。后来换了一份工作，才知道可以使用phar包发布，可以算是加密发布的一种。
##PHP Archive
PHP5.3之后支持了类似Java的jar包，名为phar。用来将多个PHP文件打包为一个文件。
##如何创建phar包
项目中建立一个build.php文件，代码如下：

```
<?php

$exts = ['php', 'twig'];    // 需要打包的文件后缀, twig是模版文件, 你还可以安需加入html等后缀
$dir = __DIR__;             // 需要打包的目录

$file = 'Sample.phar';      // 包的名称, 注意它不仅仅是一个文件名, 在stub中也会作为入口前缀
$phar = new Phar(__DIR__ . '/' . $file, FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::KEY_AS_FILENAME, $file);

// 开始打包
$phar->startBuffering();

// 将后缀名相关的文件打包
foreach ($exts as $ext) {
    $phar->buildFromDirectory($dir, '/\.' . $ext . '$/');
}

// 把build.php本身摘除
$phar->delete('build.php');

// 设置入口
$phar->setStub("<?php
Phar::mapPhar('{$file}');
require 'phar://{$file}/portal/index.php';
__HALT_COMPILER();
?>");
$phar->stopBuffering();

// 打包完成
echo "Finished {$file}\n";
```
生成phar包后，只需要直接引用执行就可以了，如添加index.php文件

```
<?php
require __DIR__ . '/Sample.phar';
```
在实际的项目产品中，我们可以一个模块建立一个phar包，在autoload时可以判断如果没有找到相应地phar包则试图加载相应目录。这样在线上调试时，上传相应地目录就可以。对于静态文件，如图片以及配置，以及入口文件(一般是index.php)，用户定制需求或者设置可以依旧保持源码发布，方便更改调试。
##性能
我没有做具体的测试，只是从网上的资料中了解到phar加载时性能会比源文件差，基本上是1.8到2倍左右，但是执行效果还是不错。而且原先公司产品也是用phar包发布。基本上没有遇到过因为phar产生的问题。
##参考资料
* [PHP归档phar性能测试](http://blog.csdn.net/ugg/article/details/25335079)
* [使用phar上线你的代码包](http://segmentfault.com/a/1190000002166235)
* [PHP中phar包的使用](http://rango.swoole.com/archives/168)
* [PHP PHAR 10分钟体验教程](http://my.oschina.net/ecnu/blog/132778)
* [Using Phar Archives: the phar stream wrapper](http://php.net/manual/zh/phar.using.stream.php)
* [phar-sample](https://github.com/SegmentFault/phar-sample)