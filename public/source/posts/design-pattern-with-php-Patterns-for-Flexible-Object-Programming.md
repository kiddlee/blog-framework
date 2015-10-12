##结构型模式
结构型模式：组合可比继承提供更多的灵活性。

* 组合模式(Composite): 将一组对象组合为可像单个对象一样被使用的结构。
* 装饰模式(Decorator): 通过在运行时合并对象来扩展功能的一种灵活机制。
* 外观模式(Facade): 为复杂或多边的系统创建一个简单的接口。

##组合模式
* 意图：将对象组合成树形结构以表示“部分-整体”的层次结构。Composite使得用户对单个对象和组合对象的使用具有一致性。
* 动机：一个游戏中的军队，可能有很多可移动的战斗单元组成，步兵、骑兵等。他们一起移动、进攻、防守。可能会有其他部队加入，也可能加入的部队要再分拆。
* 实现：组合模式定义了一个单根继承体系，使得具有截然不同值得的集合可以并肩工作。

```
#!/bin/env/php
<?php

abstract class Unit {
    function getComposite() {
        return null;
    }

    abstract function bombardStrength();
}


abstract class CompositeUnit extends Unit {
    private $units = array();

    function getComposite() {
        return $this;
    }

    protected function units() {
        return $this->units;
    }

    function removeUnit( Unit $unit ) {
        // >= php 5.3
        //$this->units = array_udiff( $this->units, array( $unit ), 
        //                function( $a, $b ) { return ($a === $b)?0:1; } );

        // < php 5.3
        $this->units = array_udiff( $this->units, array( $unit ), 
                        create_function( '$a,$b', 'return ($a === $b)?0:1;' ) );
    }

    function addUnit( Unit $unit ) {
        if ( in_array( $unit, $this->units, true ) ) {
            return;
        }
        $this->units[] = $unit;
    }
}
class Army extends CompositeUnit {

    function bombardStrength() {
        $ret = 0;
        foreach( $this->units as $unit ) {
            $ret += $unit->bombardStrength();
        }
        return $ret;
    }

}

class Archer extends Unit {
    function bombardStrength() {
        return 4;
    }
}

class LaserCannonUnit extends Unit {
    function bombardStrength() {
        return 44;
    }
}

class UnitScript {
    static function joinExisting( Unit $newUnit,
                                  Unit $occupyingUnit ) {
        $comp;

        if ( ! is_null( $comp = $occupyingUnit->getComposite() ) ) {
            $comp->addUnit( $newUnit );
        } else {
            $comp = new Army();
            $comp->addUnit( $occupyingUnit );
            $comp->addUnit( $newUnit );
        }
        return $comp;
    }
}

$army1 = new Army();
$army1->addUnit( new Archer() );
$army1->addUnit( new Archer() );

$army2 = new Army();
$army2->addUnit( new Archer() );
$army2->addUnit( new Archer() );
$army2->addUnit( new LaserCannonUnit() );

$composite = UnitScript::joinExisting( $army2, $army1 );
print_r( $composite );
```

##装饰模式
* 意图：动态地给一个对象添加一些额外的职责。就增加功能来说, 更为灵活。
* 动机：将所有功能都建立在继承体系上会导致系统中的类“爆炸式”增多，更糟糕的是对继承树上下不同分支做相同修改，会造成代码重复。例如：游戏中定义Tile（区域）定义，并且定义的到此区域内财富的方法getWealthFactor, Plain（平地）继承自Tile。如果我们需要在定义污染的平地和地表有钻石的平台，则需要再从Plain继承编写子类。区域的种类增多，则子类也会随之增多，继承树也会越来越庞大。则问题来了，此时，这个结构就显得不够灵活。
* 实现：

```
#!/bin/env/php
<?php

abstract class Tile {
    abstract function getWealthFactor();
}

class Plains extends Tile {
    private $wealthfactor = 2;
    function getWealthFactor() {
        return $this->wealthfactor;
    }
}

abstract class TileDecorator extends Tile {
    protected $tile;
    function __construct( Tile $tile ) {
        $this->tile = $tile;
    }
}

class DiamondDecorator extends TileDecorator {
    function getWealthFactor() {
        return $this->tile->getWealthFactor()+2;
    }
}

class PollutionDecorator extends TileDecorator {
    function getWealthFactor() {
        return $this->tile->getWealthFactor()-4;
    }
}

$tile = new Plains();
print $tile->getWealthFactor(); // 2

$tile = new DiamondDecorator( new Plains() );
print $tile->getWealthFactor(); // 4

$tile = new PollutionDecorator(
             new DiamondDecorator( new Plains() ));
print $tile->getWealthFactor(); // 0
```

##外观模式
* 意图：为子系统中的一组接口提供一个一致的界面,Facade模式定义了一个高层接口,这个接口使得这一子系统更加容易使用。
* 动机：当系统中引入第三方子系统，而且系统过于深入的调用子系统代码。当子系统代码不断变化，你的系统又在很多地方与子系统代码交互。随着子系统的发展，我们的代码维护会越来越困难。
* 实现：

```
!#/bin/env/php
<?php

function getProductFileLines( $file ) {
    return file( $file );
}

function getProductObjectFromId( $id, $productname ) {
    // some kind of database lookup
    return new Product( $id, $productname );
}

function getNameFromLine( $line ) {
    if ( preg_match( "/.*-(.*)\s\d+/", $line, $array ) ) {
        return str_replace( '_',' ', $array[1] );
    }
    return '';
}

function getIDFromLine( $line ) {
    if ( preg_match( "/^(\d{1,3})-/", $line, $array ) ) {
        return $array[1];
    }
    return -1;
}

class Product {
    public $id;
    public $name;
    function __construct( $id, $name ) {
        $this->id = $id;
        $this->name = $name;
    }
}

class ProductFacade {
    private $products = array();

    function __construct( $file ) {
        $this->file = $file;
        $this->compile();
    }

    private function compile() {
        $lines = getProductFileLines( $this->file );
        foreach ( $lines as $line ) {
            $id = getIDFromLine( $line );
            $name = getNameFromLine( $line );
            $this->products[$id] = getProductObjectFromID( $id, $name  );
        }
    }

    function getProducts() {
        return $this->products;
    }

    function getProduct( $id ) {
        return $this->products[$id];
    }
}

$facade = new ProductFacade( 'test.txt' );
$object = $facade->getProduct( 234 );

print_r( $object );
```