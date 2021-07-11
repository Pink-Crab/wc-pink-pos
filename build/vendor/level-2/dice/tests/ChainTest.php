<?php

namespace pinkcrab_cccp_0_0_1;

/* @description Dice - A minimal Dependency Injection Container for PHP *
 * @author Tom Butler tom@r.je *
 * @copyright 2012-2018 Tom Butler <tom@r.je> | https:// r.je/dice.html *
 * @license http:// www.opensource.org/licenses/bsd-license.php BSD License *
 * @version 3.0 */
class ChainTest extends \pinkcrab_cccp_0_0_1\DiceTest
{
    public function testChainCall()
    {
        $dice = $this->dice->addRules(['$someClass' => ['instanceOf' => 'Factory', 'call' => [['get', [], \pinkcrab_cccp_0_0_1\Dice\Dice::CHAIN_CALL]]]]);
        $obj = $dice->create('$someClass');
        $this->assertInstanceOf('FactoryDependency', $obj);
    }
    public function testMultipleChainCall()
    {
        $dice = $this->dice->addRules(['$someClass' => ['instanceOf' => 'Factory', 'call' => [['get', [], \pinkcrab_cccp_0_0_1\Dice\Dice::CHAIN_CALL], ['getBar', [], \pinkcrab_cccp_0_0_1\Dice\Dice::CHAIN_CALL]]]]);
        $obj = $dice->create('$someClass');
        $this->assertEquals('bar', $obj);
    }
    public function testChainCallShared()
    {
        $dice = $this->dice->addRules(['$someClass' => ['shared' => \true, 'instanceOf' => 'Factory', 'call' => [['get', [], \pinkcrab_cccp_0_0_1\Dice\Dice::CHAIN_CALL]]]]);
        $obj = $dice->create('$someClass');
        $this->assertInstanceOf('FactoryDependency', $obj);
    }
    public function testChainCallInject()
    {
        $dice = $this->dice->addRules(['FactoryDependency' => ['instanceOf' => 'Factory', 'call' => [['get', [], \pinkcrab_cccp_0_0_1\Dice\Dice::CHAIN_CALL]]]]);
        $obj = $dice->create('RequiresFactoryDependecy');
        $this->assertInstanceOf('FactoryDependency', $obj->dep);
    }
    public function testChainCallInjectShared()
    {
        $dice = $this->dice->addRules(['FactoryDependency' => ['shared' => \true, 'instanceOf' => 'Factory', 'call' => [['get', [], \pinkcrab_cccp_0_0_1\Dice\Dice::CHAIN_CALL]]]]);
        $dice->create('FactoryDependency');
        $obj = $dice->create('RequiresFactoryDependecy');
        $this->assertInstanceOf('FactoryDependency', $obj->dep);
        $obj2 = $dice->create('RequiresFactoryDependecy');
        $this->assertNotSame($obj, $obj2);
        $this->assertSame($obj->dep, $obj2->dep);
    }
}
/* @description Dice - A minimal Dependency Injection Container for PHP *
 * @author Tom Butler tom@r.je *
 * @copyright 2012-2018 Tom Butler <tom@r.je> | https:// r.je/dice.html *
 * @license http:// www.opensource.org/licenses/bsd-license.php BSD License *
 * @version 3.0 */
\class_alias('pinkcrab_cccp_0_0_1\\ChainTest', 'ChainTest', \false);
class Factory
{
    public function get()
    {
        return new \pinkcrab_cccp_0_0_1\FactoryDependency();
    }
}
\class_alias('pinkcrab_cccp_0_0_1\\Factory', 'Factory', \false);
class FactoryDependency
{
    public function getBar()
    {
        return 'bar';
    }
}
\class_alias('pinkcrab_cccp_0_0_1\\FactoryDependency', 'FactoryDependency', \false);
class RequiresFactoryDependecy
{
    public $dep;
    public function __construct(\pinkcrab_cccp_0_0_1\FactoryDependency $dep)
    {
        $this->dep = $dep;
    }
}
\class_alias('pinkcrab_cccp_0_0_1\\RequiresFactoryDependecy', 'RequiresFactoryDependecy', \false);
