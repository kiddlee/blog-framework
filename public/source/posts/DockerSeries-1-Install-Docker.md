### Ubuntu(14.04)软件源安装
```
$ sudo apt-get update
$ sudo apt-get install -y docker.io
$ sudo ln -sf /usr/bin/docker.io /usr/local/bin/docker
$ sudo sed -i '$acomplete -F _docker docker' /
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
### Docker官方源安装最新版本
```
# add the new gpg key
$ apt-key adv --keyserver hkp://p80.pool.sks-keyservers.net:80 --recv-keys 58118E89F3A912897C070ADBF76221572C52609D

# edit your /etc/apt/sources.list.d/docker.list
$ vim /etc/apt/sources.list.d/docker.list

# remove the contents and replace with the following depending on your os and version:

# Debian Wheezy
deb https://apt.dockerproject.org/repo debian-wheezy main

# Debian Jessie
deb https://apt.dockerproject.org/repo debian-jessie main

# Debian Stretch/Sid
deb https://apt.dockerproject.org/repo debian-stretch main

# Ubuntu Precise
deb https://apt.dockerproject.org/repo ubuntu-precise main

# Ubuntu Trusty
deb https://apt.dockerproject.org/repo ubuntu-trusty main

# Ubuntu Utopic
deb https://apt.dockerproject.org/repo ubuntu-utopic main

# Ubuntu Vivid
deb https://apt.dockerproject.org/repo ubuntu-vivid main

# Ubuntu Wily
deb https://apt.dockerproject.org/repo ubuntu-wily main
After your source file is updated run the following:

$ apt-get update
 
# remove the old
 $ apt-get purge lxc-docker*
  
# install the new
 $ apt-get install docker-engine
```

### 参考资料
[New Apt and Yum Repos](http://blog.docker.com/2015/07/new-apt-and-yum-repos/)
