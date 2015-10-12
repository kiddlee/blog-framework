**更改应用创建的文件权限**

在linux环境中, 权限问题可能会浪费你很多时间. 从今往后, 无论何时, 当你创建一些文件后, 确保使用chmod设置正确权限. 否则的话, 可能文件先是由"php"用户创建, 但你用其它的用户登录工作, 系统將会拒绝访问或打开文件, 你不得不奋力获取root权限,  更改文件的权限等等.

    // Read and write for owner, read for everybody else
    chmod("/somedir/somefile", 0644); 
    // Everything for owner, read and execute for others
    chmod("/somedir/somefile", 0755);

**不要依赖submit按钮值来检查表单提交行为**
	
    if($_POST['submit'] == 'Save')
    {
        //Save the things
    }

上面大多数情况正确, 除了应用是多语言的. 'Save' 可能代表其它含义. 你怎么区分它们呢. 因此, 不要依赖于submit按钮的值.
	
    if( $_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['submit']) )
    {
        //Save the things
    }

现在你从submit按钮值中解脱出来了.

**不要直接使用 $_SESSION 变量**

某些简单例子:
	
    $_SESSION['username'] = $username;
    $username = $_SESSION['username'];

这会导致某些问题. 如果在同个域名中运行了多个应用, session 变量可能会冲突. 两个不同的应用可能使用同一个session key. 例如, 一个前端门户, 和一个后台管理系统使用同一域名.

从现在开始, 使用应用相关的key和一个包装函数:
	
    define('APP_ID' , 'abc_corp_ecommerce');
    //Function to get a session variable
    function session_get($key)
    {
        $k = APP_ID . '.' . $key;
        if(isset($_SESSION[$k]))
        {
            return $_SESSION[$k];
        }
     
        return false;
    }
    
    //Function set the session variable
    function session_set($key , $value)
    {
        $k = APP_ID . '.' . $key;
        $_SESSION[$k] = $value;
     
        return true;
    }
    
**將工具函数封装到类中**

假如你在某文件中定义了很多工具函数:

    function utility_a()
    {
        //This function does a utility thing like string processing
    }
     
    function utility_b()
    {
        //This function does nother utility thing like database processing
    }
     
    function utility_c()
    {
        //This function is ...
    }
    
这些函数的使用分散到应用各处. 你可能想將他们封装到某个类中:

    class Utility
    {
        public static function utility_a()
        {
        }
     
        public static function utility_b()
        {
        }
     
        public static function utility_c()
        {
        }
    }
     
    //and call them as
     
    $a = Utility::utility_a();
    $b = Utility::utility_b();
    
显而易见的好处是, 如果php内建有同名的函数, 这样可以避免冲突.

另一种看法是, 你可以在同个应用中为同个类维护多个版本, 而不导致冲突. 这是封装的基本好处, 无它.

**Bunch of silly tips** 

使用echo取代print

使用str_replace取代preg_replace, 除非你绝对需要

不要使用 short tag

简单字符串用单引号取代双引号

head重定向后记得使用exit

不要在循环中调用函数

isset比strlen快

始中如一的格式化代码

不要删除循环或者if-else的括号

不要这样写代码:

    <span style="color:#333333;font-family:''Helvetica, Arial, sans-serif'';">if($a == true) $a_count++;</span>

这绝对WASTE.

写成:
	
    <span style="color:#333333;font-family:''Helvetica, Arial, sans-serif'';">if($a == true)
    {
        $a_count++;
    }</span>

不要尝试省略一些语法来缩短代码. 而是让你的逻辑简短.

**使用array_map快速处理数组**

比如说你想 trim 数组中的所有元素. 新手可能会:

    foreach($arr as $c => $v)
    {
        $arr[$c] = trim($v);
    }

但使用 array_map 更简单:
	
    $arr = array_map('trim' , $arr);

这会为$arr数组的每个元素都申请调用trim. 另一个类似的函数是 array_walk. 请查阅文档学习更多技巧.
21. 使用 php filter 验证数据

你肯定曾使用过正则表达式验证 email , ip地址等. 是的,每个人都这么使用. 现在, 我们想做不同的尝试, 称为filter.

php的filter扩展提供了简单的方式验证和检查输入.

**强制类型检查**

    $amount = intval( $_GET['amount'] );
    $rate = (int) $_GET['rate'];

这是个好习惯.

**如果需要,使用profiler如xdebug**

如果你使用php开发大型的应用, php承担了很多运算量, 速度会是一个很重要的指标. 使用profile帮助优化代码. 可使用

xdebug和webgrid.

避免使用全局变量

使用 defines/constants

使用函数获取值

使用类并通过$this访问

**在head中使用base标签**

没听说过? 请看下面:

    <head>
    <base href="http://www.domain.com/store/">
    </head>
    <body>
    <img src="happy.jpg" />
    </body>
    </html>

base 标签非常有用. 假设你的应用分成几个子目录, 它们都要包括相同的导航菜单.

www.domain.com/store/home.php

www.domain.com/store/products/iPad.php

在首页中, 可以写:

    <a href="home.php">Home</a>
    <a href="products/iPad.php">Ipad</a>

但在你的iPad.php不得不写成:

    <span style="color:#333333;font-family:''Helvetica, Arial, sans-serif'';"><a href="../home.php">Home</a>
    <a href="iPad.php">Ipad</a></span>

因为目录不一样. 有这么多不同版本的导航菜单要维护, 很糟糕啊. 

因此, 请使用base标签.

    <span style="color:#333333;font-family:''Helvetica, Arial, sans-serif'';"><head>
    <base href="http://www.domain.com/store/">
    </head>
    <body>
    <a href="home.php">Home</a>
    <a href="products/iPad.php">Ipad</a>
    </body>
    </html></span>

现在, 这段代码放在应用的各个目录文件中行为都一致. 

**永远不要將 error_reporting 设为 0**

关闭不相的错误报告. E_FATAL 错误是很重要的. 

    <span style="color:#333333;font-family:'Helvetica, Arial, sans-serif';">ini_set('display_errors', 1);
    error_reporting(~E_WARNING & ~E_NOTICE & ~E_STRICT);</span>

**使用扩展库**

一些例子:

mPDF -- 能通过html生成pdf文档

PHPExcel -- 读写excel

PhpMailer -- 轻松处理发送包含附近的邮件

pChart -- 使用php生成报表

使用开源库完成复杂任务, 如生成pdf, ms-excel文件, 报表等.
