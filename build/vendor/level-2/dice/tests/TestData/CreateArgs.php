<?php

namespace pc_pink_pos_0_0_1;

/* @description Dice - A minimal Dependency Injection Container for PHP *
 * @author Tom Butler tom@r.je *
 * @copyright 2012-2018 Tom Butler <tom@r.je> | https:// r.je/dice.html *
 * @license http:// www.opensource.org/licenses/bsd-license.php BSD License *
 * @version 3.0 */
class ConsumeArgsTop
{
    public $s;
    public $a;
    public function __construct(\pc_pink_pos_0_0_1\ConsumeArgsSub $a, $s)
    {
        $this->a = $a;
        $this->s = $s;
    }
}
/* @description Dice - A minimal Dependency Injection Container for PHP *
 * @author Tom Butler tom@r.je *
 * @copyright 2012-2018 Tom Butler <tom@r.je> | https:// r.je/dice.html *
 * @license http:// www.opensource.org/licenses/bsd-license.php BSD License *
 * @version 3.0 */
\class_alias('pc_pink_pos_0_0_1\\ConsumeArgsTop', 'ConsumeArgsTop', \false);
class ConsumeArgsSub
{
    public $s;
    public function __construct($s)
    {
        $this->s = $s;
    }
}
\class_alias('pc_pink_pos_0_0_1\\ConsumeArgsSub', 'ConsumeArgsSub', \false);
class A2
{
    public $b;
    public $c;
    public $foo;
    public function __construct(\pc_pink_pos_0_0_1\B $b, \pc_pink_pos_0_0_1\C $c, $foo)
    {
        $this->b = $b;
        $this->foo = $foo;
        $this->c = $c;
    }
}
\class_alias('pc_pink_pos_0_0_1\\A2', 'A2', \false);
class A3
{
    public $b;
    public $c;
    public $foo;
    public function __construct(\pc_pink_pos_0_0_1\C $c, $foo, \pc_pink_pos_0_0_1\B $b)
    {
        $this->b = $b;
        $this->foo = $foo;
        $this->c = $c;
    }
}
\class_alias('pc_pink_pos_0_0_1\\A3', 'A3', \false);
class A4
{
    public $m1;
    public $m2;
    public function __construct(\pc_pink_pos_0_0_1\M1 $m1, \pc_pink_pos_0_0_1\M2 $m2)
    {
        $this->m1 = $m1;
        $this->m2 = $m2;
    }
}
\class_alias('pc_pink_pos_0_0_1\\A4', 'A4', \false);
class BestMatch
{
    public $a;
    public $string;
    public $b;
    public function __construct($string, \pc_pink_pos_0_0_1\A $a, \pc_pink_pos_0_0_1\B $b)
    {
        $this->a = $a;
        $this->string = $string;
        $this->b = $b;
    }
}
\class_alias('pc_pink_pos_0_0_1\\BestMatch', 'BestMatch', \false);
//From: https://github.com/TomBZombie/Dice/issues/62#issuecomment-112370319
class ScalarConstructors
{
    public $string;
    public $null;
    public function __construct($string, $null)
    {
        $this->string = $string;
        $this->null = $null;
    }
}
//From: https://github.com/TomBZombie/Dice/issues/62#issuecomment-112370319
\class_alias('pc_pink_pos_0_0_1\\ScalarConstructors', 'ScalarConstructors', \false);
