<?php

namespace pc_pink_pos_0_0_1;

/* @description Dice - A minimal Dependency Injection Container for PHP *
 * @author Tom Butler tom@r.je *
 * @copyright 2012-2018 Tom Butler <tom@r.je> | https:// r.je/dice.html *
 * @license http:// www.opensource.org/licenses/bsd-license.php BSD License *
 * @version 3.0 */
class NamespaceTest extends \pc_pink_pos_0_0_1\DiceTest
{
    public function testNamespaceBasic()
    {
        $a = $this->dice->create('pc_pink_pos_0_0_1\\Foo\\A');
        $this->assertInstanceOf('pc_pink_pos_0_0_1\\Foo\\A', $a);
    }
    public function testNamespaceWithSlash()
    {
        $a = $this->dice->create('pc_pink_pos_0_0_1\\Foo\\A');
        $this->assertInstanceOf('pc_pink_pos_0_0_1\\Foo\\A', $a);
    }
    public function testNamespaceWithSlashrule()
    {
        $rule = [];
        $rule['substitutions']['Foo\\A'] = [\pc_pink_pos_0_0_1\Dice\Dice::INSTANCE => 'pc_pink_pos_0_0_1\\Foo\\ExtendedA'];
        $dice = $this->dice->addRule('pc_pink_pos_0_0_1\\Foo\\B', $rule);
        $b = $dice->create('pc_pink_pos_0_0_1\\Foo\\B');
        $this->assertInstanceOf('pc_pink_pos_0_0_1\\Foo\\ExtendedA', $b->a);
    }
    public function testNamespaceWithSlashruleInstance()
    {
        $rule = [];
        $rule['substitutions']['Foo\\A'] = [\pc_pink_pos_0_0_1\Dice\Dice::INSTANCE => 'pc_pink_pos_0_0_1\\Foo\\ExtendedA'];
        $dice = $this->dice->addRule('pc_pink_pos_0_0_1\\Foo\\B', $rule);
        $b = $dice->create('pc_pink_pos_0_0_1\\Foo\\B');
        $this->assertInstanceOf('pc_pink_pos_0_0_1\\Foo\\ExtendedA', $b->a);
    }
    public function testNamespaceTypeHint()
    {
        $rule = [];
        $rule['shared'] = \true;
        $dice = $this->dice->addRule('pc_pink_pos_0_0_1\\Bar\\A', $rule);
        $c = $dice->create('pc_pink_pos_0_0_1\\Foo\\C');
        $this->assertInstanceOf('pc_pink_pos_0_0_1\\Bar\\A', $c->a);
        $c2 = $dice->create('pc_pink_pos_0_0_1\\Foo\\C');
        $this->assertNotSame($c, $c2);
        //Check the rule has been correctly recognised for type hinted classes in a different namespace
        $this->assertSame($c2->a, $c->a);
    }
    public function testNamespaceInjection()
    {
        $b = $this->dice->create('pc_pink_pos_0_0_1\\Foo\\B');
        $this->assertInstanceOf('pc_pink_pos_0_0_1\\Foo\\B', $b);
        $this->assertInstanceOf('pc_pink_pos_0_0_1\\Foo\\A', $b->a);
    }
    public function testNamespaceRuleSubstitution()
    {
        $rule = [];
        $rule['substitutions']['Foo\\A'] = [\pc_pink_pos_0_0_1\Dice\Dice::INSTANCE => 'pc_pink_pos_0_0_1\\Foo\\ExtendedA'];
        $dice = $this->dice->addRule('pc_pink_pos_0_0_1\\Foo\\B', $rule);
        $b = $dice->create('pc_pink_pos_0_0_1\\Foo\\B');
        $this->assertInstanceOf('pc_pink_pos_0_0_1\\Foo\\ExtendedA', $b->a);
    }
}
/* @description Dice - A minimal Dependency Injection Container for PHP *
 * @author Tom Butler tom@r.je *
 * @copyright 2012-2018 Tom Butler <tom@r.je> | https:// r.je/dice.html *
 * @license http:// www.opensource.org/licenses/bsd-license.php BSD License *
 * @version 3.0 */
\class_alias('pc_pink_pos_0_0_1\\NamespaceTest', 'NamespaceTest', \false);
