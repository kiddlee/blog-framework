在一台Ubuntu机器上升级内核，步骤如下：
##准备
1. 先从[kernel](http://www.kernel.org/)网站上下载稳定版的内核
2. 拥有root权限
3. 将下载后的内核文件解压缩到/usr/src/目录下
4. 进入解压后的目录，如/usr/src/linux-4.1.6/

##配置
1. 运行：make mrproper。该命令的功能在于清除当前目录下残留的.config和.o文件，这些文件一般是以前编译时未清理而残留的。而对于第一次编译的代码来说，不存在这些残留文件，所以可以略过此步，但是如果该源代码以前被编译过，那么强烈建议执行此命令，否则后面可能会出现未知的问题。
2. 配置编译选项：作为操作系统的内核，其内容和功能必然非常繁杂，包括处理器调度，内存管理，文件系统管理，进程通讯以及设备管理等等，而对于不同的硬件，其配置选项也不相同，所以在编译源代码之前必须设置编译选项。这一步应该是升级内核整个过程中最有技术含量的，因为要根据自己的需要正确选择yes or no需要对计算机方方面面的知识都有所了解。但是这里的选项实在是太多了，大概有几百项之多，而且很多选项不是很明白。简便的方法就是make menuconfig 或者make xconfig。我使用的是make menuconfig，但是前提条件是要装ncurses。
	* [ncurses](http://ftp.gnu.org/pub/gnu/ncurses/)下载，可以放到任何目录进行安装：
	
	```
	tar -xvf ncurses<version>.tar.gz #解压缩并且释放 文件包
	cd ncurses<version> #进入解压缩的目录（注意版本）
	./configure #按照你的系统环境制作安装配置文件
	make #编译源代码并且编译NCURSES库
	su root #切换到root用户环境
	make install #安装编译好的NCURSES库
	```
	* 在make menuconfig过程中也会有一些选项需要你来设置 \* , y, n 或者m，选择 \* 表示选项中的内容被直接编入内核中，选择m表示选项中的内容不编入内核，而只是编成独立的module，用到时才调用。
	* ok， 在当前文件路径下，输入命令：
		
	```
	make menuconfig(或者用 make xconfig，我没有用)
	```
	* 根据菜单提示，选择编译配置选项，并保存配置文件为.config(也可以直接复制现有的.config文件)

3. 确定依赖性：根据以往的经验，这一步是必须的，但是这次编译的时候，系统提醒我没必须要执行这个命令：
	
	```
	make dep
	```
如果用现有的.config文件，这里会有很多内核新增加的驱动和功能让你确认是否编入内核中，这个你就自己看着输入y/n/m/?吧！

4. 清除编译中间文件
	
	```
	make clean
	```
**执行这步前最好确认一下机器内存，我第一次实验，虚拟机内存只有512M，编译后出现内存不足的错误。后把内存调整至2G，升级过程顺利执行。**
5. 生成新内核就是把配置过程中，我们选中编入内核中的程序编译链接生产linux内核，输入命令：
	
	```
	make bzImage
	```
6. 生成modules: 和上步差不多，就是把配置过程中，我们选中编成modules的程序编译链接成modules，输入命令：
	
	```
	make modules
	```
7. 安装modules: 就是把刚才编译生产的modules拷到系统文件夹下，以供新内核调用。输入命令：
	
	```
	make modules_install
	```
一切都自动做好了。

8. 建立要载入ramdisk的映像文件: 如果linux系统安装在scsi磁盘上，这步是必须的，否则可以跳过。我的linux是装在vmware上的，用的是虚拟的scsi磁盘，所以必须 要这一步。输入命令：
	
	```
	mkinitramfs -o /boot/initrd-linux3.3.4.img 3.3.4
	```
如果你的linux不是ubuntu，而是其他的发行版本，那么使用的命令可能不是mkinitramfs，而是mkinitrd，但功能和用法类似。

##安装内核

1. 安装内核
```
make install
```
此时系统会把linux内核的镜像文件还有System.map考入到/boot下，然后会自动生成引导菜单。

2. 配置grub引导程序

既然新的内核编译并安装好了，那么我们要配置系统的引导程序用新内核正确引导，这一步我没做任何修改。默认是从新内核镜像启动系统。

3. 敲下reboot，系统启动后，从grub菜单中选中新内核引导linux，怎么样，系统启动的鼓声响了吧！进入后用uname -a看看是否新内核。

##删除旧内核文件

1. 查看一下当前内核版本：uname -a
2. 查看一下当前系统内的所有内核文件：dpkg --get-selections|grep linux 
3. 删除内核文件：

```
sudo apt-get remove linux-image-3.2.0-24*
```
4. 另外一条命令： 

```
sudo aptitude purge ~ilinux-image-.*\(\!'uname -r'\)
```