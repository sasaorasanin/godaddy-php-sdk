<?php

namespace Tests\Unit\Domains\v2;

use GoDaddy\Services\Domains\v2\DTO\PrivacyForwardingData;
use PHPUnit\Framework\TestCase;

class PrivacyForwardingDataTest extends TestCase
{
    public function testConstructorAndGetters()
    {
        $data = new PrivacyForwardingData('test@example.com');

        $this->assertEquals('test@example.com', $data->email);
    }

    public function testToArray()
    {
        $data = new PrivacyForwardingData('test@example.com');

        $array = $data->toArray();

        $this->assertEquals([
            'email' => 'test@example.com'
        ], $array);
    }

    public function testFromArray()
    {
        $array = [
            'email' => 'test@example.com'
        ];

        $data = PrivacyForwardingData::fromArray($array);

        $this->assertEquals('test@example.com', $data->email);
    }
} 
