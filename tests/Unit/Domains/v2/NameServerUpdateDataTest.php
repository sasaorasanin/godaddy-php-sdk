<?php

namespace Tests\Unit\Domains\v2;

use GoDaddy\Services\Domains\v2\DTO\NameServerUpdateData;
use PHPUnit\Framework\TestCase;

class NameServerUpdateDataTest extends TestCase
{
    public function testConstructorAndGetters()
    {
        $nameServers = ['ns1.example.com', 'ns2.example.com'];
        $data = new NameServerUpdateData($nameServers);

        $this->assertEquals($nameServers, $data->nameServers);
    }

    public function testToArray()
    {
        $nameServers = ['ns1.example.com', 'ns2.example.com'];
        $data = new NameServerUpdateData($nameServers);

        $array = $data->toArray();

        $this->assertEquals([
            'nameServers' => $nameServers
        ], $array);
    }

    public function testFromArray()
    {
        $nameServers = ['ns1.example.com', 'ns2.example.com'];
        $array = [
            'nameServers' => $nameServers
        ];

        $data = NameServerUpdateData::fromArray($array);

        $this->assertEquals($nameServers, $data->nameServers);
    }
} 
