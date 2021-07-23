<?php

namespace pc_pink_pos_0_0_1;

/* @description Dice - A minimal Dependency Injection Container for PHP *
 * @author Tom Butler tom@r.je *
 * @copyright 2012-2018 Tom Butler <tom@r.je> | https:// r.je/dice.html *
 * @license http:// www.opensource.org/licenses/bsd-license.php BSD License *
 * @version 3.0 */
class TestCall
{
    public $isCalled = \false;
    public function callMe()
    {
        $this->isCalled = \true;
    }
}
/* @description Dice - A minimal Dependency Injection Container for PHP *
 * @author Tom Butler tom@r.je *
 * @copyright 2012-2018 Tom Butler <tom@r.je> | https:// r.je/dice.html *
 * @license http:// www.opensource.org/licenses/bsd-license.php BSD License *
 * @version 3.0 */
\class_alias('pc_pink_pos_0_0_1\\TestCall', 'TestCall', \false);
class TestCall2
{
    public $foo;
    public $bar;
    public function callMe($foo, $bar)
    {
        $this->foo = $foo;
        $this->bar = $bar;
    }
}
\class_alias('pc_pink_pos_0_0_1\\TestCall2', 'TestCall2', \false);
class TestCall3
{
    public $a;
    public function callMe(\pc_pink_pos_0_0_1\A $a)
    {
        $this->a = $a;
        return 'callMe called';
    }
}
\class_alias('pc_pink_pos_0_0_1\\TestCall3', 'TestCall3', \false);
class TestCallImmutable
{
    public $a;
    public $b;
    public function call1($a)
    {
        $new = clone $this;
        $new->a = $a;
        return $new;
    }
    public function call2($b)
    {
        $new = clone $this;
        $new->b = $b;
        return $new;
    }
}
\class_alias('pc_pink_pos_0_0_1\\TestCallImmutable', 'TestCallImmutable', \false);
class TestCallVariadic
{
    public $data;
    public function callMe(...$data)
    {
        $this->data = $data;
    }
}
\class_alias('pc_pink_pos_0_0_1\\TestCallVariadic', 'TestCallVariadic', \false);
