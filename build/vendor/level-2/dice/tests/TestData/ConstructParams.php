<?php

namespace pinkcrab_cccp_0_0_1;

/* @description Dice - A minimal Dependency Injection Container for PHP *
 * @author Tom Butler tom@r.je *
 * @copyright 2012-2018 Tom Butler <tom@r.je> | https:// r.je/dice.html *
 * @license http:// www.opensource.org/licenses/bsd-license.php BSD License *
 * @version 3.0 */
class MyDirectoryIterator extends \DirectoryIterator
{
}
/* @description Dice - A minimal Dependency Injection Container for PHP *
 * @author Tom Butler tom@r.je *
 * @copyright 2012-2018 Tom Butler <tom@r.je> | https:// r.je/dice.html *
 * @license http:// www.opensource.org/licenses/bsd-license.php BSD License *
 * @version 3.0 */
\class_alias('pinkcrab_cccp_0_0_1\\MyDirectoryIterator', 'MyDirectoryIterator', \false);
class MyDirectoryIterator2 extends \DirectoryIterator
{
    public function __construct($f)
    {
        parent::__construct($f);
    }
}
\class_alias('pinkcrab_cccp_0_0_1\\MyDirectoryIterator2', 'MyDirectoryIterator2', \false);
class ParamRequiresArgs
{
    public $a;
    public function __construct(\pinkcrab_cccp_0_0_1\D $d, \pinkcrab_cccp_0_0_1\RequiresConstructorArgsA $a)
    {
        $this->a = $a;
    }
}
\class_alias('pinkcrab_cccp_0_0_1\\ParamRequiresArgs', 'ParamRequiresArgs', \false);
class RequiresConstructorArgsB
{
    public $a;
    public $foo;
    public $bar;
    public function __construct(\pinkcrab_cccp_0_0_1\A $a, $foo, $bar)
    {
        $this->a = $a;
        $this->foo = $foo;
        $this->bar = $bar;
    }
}
\class_alias('pinkcrab_cccp_0_0_1\\RequiresConstructorArgsB', 'RequiresConstructorArgsB', \false);
trait MyTrait
{
    public function foo()
    {
    }
}
class MyDirectoryIteratorWithTrait extends \DirectoryIterator
{
    use MyTrait;
}
\class_alias('pinkcrab_cccp_0_0_1\\MyDirectoryIteratorWithTrait', 'MyDirectoryIteratorWithTrait', \false);
class NullScalar
{
    public $string;
    public function __construct($string = null)
    {
        $this->string = $string;
    }
}
\class_alias('pinkcrab_cccp_0_0_1\\NullScalar', 'NullScalar', \false);
class NullScalarNested
{
    public $nullScalar;
    public function __construct(\pinkcrab_cccp_0_0_1\NullScalar $nullScalar)
    {
        $this->nullScalar = $nullScalar;
    }
}
\class_alias('pinkcrab_cccp_0_0_1\\NullScalarNested', 'NullScalarNested', \false);
class NB
{
}
\class_alias('pinkcrab_cccp_0_0_1\\NB', 'NB', \false);
class NC
{
}
\class_alias('pinkcrab_cccp_0_0_1\\NC', 'NC', \false);
class MethodWithTwoDefaultNullC
{
    public $a;
    public $b;
    public function __construct($a = null, \pinkcrab_cccp_0_0_1\NB $b = null)
    {
        $this->a = $a;
        $this->b = $b;
    }
}
\class_alias('pinkcrab_cccp_0_0_1\\MethodWithTwoDefaultNullC', 'MethodWithTwoDefaultNullC', \false);
class MethodWithTwoDefaultNullCC
{
    public $a;
    public $b;
    public $c;
    public function __construct($a = null, \pinkcrab_cccp_0_0_1\NB $b = null, \pinkcrab_cccp_0_0_1\NC $c = null)
    {
        $this->a = $a;
        $this->b = $b;
        $this->c = $c;
    }
}
\class_alias('pinkcrab_cccp_0_0_1\\MethodWithTwoDefaultNullCC', 'MethodWithTwoDefaultNullCC', \false);
class NullableClassTypeHint
{
    public $obj;
    public function __construct(?\pinkcrab_cccp_0_0_1\D $obj)
    {
        $this->obj = $obj;
    }
}
\class_alias('pinkcrab_cccp_0_0_1\\NullableClassTypeHint', 'NullableClassTypeHint', \false);
