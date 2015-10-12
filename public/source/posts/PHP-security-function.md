**mysql_real_escape_string( string sqlQuery )**

转义 SQL 语句中使用的字符串中的特殊字符，并考虑到连接的当前字符集。一个非常有用的函数，可以有效地避免 SQL 注入。

以下字符会被转换：

\x00，\n，\r，\，’，”，\x1a

在执行sql语句之前，对要将执行的sql query 使用该函数处理，会将一些危 险扼杀在摇篮中。

但是现在一般在较为成熟的项目中，一般比较推荐使用类似 PDO 这样的数据库持久层来处理所有的数据库操作。他们代表着更为先进的数据库操作处理技术，在安全性，数据读写的速度上逗比那些古老的 mysql_* api 强大了不少。

**addslashes()**

  在将一些数据插入到数据库中时，这个函数会非常有用，它可以在单引号前加上反斜杠，使得数据在插入时不会出现错误。但是它的使用与php.ini 中的一项设置有关系 — magic_quotes_gpc

  1. 对于PHP magic_quotes_gpc=on的情况， 我们可以不对输入和输出数据库的字符串数据作addslashes()和stripslashes()的操作,数据也会正常显示。

  如果此时你对输入的数据作了addslashes()处理，那么在输出的时候就必须使用stripslashes()去掉多余的反斜杠。

  2. 对于PHP magic_quotes_gpc=off 的情况

  必须使用addslashes()对输入数据进行处理，但并不需要使用stripslashes()格式化输出，因为addslashes()并未将反斜杠一起写入数据库，只是帮助mysql完成了sql语句的执行。

  【stripslashes() ：删除由 addslashes() 函数添加的反斜杠。】
  

**htmlentities()**

  一个非常有用的用来处理输出的函数。它用来将一些可能导致XXS攻击的字符转化为html实体，这些字符在浏览器显示的时候是正常的，但是当你查看它的源代码时，实际上这些特殊字符必不会是他显示的那样，例如

  输出：

```
  John & ‘Adams’
```
  源码：

```
  John&nbsp;&amp;&nbsp;'Adams';
```
  输出：

```
  <>
```
  源码：

```
  &lt;&gt;gt;
```

  编码这些符号，有效地避免了XSS 攻击。
  

**htmlspecialchars()**

和上面的函数是一样的，但是它更常用一些，因为 htmlentities() 是将所有的有在html 标准中定义了的字符转换成他们对应的html实体，这样会是你的输出缺乏易读性（html 实体列表 http://www.w3school.com.cn/tags/html_ref_entities.html）。所以呢，使用 htmlspecialchars() 只是将一些 预定义的字符(就是会导致出现问题的)转换为html实体。例如：

```
  & （和号） 成为 &
  ” （双引号） 成为 ”
  ‘ （单引号） 成为 ‘
  < （小于） 成为 <
  > （大于） 成为 >
```

  所以，在一些项目中，我还是常常使用 htmlspecialchars() 来处理html 的输出的。他在安全这一方面做得更具体一些。

  strip_tags(): 一般在输出时使用，将HTML、XML 以及 PHP 的标签剥去。

  函数原型： strip_tags(string,allow)

  String 代表输入的字符串，allow 代表 不删除的标签，你可以通过 allow 来自定义过需要滤掉的标签
  

**md5()**

  一个将字符串转换为一个32位的哈希值的函数（不能逆向解密），任何一个字符串都能通过这个函数获得一个唯一的32位字符串。但是，现在使用这个函数时，需要注意有一些数据库记录了大量的md5 值，通过暴力枚举的方式来破解你的密码，所以在使用的时候，你可以先将你的原字符串加一层密，然后再使用md5()哈希，会获得更好的效果。

**sha1()**

  和md5() 和相似的一个函数，但是他使用不同的算法生成一个 40个字符的字符串。可以在项目中考虑使用

**intval()**

  也许你认为这个函数不是一个 security function。但是它在某些情况下可以很好地保护你的code。对从用户收集到的
