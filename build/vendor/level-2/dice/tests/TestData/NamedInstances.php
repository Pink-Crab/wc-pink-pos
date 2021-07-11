<?php

namespace pinkcrab_cccp_0_0_1;

/* @description Dice - A minimal Dependency Injection Container for PHP *
 * @author Tom Butler tom@r.je *
 * @copyright 2012-2018 Tom Butler <tom@r.je> | https:// r.je/dice.html *
 * @license http:// www.opensource.org/licenses/bsd-license.php BSD License *
 * @version 3.0 */
class Z
{
    public $y1;
    public $y2;
    public function __construct(\pinkcrab_cccp_0_0_1\Y $y1, \pinkcrab_cccp_0_0_1\Y $y2)
    {
        $this->y1 = $y1;
        $this->y2 = $y2;
    }
}
/* @description Dice - A minimal Dependency Injection Container for PHP *
 * @author Tom Butler tom@r.je *
 * @copyright 2012-2018 Tom Butler <tom@r.je> | https:// r.je/dice.html *
 * @license http:// www.opensource.org/licenses/bsd-license.php BSD License *
 * @version 3.0 */
\class_alias('pinkcrab_cccp_0_0_1\\Z', 'Z', \false);
class Y1
{
    public $y2;
    public function __construct(\pinkcrab_cccp_0_0_1\Y2 $y2)
    {
        $this->y2 = $y2;
    }
}
\class_alias('pinkcrab_cccp_0_0_1\\Y1', 'Y1', \false);
class Y2
{
    public $name;
    public function __construct($name)
    {
        $this->name = $name;
    }
}
\class_alias('pinkcrab_cccp_0_0_1\\Y2', 'Y2', \false);
class Y3 extends \pinkcrab_cccp_0_0_1\Y2
{
}
\class_alias('pinkcrab_cccp_0_0_1\\Y3', 'Y3', \false);
class Y
{
    public $name;
    public function __construct($name)
    {
        $this->name = $name;
    }
}
\class_alias('pinkcrab_cccp_0_0_1\\Y', 'Y', \false);
class HasTwoSameDependencies
{
    public $y2a;
    public $y2b;
    public function __construct(\pinkcrab_cccp_0_0_1\Y2 $y2a, \pinkcrab_cccp_0_0_1\Y2 $y2b)
    {
        $this->y2a = $y2a;
        $this->y2b = $y2b;
    }
}
\class_alias('pinkcrab_cccp_0_0_1\\HasTwoSameDependencies', 'HasTwoSameDependencies', \false);
