<?php

declare (strict_types=1);
/**
 * tests the Is_JsonSerializableable interface on collections.
 *
 * @since 0.1.0
 * @author Glynn Quelch <glynn.quelch@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.html  MIT License
 * @package PinkCrab\Collection
 */
namespace pc_pink_pos_0_0_1\PinkCrab\Core\Tests\Collection;

use pc_pink_pos_0_0_1\PinkCrab\Collection\Tests\Fixtures\Json_Serializeable_Collection;
use PHPUnit\Framework\TestCase;
class Test_Json_Serializeable_Collection extends \PHPUnit\Framework\TestCase
{
    public function test_can_json_encode()
    {
        $array = array(1, 2, 3, 4, 5);
        $collection = new \pc_pink_pos_0_0_1\PinkCrab\Collection\Tests\Fixtures\Json_Serializeable_Collection($array);
        $this->assertSame(\json_encode($array), \json_encode($collection));
    }
}
