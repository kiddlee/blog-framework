##创建型模式
创建型模式抽象了实例化过程。它们帮助一个系统独立于如何创建、组合和表示它的那 些对象。一个类创建型模式使用继承改变被实例化的类,而一个对象创建型模式将实例化委 托给另一个对象。

* 单例(Singleton)模式：生成一个且只生成一个对象实例的特殊类
* 工厂方法模式(Factory Method)：构建创建者类的继承层次
* 抽象工厂模式(Abstract Factory)：功能相关产品的创建
* 原型模式(Prototype)：使用克隆生成对象

##单件模式
1. 意图：保证一个类仅有一个实例,并提供一个访问它的全局访问点。
2. 动机：我们怎么样才能保证一个类只有一个实例并且这个实例易于被访问呢?一个全局变量使 得一个对象可以被访问,但它不能防止你实例化多个对象。
一个更好的办法是,让类自身负责保存它的唯一实例。这个类可以保证没有其他实例可 以被创建(通过截取创建新对象的请求),并且它可以提供一个访问该实例的方法。
3. 实现：

```
#!/bin/env/php
<?php
class Preferences {
    private $props = array();
    private static $instance;

    private function __construct() { }

    public static function getInstance() {
        if ( empty( self::$instance ) ) {
            self::$instance = new Preferences();
        }
        return self::$instance;
    }

    public function setProperty( $key, $val ) {
        $this->props[$key] = $val;
    }

    public function getProperty( $key ) {
        return $this->props[$key];
    }
}

$pref = Preferences::getInstance();
$pref->setProperty( 'name', 'matt' );

unset( $pref ); // remove the reference

$pref2 = Preferences::getInstance();
print $pref2->getProperty( 'name' ) ."\n"; // demonstrate value is not lost
```

##工厂方法模式
1. 意图：定义一个用于创建对象的接口,让子类决定实例化哪一个类。 Factory Method使一个类的实例化延迟到其子类。
2. 动机：框架使用抽象类定义和维护对象之间的关系。这些对象的创建通常也由框架负责。例如系统编码转换的工具，提供Xml输出格式。
3. 实现：

```
#!/bin/env/php
<?php
abstract class ApptEncoder {
    abstract function encode();
}

class XmlApptEncoder extends ApptEncoder {
    function encode() {
        return "Appointment data encode in Xml format\n";
    }
}

abstract class CommsManager {
    abstract function getHeaderText();
    abstract function getApptEncoder();
    abstract function getFooterText();
}

class XmlCommsManager extends CommsManager {
    function getHeaderText() {
        return "Xml header\n";
    }

    function getApptEncoder() {
        return new XmlApptEncoder();
    }

    function getFooterText() {
        return "Xml footer\n";
    }
}

$obj = new XmlCommsManager();
print $obj->getHeaderText();
print $obj->getApptEncoder()->encode();
print $obj->getFooterText();
```

##抽象工厂模式
1. 意图：提供一个创建一系列相关或相互依赖对象的接口,而无需指定它们具体的类。
2. 动机：系统要提示多种转码方式，如Xml和Json
3. 实现：

```
#!/bin/env/php
<?php
abstract class ApptEncoder {
    abstract function encode();
}

class XmlApptEncoder extends ApptEncoder {
    function encode() {
        return "Appointment data encoded in XmlApptEnder format\n";
    }
}

class JsonApptEncoder extends ApptEncoder {
    function encode() {
        return "Appointment data encoded in JsonApptEnder format\n";
    }
}


abstract class CommsManager {
    abstract function getHeaderText();
    abstract function getApptEncoder();
    abstract function getTtdEncoder();
    abstract function getContactEncoder();
    abstract function getFooterText();
}

class XmlCommsManager extends CommsManager {
    function getHeaderText() {
        return "Xml header\n";
    }

    function getApptEncoder() {
        return new XmlApptEncoder();
    }

    function getTtdEncoder() {
        return new XmlTtdEncoder();
    }

    function getContactEncoder() {
        return new XmlContactEncoder();
    }

    function getFooterText() {
        return "Xml footer\n";
    }
}

class JsonCommsManager extends CommsManager {
    function getHeaderText() {
        return "Json header\n";
    }

    function getApptEncoder() {
        return new JsonApptEncoder();
    }

    function getTtdEncoder() {
        return new JsonTtdEncoder();
    }

    function getContactEncoder() {
        return new JsonContactEncoder();
    }

    function getFooterText() {
        return "Json footer\n";
    }
}

$obj = new XmlCommsManager();
print $obj->getHeaderText();
print $obj->getApptEncoder()->encode();
print $obj->getFooterText();
```

##原型模式
1. 意图：用原型实例指定创建对象的种类,并且通过拷贝这些原型创建新的对象。
2. 动机：在一个游戏中需要实现两个星球（地球&潘多拉）。两个星球都有海洋、土地、森林。
3. 实现：

```
#!/bin/env/php
<?php

class Sea {}
class EarthSea extends Sea {}
class MarsSea extends Sea {}

class Plains {}
class EarthPlains extends Plains {}
class MarsPlains extends Plains {}

class Forest {}
class EarthForest extends Forest {}
class MarsForest extends Forest {}

class TerrainFactory {
    private $sea;
    private $forest;
    private $plains;

    function __construct( Sea $sea, Plains $plains, Forest $forest ) {
        $this->sea = $sea;
        $this->plains = $plains;
        $this->forest = $forest;
    }

    function getSea( ) {
        return clone $this->sea;
    }

    function getPlains( ) {
        return clone $this->plains;
    }

    function getForest( ) {
        return clone $this->forest;
    }
}

$factory = new TerrainFactory( new EarthSea(),
    new EarthPlains(),
    new EarthForest() );
print_r( $factory->getSea() );
print_r( $factory->getPlains() );
print_r( $factory->getForest() );
```