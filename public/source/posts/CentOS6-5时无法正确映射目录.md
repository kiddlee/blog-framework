今天在用vagrant建立centos6.5虚拟机时遇到了一个错误，提示错误:
```
Failed to mount folders in Linux guest. This is usually because
the "vboxsf" file system is not available. Please verify that
the guest additions are properly installed in the guest and
can work properly. The command attempted was:

mount -t vboxsf -o uid=`id -u vagrant`,gid=`getent group vagrant | cut -d: -f3` vagrant /vagrant
mount -t vboxsf -o uid=`id -u vagrant`,gid=`id -g vagrant` vagrant /vagrant

The error output from the last command was:

/sbin/mount.vboxsf: mounting failed with the error: No such device
```
虚拟机种的vagrant目录无法映射到宿主机上，估计是上周手欠，升级了virtualbox，造成了Virtualbox Addition版本不兼容 .
解决方法
```
vagrant ssh
yum update
yum install kernel-headers kernel-devel
```
Then reboot
