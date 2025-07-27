<?php

namespace Tests\Unit\Domains\v2;

use GoDaddy\Services\Domains\v2\DTO\DomainTransferData;
use PHPUnit\Framework\TestCase;

class DomainTransferDataTest extends TestCase
{
    public function testConstructorAndGetters()
    {
        $data = new DomainTransferData('auth-code-123', 'consent-data');

        $this->assertEquals('auth-code-123', $data->authCode);
        $this->assertEquals('consent-data', $data->consent);
    }

    public function testConstructorWithoutConsent()
    {
        $data = new DomainTransferData('auth-code-123');

        $this->assertEquals('auth-code-123', $data->authCode);
        $this->assertNull($data->consent);
    }

    public function testToArray()
    {
        $data = new DomainTransferData('auth-code-123', 'consent-data');

        $array = $data->toArray();

        $this->assertEquals([
            'authCode' => 'auth-code-123',
            'consent' => 'consent-data'
        ], $array);
    }

    public function testToArrayWithoutConsent()
    {
        $data = new DomainTransferData('auth-code-123');

        $array = $data->toArray();

        $this->assertEquals([
            'authCode' => 'auth-code-123'
        ], $array);
    }

    public function testFromArray()
    {
        $array = [
            'authCode' => 'auth-code-123',
            'consent' => 'consent-data'
        ];

        $data = DomainTransferData::fromArray($array);

        $this->assertEquals('auth-code-123', $data->authCode);
        $this->assertEquals('consent-data', $data->consent);
    }

    public function testFromArrayWithoutConsent()
    {
        $array = [
            'authCode' => 'auth-code-123'
        ];

        $data = DomainTransferData::fromArray($array);

        $this->assertEquals('auth-code-123', $data->authCode);
        $this->assertNull($data->consent);
    }
} 
