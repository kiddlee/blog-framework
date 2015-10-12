##行为模式
行为模式涉及到算法和对象间职责的分配。行为模式不仅描述对象或类的模式,还描述 它们之间的通信模式。

* 解释器(Interpreter)模式：构造一个可以用于创建脚本化应用的mini语言解释器。
* 策略(Strategy)模式：在系统中定义算法并以它们自己的类型封装。
* 观察者(Observer)模式：创建依赖关系，当有系统事件发生时通知观察者对象。
* 访问者(Vistor)模式：在对象树的所有节点上应用操作。
* 命令(Command)模式：创建可被保存和传送的命令对象。

##解释器模式
* 意图：给定一个语言,定义它的文法的一种表示,并定义一个解释器,这个解释器使用该表示 来解释语言中的句子。
* 动机：为高级用户提供一种领域语言（DSL —— Domain Specific Language，领域特定语言）可以使用户自己来扩展系统功能，但是又需要限制用户使用语言的权限，例如：用户输入"print file_get_content('/etc/passwd')"，程序执行后会获得系统权限。
* 实现：

```
!#/bin/env/php

```
##策略模式
* 意图：定义一系列的算法,把它们一个个封装起来, 并且使它们可相互替换。本模式使得算法可独 立于使用它的客户而变化。
* 动机：
* 实现：

```
!#/bin/env/php

```
##观察者模式
* 意图：定义对象间的一种一对多的依赖关系 ,当一个对象的状态发生改变时 , 所有依赖于它的对象 都得到通知并被自动更新。
* 动机：
* 实现：

```
!#/bin/env/php
<?php

interface Observable {
    function attach( Observer $observer );
    function detach( Observer $observer );
    function notify();
}

class Login implements Observable {
    private $observers = array();
    const LOGIN_USER_UNKNOWN = 1;
    const LOGIN_WRONG_PASS   = 2;
    const LOGIN_ACCESS       = 3;

    function attach( Observer $observer ) {
        $this->observers[] = $observer;
    }

    function detach( Observer $observer ) {
        // >= php 5.3
        //$this->observers = array_udiff( $this->observers, array( $observer ), 
        //                function( $a, $b ) { return ($a === $b)?0:1; } );

        // < php 5.3
        $this->observers = array_udiff( $this->observers, array( $observer ), 
                        create_function( '$a,$b', 'return ($a === $b)?0:1;') );
    }

    function notify() {
        foreach ( $this->observers as $obs ) {
            $obs->update( $this );
        }
    }

    function handleLogin( $user, $pass, $ip ) {
        switch ( rand(1,3) ) {
            case 1: 
                $this->setStatus( self::LOGIN_ACCESS, $user, $ip );
                $ret = true; break;
            case 2:
                $this->setStatus( self::LOGIN_WRONG_PASS, $user, $ip );
                $ret = false; break;
            case 3:
                $this->setStatus( self::LOGIN_USER_UNKNOWN, $user, $ip );
                $ret = false; break;
        }
        $this->notify();
        return $ret;
    }

    private function setStatus( $status, $user, $ip ) {
        $this->status = array( $status, $user, $ip ); 
    }

    function getStatus() {
        return $this->status;
    }

}

interface Observer {
    function update( Observable $observer );
}

abstract class LoginObserver implements Observer {
    private $login;
    function __construct( Login $login ) {
        $this->login = $login; 
        $login->attach( $this );
    }

    function update( Observable $observable ) {
        if ( $observable === $this->login ) {
            $this->doUpdate( $observable );
        }
    }

    abstract function doUpdate( Login $login );
} 

class SecurityMonitor extends LoginObserver {
    function doUpdate( Login $login ) {
        $status = $login->getStatus(); 
        if ( $status[0] == Login::LOGIN_WRONG_PASS ) {
            // send mail to sysadmin 
            print __CLASS__.":\tsending mail to sysadmin\n"; 
        }
    }
}

class GeneralLogger  extends LoginObserver {
    function doUpdate( Login $login ) {
        $status = $login->getStatus(); 
        // add login data to log
        print __CLASS__.":\tadd login data to log\n"; 
    }
}

class PartnershipTool extends LoginObserver {
    function doUpdate( Login $login ) {
        $status = $login->getStatus(); 
        // check $ip address 
        // set cookie if it matches a list
        print __CLASS__.":\tset cookie if it matches a list\n"; 
    }
}

$login = new Login();
new SecurityMonitor( $login );
new GeneralLogger( $login );
$pt = new PartnershipTool( $login );
$login->detach( $pt );
for ( $x=0; $x<10; $x++ ) {
    $login->handleLogin( "bob","mypass", '158.152.55.35' );
    print "\n";
}

```
##访问者模式
* 意图：表示一个作用于某对象结构中的各元素的操作。它使你可以在不改变各元素的类的前提 下定义作用于这些元素的新操作。
* 动机：
* 实现：

