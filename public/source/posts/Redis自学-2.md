##四种数据类型
* 字符串类型
	* 介绍：字符串类型是Redis中的基本数据类型，它能存储任何形式的字符串，包括二进制数据。可以用其存储用户邮箱、JSON化的对象甚至是一张图片。一个字符串类型键的数据最大容量是512MB
	* 命令：
		* SET key value		//赋值
		* GET key				//取值
		* INCR key			//自增
		* INCRBY key increment	//增加指定整数
		* DECR key			//自减
		* DECRBY key decrement	//减少指定整数
		* INCRBYFLOAT key increment	//增加指定浮点数
		* APPEND key value		//向尾部追加值
		* STRLEN key				//获取字符串长度
		* MGET	key [key ...]	//同时获得多个键值
		* MSET key value [key value ...] //通知设置多个键值
		* GETBIT key offset	//获得一个字符串类型指定位置的二进制位的值
		* SETBIT key offset value //设置字符串类型键指定位置的二进制位的值
		* BITCOUNT key [start][end] //获得字符串类型键中值是1的二进制位个数
		* BITOP operation destkey key [key ...] //可以对多个字符串类型键进行位运算，并将结果存储在destkey参数指定的键中。支持AND OR XOR NOT运算
* 散列类型
	* 介绍：Redis是采用字典结构已键值对的形式存储数据，散列类型（hash）的键值也是一种字典结构，其存储了字段和字段值的映射，但字段值只能是字符串，不支持其他数据类型。一个散列类型键可以包含之多232个字段
	* 命令：
		* HSET key field value
		* HGET key field
		* HMSET key field value [field value ...]
		* HMGET key field [field ...]
		* HGETALL key //获取键中所有字段和字段值
		* HEXISTS key field //判断字段是否存在
		* HSETNX key field value //当字段不存在时赋值
		* HINCRBY key field increment
		* HDEL key field [field ...]
		* HKEYS\HVALS key //获取字段名\字段值
		* HLEN key //获得字段数量
* 列表类型
	* 介绍：可以存储一个有序的字符串列表，常用的操作是向列表两端添加一个元素，或者获得列表的摸一个片段
	* 命令：
		* LPUSH key value [value ...]
		* RPUSH key value [value ...]
		* LPOP key
		* RPOP key
		* LLEN key
		* LRANGE key start stop //获得列表片段
		* LREM key count value //删除列表中前count个值为value的元素，返回值是实际删除的元素个数
		* LINDEX key index //获取指定索引的元素值
		* LSET key index value //设定指定索引的元素值
		* LTRIM key start end //只保留列表指定片段
		* LINSERT key BEFORE|AFTER pivot value //向列表中插入元素，LINSERT命令首先会在列表中从左到右查找值为pivot的元素，然后根据第二个参数是BEFORE还是AFTER来决定将value插入到钙元素的前面还是后面
		* RPOPLPUSH source destination //将元素从一个列表转到另一个列表，此命令会先从source列表类型键的右边弹出一个元素，然后加入到destination列表类型键的左边，并返回这个元素的值。
* 集合类型
	* 介绍：集合中每个元素都是不同的，且没有顺序。一个集合类型键可以存储之多232-1个字符串。集合与列表的区别在于集合是无序唯一的，列表是有序不唯一的
	* 命令：
		* SADD key member [member...]
		* SREM key member [member...]
		* SMEMBERS key //获得集合中所有元素
		* SISMEMBER key member //判断元素是否在集合中
		* SDIFF key [key...]/SINTER key [key...]/SUNION key [key...] //集合间运算
		* SCARD key //获得集合中元素个数
		* SDIFFSOTRE/SINTERSTORE/SUNIONSTORE destionation key [key...]
		* SRANDMEMBER key [count] //随机获取集合中的元素
		* SPOP key //从集合中弹出一个元素
* 有序集合类型
	* 介绍：在集合类型的基础上有序集合类型为集合中每个元素都关联了一个分数，是的我们不仅可以完成插入、删除和判断元素是否存在等集合类型支持的操作，还能狗获得分数最高（或最低）的前N个元素，获得只能分数范围内的元素等与分数有关的操作。
	* 命令：
		* ZADD key score member [score member...] //添加元素
		* ZSCORE key member //忽的元素的分数
		* ZRANGE/ZREVRANGE key start stop[WITHSCORES] //获得排名在某个分为的元素列表
		* ZRANGEBYSCORE key min max [WITHSCORES][LIMIT offset count]	//获取指定分数范围的元素
		* ZINCRBY key increment member //增加某个元素的分数
		* ZCARD key //获得集合中元素的数量
		* ZCOUNT key min max //获得指定分数范围内的元素个数
		* ZREM key member [member...] //删除一个或多个元素
		* ZREMRANGBYRANK key start stop //按照排名范围删除元素
		* ZREMRANGEBYSCORE key min max //按照分数范围删除元素
		* ZRANK key member //获得元素的排名
		* ZINTERSTORE destination numkeys key [key...] [WEIGHTS weight [weight...] [AGGREGATE] //计算有序集合的交集