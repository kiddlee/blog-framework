##查找已安装的应用程序
dpkg的参数很多，可以简单记一些常用命令：

* 查询系统中属于vim的文件:
	* dpkg --listfiles vim
	* dpkg-query -L vim
* 查看软件vim的详细信息:
	* dpkg -s vim
	* dpkg-query -s vim
* 查看系统中软件包状态, 支持模糊查询:
	* dpkg -l
	* dpkg-query -l
* 查看某个文件的归属包:
	* dpkg-query -S vim
	* dpkg -S vim

##卸载应用程序
Ubuntu中软件包的卸载方法有两种方式:

* APT方式
	* 移除式卸载: apt-get remove softname1 softname2：//删除已安装的软件包（保留配置文件）。
	* 清除式卸载: apt-get --purge remove softname1 softname2：//删除已安装包（不保留配置文件)。
	* 清除式卸载：apt-get purge sofname1 softname2...//同上，也清除配置文件)
* Dpkg方式
	* 移除式卸载：dpkg -r pkg1 pkg2 ...;
	* 清除式卸载：dpkg -P pkg1 pkg2...;

###其他
apt-get指令的autoclean,clean,autoremove的区别
 
apt-get autoclean:
   如果你的硬盘空间不大的话，可以定期运行这个程序，将已经删除了的软件包的.deb安装文件从硬盘中删除掉。如果你仍然需要硬盘空间的话，可以试试apt-get clean，这会把你已安装的软件包的安装包也删除掉，当然多数情况下这些包没什么用了，因此这是个为硬盘腾地方的好办法。
 
apt-get clean:
    类似上面的命令，但它删除包缓存中的所有包。这是个很好的做法，因为多数情况下这些包没有用了。但如果你是拨号上网的话，就得重新考虑了。
 
apt-get autoremove:
    删除为了满足其他软件包的依赖而安装的，但现在不再需要的软件包。
    
##参考文档
[ubuntu安装和查看已安装](http://www.cnblogs.com/forward/archive/2012/01/10/2318483.html)