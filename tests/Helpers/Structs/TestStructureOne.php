<?php

declare(strict_types=1);

namespace Tests\Helpers\Structs;

use Montonio\Structs\AbstractStruct;

class TestStructureOne extends AbstractStruct
{
    public string $name;
    public array $array;
}