```
!#/bin/env/php
<?php

class UnitException extends Exception {}

class TextDumpArmyVisitor extends ArmyVisitor {
    private $text="";

    function visit( Unit $node ) {
        $ret = "";
        $pad = 4*$node->getDepth();
        $ret .= sprintf( "%{$pad}s", "" );
        $ret .= get_class($node).": ";
        $ret .= "bombard: ".$node->bombardStrength()."\n";
        $this->text .= $ret;
    }
    function getText() {
        return $this->text;
    }
}

class TaxCollectionVisitor extends ArmyVisitor {
    private $due=0;
    private $report="";

    function visit( Unit $node ) {
        $this->levy( $node, 1 );
    }

    function visitArcher( Archer $node ) {
        $this->levy( $node, 2 );
    }

    function visitCavalry( Cavalry $node ) {
        $this->levy( $node, 3 );
    }

    function visitTroopCarrierUnit( TroopCarrierUnit $node ) {
        $this->levy( $node, 5 );
    }

    private function levy( Unit $unit, $amount ) {
        $this->report .= "Tax levied for ".get_class( $unit );
        $this->report .= ": $amount\n";
        $this->due += $amount;
    }

    function getReport() {
        return $this->report;
    }

    function getTax() {
        return $this->due;
    }
}

abstract class ArmyVisitor  {
    abstract function visit( Unit $node );

    function visitArcher( Archer $node ) {
        $this->visit( $node );
    }
    function visitCavalry( Cavalry $node ) {
        $this->visit( $node );
    }

    function visitLaserCanonUnit( LaserCanonUnit $node ) {
        $this->visit( $node );
    }

    function visitTroopCarrierUnit( TroopCarrierUnit $node ) {
        $this->visit( $node );
    }

    function visitArmy( Army $node ) {
        $this->visit( $node );
    }
}

abstract class Unit {
    protected $depth = 0;

    function getComposite() {
        return null;
    }
    
    protected function setDepth( $depth ) {
        $this->depth=$depth;
    }

    function getDepth() {
        return $this->depth;
    }

    abstract function bombardStrength();

    function accept( ArmyVisitor $visitor ) {
        $method = "visit".get_class( $this );
        $visitor->$method( $this );
    }
}

class Archer extends Unit {
    function bombardStrength() {
        return 4;
    }

}

class Cavalry extends Unit {
    function bombardStrength() {
        return 2;
    }
}

class LaserCanonUnit extends Unit {
    function bombardStrength() {
        return 44;
    }
}

abstract class CompositeUnit extends Unit {
    private $units = array();

    function getComposite() {
        return $this;
    }

    function units() {
        return $this->units;
    }

    function removeUnit( Unit $unit ) {
        $units = array();
        foreach ( $this->units as $thisunit ) {
            if ( $unit !== $thisunit ) {
                $units[] = $thisunit;
            }
        }
        $this->units = $units;
    }
/*
    function accept( ArmyVisitor $visitor ) {
        $method = "visit".get_class( $this );
        $visitor->$method( $this );
        foreach ( $this->units as $thisunit ) {
            $thisunit->accept( $visitor );
        }
    }
*/

    function accept( ArmyVisitor $visitor ) {
        parent::accept( $visitor );
        foreach ( $this->units as $thisunit ) {
            $thisunit->accept( $visitor );
        }
    }

    function addUnit( Unit $unit ) {
        foreach ( $this->units as $thisunit ) {
            if ( $unit === $thisunit ) {
                return;
            }
        }
        $unit->setDepth($this->depth+1);
        $this->units[] = $unit;
    }
}

class TroopCarrier extends CompositeUnit {

    function addUnit( Unit $unit ) {
        if ( $unit instanceof Cavalry ) {
            throw new UnitException("Can't get a horse on the vehicle");
        }
        parent::addUnit( $unit );
    }

    function bombardStrength() {
        return 0;
    }
}

class Army extends CompositeUnit {

    function bombardStrength() {
        $ret = 0;
        foreach( $this->units() as $unit ) {
            $ret += $unit->bombardStrength();
        }
        return $ret;
    }
}

$main_army = new Army();
$main_army->addUnit( new Archer() );
$main_army->addUnit( new LaserCanonUnit() );
$main_army->addUnit( new Cavalry() );

$textdump = new TextDumpArmyVisitor();
$main_army->accept( $textdump  );
print $textdump->getText();
$taxcollector = new TaxCollectionVisitor();
$main_army->accept( $taxcollector );
print $taxcollector->getReport();
print "TOTAL: ";
print $taxcollector->getTax()."\n";
```
##命令模式
* 意图：将一个请求封装为一个对象,从而使你可用不同的请求对客户进行参数化;对请求排队或记录请求日志,以及支持可撤消的操作。
* 动机：
* 实现：

