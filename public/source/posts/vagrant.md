##Config
* Config memory
	
	```
	config.vm.provider "virtualbox" do |v|
  		v.memory = 2048
	end
	```
* Config IP
	
	```
	config.vm.network :private_network, ip:"192.168.10.10"
	```
	
##Command

```
# vagrant init  初始化

# vagrant status  查看虚拟机运行状态

# vagrant up 启动虚拟机

# vagrant halt  关闭虚拟化开发环境

# vagrant reload 修改配置文件后，重启虚拟化开发环境

# vagrant box list 查看当前可用的虚拟化开发环境

# vagrant box remove boxname 删除指定的box环境

# vagrant destroy 销毁虚拟机

# vagrant package 当前正在运行的VirtualBox虚拟环境打包成一个可重复使用的box

打包创建虚机

1、打包虚拟机
vagrant package

2、当前目录就会生成package.box，之后新建虚拟机则可使用这个box。
 
vagrant box add my_box ~/package.box
vagrant init my_box
vagrant up
```

##Some Question

```
ailed to mount folders in Linux guest. This is usually because
    the "vboxsf" file system is not available. Please verify that
    the guest additions are properly installed in the guest and
    can work properly. The command attempted was:
 
    mount -t vboxsf -o uid=`id -u vagrant`,gid=`getent group vagrant | cut -d: -f3` vagrant /vagrant  
    mount -t vboxsf -o uid=`id -u vagrant`,gid=`id -g vagrant` vagrant /vagrant

    The error output from the last command was:
    /sbin/mount.vboxsf: mounting failed with the error: No such device
```

##Solution

```
在本机输入
vagrant plugin install vagrant-vbguest

进入虚拟机
vagrant ssh

输入
sudo ln -s /opt/VBoxGuestAdditions-4.3.18/lib/VBoxGuestAdditions /usr/lib/VBoxGuestAdditions（VBoxGuestAdditions-4.3.18为版本号）

更新内核
yum update kernel 
sudo yum install  gcc dkms kernel-devel 


安装
sudo /etc/init.d/vboxadd  setup

退出
control+d

重启
vagrant reload

..............[ok]
```