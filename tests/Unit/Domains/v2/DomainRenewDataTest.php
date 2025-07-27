<?php

namespace Tests\Unit\Domains\v2;

use GoDaddy\Services\Domains\v2\DTO\DomainRenewData;
use PHPUnit\Framework\TestCase;

class DomainRenewDataTest extends TestCase
{
    public function testConstructorAndGetters()
    {
        $data = new DomainRenewData(1);

        $this->assertEquals(1, $data->period);
    }

    public function testToArray()
    {
        $data = new DomainRenewData(1);

        $array = $data->toArray();

        $this->assertEquals([
            'period' => 1
        ], $array);
    }

    public function testFromArray()
    {
        $array = [
            'period' => 1
        ];

        $data = DomainRenewData::fromArray($array);

        $this->assertEquals(1, $data->period);
    }
} 
