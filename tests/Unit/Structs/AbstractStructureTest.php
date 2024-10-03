<?php

declare(strict_types=1);

namespace Structs;

use Tests\BaseTestCase;
use Tests\Helpers\Structs\TestStructureOne;

class AbstractStructureTest extends BaseTestCase
{
    public function testToArray(): void
    {
        $structOne = new TestStructureOne();
        $structOne->name = 'one';

        $structTwo = new TestStructureOne();
        $structTwo->name = 'two';
        $structTwo->array = [
            'key' => 'value',
            'one' => $structOne,
        ];

        $return = $structTwo->toArray();

        $this->assertEquals('two', $return['name']);
        $this->assertIsArray($return['array']);
        $this->assertEquals('value', $return['array']['key']);
        $this->assertIsArray($return['array']['one']);
        $this->assertEquals('one', $return['array']['one']['name']);
    }
}
