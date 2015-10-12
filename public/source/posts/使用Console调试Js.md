Console 是用于显示 JS和 DOM 对象信息的单独窗口。并且向 JS 中注入1个 console 对象，使用该对象 可以输出信息到 Console 窗口中。Firefox和Chrome对此对象支持的很好。

**console.log** 可以打印出一些log信息

**console.debug，info，warn，error** 同样可以打印log信息，但在显示颜色上有一些变化

**console.clear** 可以用来清除console中的信息

**console.trace** 可以查看当前函数的调用堆栈信息，即当前函数是如何调用的

**console.group(object[, object, ...]), groupCollapsed, groupEnd** 用于把 log 等输出的信息进行分组，方便阅读查看。

```
   console.group('First group');
   console.log('a');
   console.log('b');
   console.log('c');
   console.groupEnd();
   console.group('Second group');
   console.log('1');
   console.log('2');
   console.log('3');
   console.group('Embeded subgroup');
   console.log('α');
   console.log('β');
   console.log('γ');
   console.groupEnd(); 
```
**console.time(name)/console.timeEnd(name)** 可以用来度量

```
   var slowInitializer = function() {
       var collection = [];
       for (var i = 20000000; i > 0 ; i--) {
           collection.push(i);
           if (i === 1000) {
               console.time('Last iterations');
           }
       }
       console.timeEnd('Last iterations');
   };
   console.time('Slow initializer');
   slowInitializer();
   console.timeEnd('Slow initializer');
```

**console.count()**可以用来计算标签被执行的次数

```
   $('#image').on('click', function() {
       console.count('Click on my image');
   });
```
输出：

```
   Click on my image : 1
   Click on my image : 2
   // [...]
   Click on my image : 12
```
还有其他...
