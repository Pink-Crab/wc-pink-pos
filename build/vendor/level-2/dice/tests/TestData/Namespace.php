<?php

/* @description Dice - A minimal Dependency Injection Container for PHP *
 * @author Tom Butler tom@r.je *
 * @copyright 2012-2018 Tom Butler <tom@r.je> | https:// r.je/dice.html *
 * @license http:// www.opensource.org/licenses/bsd-license.php BSD License *
 * @version 3.0 */
namespace pc_pink_pos_0_0_1\Foo;

class A
{
}
class B
{
    public $a;
    public function __construct(\pc_pink_pos_0_0_1\Foo\A $a)
    {
        $this->a = $a;
    }
}
class ExtendedA extends \pc_pink_pos_0_0_1\Foo\A
{
}
class C
{
    public $a;
    public function __construct(\pc_pink_pos_0_0_1\Bar\A $a)
    {
        $this->a = $a;
    }
}
namespace pc_pink_pos_0_0_1\Bar;

class A
{
}
class B
{
}
