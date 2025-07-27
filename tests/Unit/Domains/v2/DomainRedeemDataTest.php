<?php

namespace Tests\Unit\Domains\v2;

use GoDaddy\Services\Domains\v2\DTO\DomainRedeemData;
use PHPUnit\Framework\TestCase;

class DomainRedeemDataTest extends TestCase
{
    public function testConstructorAndGetters()
    {
        $data = new DomainRedeemData(1);

        $this->assertEquals(1, $data->period);
    }

    public function testToArray()
    {
        $data = new DomainRedeemData(1);

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

        $data = DomainRedeemData::fromArray($array);

        $this->assertEquals(1, $data->period);
    }
} 
