<?php

namespace pc_pink_pos_0_0_1;

/* @description Dice - A minimal Dependency Injection Container for PHP *
 * @author Tom Butler tom@r.je *
 * @copyright 2012-2018 Tom Butler <tom@r.je> | https:// r.je/dice.html *
 * @license http:// www.opensource.org/licenses/bsd-license.php BSD License *
 * @version 3.0 */
class TestSharedInstancesTop
{
    public $share1;
    public $share2;
    public function __construct(\pc_pink_pos_0_0_1\SharedInstanceTest1 $share1, \pc_pink_pos_0_0_1\SharedInstanceTest2 $share2)
    {
        $this->share1 = $share1;
        $this->share2 = $share2;
    }
}
/* @description Dice - A minimal Dependency Injection Container for PHP *
 * @author Tom Butler tom@r.je *
 * @copyright 2012-2018 Tom Butler <tom@r.je> | https:// r.je/dice.html *
 * @license http:// www.opensource.org/licenses/bsd-license.php BSD License *
 * @version 3.0 */
\class_alias('pc_pink_pos_0_0_1\\TestSharedInstancesTop', 'TestSharedInstancesTop', \false);
class SharedInstanceTest1
{
    public $shared;
    public function __construct(\pc_pink_pos_0_0_1\Shared $shared)
    {
        $this->shared = $shared;
    }
}
\class_alias('pc_pink_pos_0_0_1\\SharedInstanceTest1', 'SharedInstanceTest1', \false);
class SharedInstanceTest2
{
    public $shared;
    public function __construct(\pc_pink_pos_0_0_1\Shared $shared)
    {
        $this->shared = $shared;
    }
}
\class_alias('pc_pink_pos_0_0_1\\SharedInstanceTest2', 'SharedInstanceTest2', \false);
class M1
{
    public $f;
    public function __construct(\pc_pink_pos_0_0_1\F $f)
    {
        $this->f = $f;
    }
}
\class_alias('pc_pink_pos_0_0_1\\M1', 'M1', \false);
class M2
{
    public $e;
    public function __construct(\pc_pink_pos_0_0_1\E $e)
    {
        $this->e = $e;
    }
}
\class_alias('pc_pink_pos_0_0_1\\M2', 'M2', \false);
class Foo77
{
    public $bar;
    public function __construct(\pc_pink_pos_0_0_1\Bar77 $bar)
    {
        $this->bar = $bar;
    }
}
\class_alias('pc_pink_pos_0_0_1\\Foo77', 'Foo77', \false);
class Bar77
{
    public $a;
    public function __construct($a)
    {
        $this->a = $a;
    }
}
\class_alias('pc_pink_pos_0_0_1\\Bar77', 'Bar77', \false);
class Baz77
{
    public static function create()
    {
        return new \pc_pink_pos_0_0_1\Bar77('Z');
    }
}
\class_alias('pc_pink_pos_0_0_1\\Baz77', 'Baz77', \false);
class Shared
{
    public $uniq;
    public function __construct()
    {
        $this->uniq = \uniqid();
    }
}
\class_alias('pc_pink_pos_0_0_1\\Shared', 'Shared', \false);
