### Ubuntu(14.04)软件源安装
```
$ sudo apt-get update
$ sudo apt-get install -y docker.io
$ sudo ln -sf /usr/bin/docker.io /usr/local/bin/docker
$ sudo sed -i '$acomplete -F _docker docker' /
```
### Ubuntu(14.04)Docker官方源安装最新版本
```
$ sudo apt-get install apt-transport-https
$ sudo apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv-keys 36A1D7869245C8950F966E92D8576A8BA88D21E9
$ sudo bash -c "echo deb https://get.docker.io/ubuntu docker main > /etc/apt/sources.list.d/docker.list"
$ sudo apt-get update
$ sudo apt-get install -y lxc-docker
```
在安装了Docker官方软件源后，若需要更新Docker软件版本，只需要执行以下命令即可升级：
```
$ sudo apt-get update -y lxc-docker
```
### CentOS6
```
$ sudo yum install -y http://mirrors.yun-idc.com/epel/6/i386/epel-release-6-8.noarch.rpm
$ sudo yum install -y docker-io
```
### CentOS7
```
$ sudo yum install -y docker
```