```
!#/bin/env/php
<?php

class CommandNotFoundException extends Exception {}

class CommandFactory {
    private static $dir = 'commands';

    static function getCommand( $action='Default' ) {
        if ( preg_match( '/\W/', $action ) ) {
            throw new Exception("illegal characters in action");
        }
        $class = UCFirst(strtolower($action))."Command";  
        $file = self::$dir.DIRECTORY_SEPARATOR."$class.php";
        if ( ! file_exists( $file ) ) {
            throw new CommandNotFoundException( "could not find '$file'" );
        }
        require_once( $file );
        if ( ! class_exists( $class ) ) {
            throw new CommandNotFoundException( "no '$class' class located" );
        }
        $cmd = new $class();
        return $cmd;
    }
}

class Controller {
    private $context;
    function __construct() {
        $this->context = new CommandContext();
    }

    function getContext() {
        return $this->context;
    }

    function process() {
        $cmd = CommandFactory::getCommand( $this->context->get('action') );
        if ( ! $cmd->execute( $this->context ) ) {
            // handle failure
        } else {
            // success
            // dispatch view
        }
    } 
}    




// ------------- helper stuff
class User{
    private $name;
    function __construct( $name ) {
        $this->name = $name;
    }
}

class Registry {
    static function getMessageSystem() {
        return new MessageSystem();
    }
    static function getAccessManager() {
        return new AccessManager();
    }
}

class MessageSystem {
    function send( $mail, $msg, $topic ) {
        print "sending $mail: $topic: $msg\n";
        return true;
    }

    function getError() {
        return "move along now, nothing to see here";
    }
}

class AccessManager {
    function login( $user, $pass ) {
        $ret = new User( $user );
        return $ret;
    }

    function getError() {
        return "move along now, nothing to see here";
    }
}

class CommandContext {
    private $params = array();
    private $error = "";

    function __construct() {
        $this->params = $_REQUEST;
    }

    function addParam( $key, $val ) { 
        $this->params[$key]=$val;
    }

    function get( $key ) { 
        return $this->params[$key];
    }

    function setError( $error ) {
        $this->error = $error;
    }

    function getError() {
        return $this->error;
    }
}

$controller = new Controller();
$context = $controller->getContext();
$context->addParam('action', 'feedback' );
$context->addParam('email', 'bob@bob.com' );
$context->addParam('topic', 'my brain' );
$context->addParam('msg', 'all about my brain' );
$controller->process();
print $context->getError();

```