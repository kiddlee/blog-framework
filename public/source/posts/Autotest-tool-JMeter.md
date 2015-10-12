##自动化测试工具之一JMeter
[Mac版本下载地址](http://mac.softpedia.com/get/Developer-Tools/Apache-JMeter.shtml)

##运行
安装Java运行环境后，下载解压，直接点击：ApacheJMeter.jar

##简单尝试
1. 在Test Plan中添加一个Thread Group, 线程组中可以设定Number of Threads(users), Ramp-Up Period(in seconds)以及Loop Count。
2. 添加 Sample\HTTP Request, 在此添加Server Name or IP
3. 添加 Lisenter\View Results Tree
此时点击Start后，可以在View Results Tree查看测试结果