<?php

namespace pc_pink_pos_0_0_1;

/* @description Dice - A minimal Dependency Injection Container for PHP *
 * @author Tom Butler tom@r.je *
 * @copyright 2012-2018 Tom Butler <tom@r.je> | https:// r.je/dice.html *
 * @license http:// www.opensource.org/licenses/bsd-license.php BSD License *
 * @version 3.0 */
class NoConstructor
{
    public $a = 'b';
}
/* @description Dice - A minimal Dependency Injection Container for PHP *
 * @author Tom Butler tom@r.je *
 * @copyright 2012-2018 Tom Butler <tom@r.je> | https:// r.je/dice.html *
 * @license http:// www.opensource.org/licenses/bsd-license.php BSD License *
 * @version 3.0 */
\class_alias('pc_pink_pos_0_0_1\\NoConstructor', 'NoConstructor', \false);
class CyclicA
{
    public $b;
    public function __construct(\pc_pink_pos_0_0_1\CyclicB $b)
    {
        $this->b = $b;
    }
}
\class_alias('pc_pink_pos_0_0_1\\CyclicA', 'CyclicA', \false);
class CyclicB
{
    public $a;
    public function __construct(\pc_pink_pos_0_0_1\CyclicA $a)
    {
        $this->a = $a;
    }
}
\class_alias('pc_pink_pos_0_0_1\\CyclicB', 'CyclicB', \false);
class A
{
    public $b;
    public function __construct(\pc_pink_pos_0_0_1\B $b)
    {
        $this->b = $b;
    }
}
\class_alias('pc_pink_pos_0_0_1\\A', 'A', \false);
class B
{
    public $c;
    public function __construct(\pc_pink_pos_0_0_1\C $c)
    {
        $this->c = $c;
    }
}
\class_alias('pc_pink_pos_0_0_1\\B', 'B', \false);
class ExtendedB extends \pc_pink_pos_0_0_1\B
{
}
\class_alias('pc_pink_pos_0_0_1\\ExtendedB', 'ExtendedB', \false);
class C
{
    public $d;
    public $e;
    public function __construct(\pc_pink_pos_0_0_1\D $d, \pc_pink_pos_0_0_1\E $e)
    {
        $this->d = $d;
        $this->e = $e;
    }
}
\class_alias('pc_pink_pos_0_0_1\\C', 'C', \false);
class D
{
}
\class_alias('pc_pink_pos_0_0_1\\D', 'D', \false);
class E
{
    public $f;
    public function __construct(\pc_pink_pos_0_0_1\F $f)
    {
        $this->f = $f;
    }
}
\class_alias('pc_pink_pos_0_0_1\\E', 'E', \false);
class F
{
}
\class_alias('pc_pink_pos_0_0_1\\F', 'F', \false);
class RequiresConstructorArgsA
{
    public $foo;
    public $bar;
    public function __construct($foo, $bar)
    {
        $this->foo = $foo;
        $this->bar = $bar;
    }
}
\class_alias('pc_pink_pos_0_0_1\\RequiresConstructorArgsA', 'RequiresConstructorArgsA', \false);
class MyObj
{
    private $foo;
    public function setFoo($foo)
    {
        $this->foo = $foo;
    }
    public function getFoo()
    {
        return $this->foo;
    }
}
\class_alias('pc_pink_pos_0_0_1\\MyObj', 'MyObj', \false);
class MethodWithDefaultValue
{
    public $a;
    public $foo;
    public function __construct(\pc_pink_pos_0_0_1\A $a, $foo = 'bar')
    {
        $this->a = $a;
        $this->foo = $foo;
    }
}
\class_alias('pc_pink_pos_0_0_1\\MethodWithDefaultValue', 'MethodWithDefaultValue', \false);
class MethodWithDefaultNull
{
    public $a;
    public $b;
    public function __construct(\pc_pink_pos_0_0_1\A $a, \pc_pink_pos_0_0_1\B $b = null)
    {
        $this->a = $a;
        $this->b = $b;
    }
}
\class_alias('pc_pink_pos_0_0_1\\MethodWithDefaultNull', 'MethodWithDefaultNull', \false);
interface interfaceTest
{
}
\class_alias('pc_pink_pos_0_0_1\\interfaceTest', 'interfaceTest', \false);
class InterfaceTestClass implements \pc_pink_pos_0_0_1\interfaceTest
{
}
\class_alias('pc_pink_pos_0_0_1\\InterfaceTestClass', 'InterfaceTestClass', \false);
class ParentClass
{
}
\class_alias('pc_pink_pos_0_0_1\\ParentClass', 'ParentClass', \false);
class Child extends \pc_pink_pos_0_0_1\ParentClass
{
}
\class_alias('pc_pink_pos_0_0_1\\Child', 'Child', \false);
class OptionalInterface
{
    public $obj;
    public function __construct(\pc_pink_pos_0_0_1\InterfaceTest $obj = null)
    {
        $this->obj = $obj;
    }
}
\class_alias('pc_pink_pos_0_0_1\\OptionalInterface', 'OptionalInterface', \false);
class ScalarTypeHint
{
    public function __construct(string $a = null)
    {
    }
}
\class_alias('pc_pink_pos_0_0_1\\ScalarTypeHint', 'ScalarTypeHint', \false);
class CheckConstructorArgs
{
    public $arg1;
    public function __construct($arg1)
    {
        $this->arg1 = $arg1;
    }
}
\class_alias('pc_pink_pos_0_0_1\\CheckConstructorArgs', 'CheckConstructorArgs', \false);
class someclass
{
}
\class_alias('pc_pink_pos_0_0_1\\someclass', 'someclass', \false);
class someotherclass
{
    public $obj;
    public function __construct(\pc_pink_pos_0_0_1\someclass $obj)
    {
        $this->obj = $obj;
    }
}
\class_alias('pc_pink_pos_0_0_1\\someotherclass', 'someotherclass', \false);
