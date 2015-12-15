##安装

* 安装clang编译器，这个是苹果公司提供的 C 编译器，是 Swift 必需的一个组件。

```
sudo apt-get --assume-yes install clang
```
* 下载相应Swift包

```
curl -O https://swift.org/builds/ubuntu1404/swift-2.2-SNAPSHOT-2015-12-01-b/swift-2.2-SNAPSHOT-2015-12-01-b-ubuntu14.04.tar.gz
```
Swift包可以从[Swift.org]( https://swift.org/download)这里下载
* 解压缩后可以，把它添加到环境变量中：

```
 echo "export PATH=\"${HOME}\"/swift-2.2-SNAPSHOT-2015-12-01-b-ubuntu14.04/usr/bin:\"${PATH}\"" >> .profile
```
* 重新登录后，可以看到Swift版本号

```
swift --version
Swift version 2.2-dev (LLVM 7bae82deaa, Clang 53d04af5ce, Swift 5995ef2acd)
Target: x86_64-unknown-linux-gnu
```

##使用
* 编写一个helloworld.swift文件

```
print("Hello, world")
```
* 编译该文件

```
swiftc helloworld.swift
```
* 运行文件：编译后会产生一个helloworld文件

```
./helloworld
Hello, world
```
##包管理
可以参考苹果官方的[例子](https://github.com/apple/example-package-dealer)