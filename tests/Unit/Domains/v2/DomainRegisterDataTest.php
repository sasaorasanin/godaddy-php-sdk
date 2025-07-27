<?php

namespace Tests\Unit\Domains\v2;

use GoDaddy\Services\Domains\v2\DTO\DomainRegisterData;
use PHPUnit\Framework\TestCase;

class DomainRegisterDataTest extends TestCase
{
    public function testConstructorAndGetters()
    {
        $consent = ['agreedAt' => '2023-01-01T00:00:00Z', 'agreedBy' => 'test@example.com'];
        $contacts = ['registrant' => ['nameFirst' => 'John', 'nameLast' => 'Doe']];
        $nameServers = ['ns1.example.com', 'ns2.example.com'];
        
        $data = new DomainRegisterData(
            domain: 'example.com',
            consent: $consent,
            contacts: $contacts,
            period: 1,
            privacy: true,
            renewAuto: true,
            nameServers: $nameServers
        );

        $this->assertEquals('example.com', $data->domain);
        $this->assertEquals($consent, $data->consent);
        $this->assertEquals($contacts, $data->contacts);
        $this->assertEquals(1, $data->period);
        $this->assertTrue($data->privacy);
        $this->assertTrue($data->renewAuto);
        $this->assertEquals($nameServers, $data->nameServers);
    }

    public function testConstructorWithMinimalData()
    {
        $consent = ['agreedAt' => '2023-01-01T00:00:00Z', 'agreedBy' => 'test@example.com'];
        $contacts = ['registrant' => ['nameFirst' => 'John', 'nameLast' => 'Doe']];
        
        $data = new DomainRegisterData(
            domain: 'example.com',
            consent: $consent,
            contacts: $contacts,
            period: 1
        );

        $this->assertEquals('example.com', $data->domain);
        $this->assertEquals($consent, $data->consent);
        $this->assertEquals($contacts, $data->contacts);
        $this->assertEquals(1, $data->period);
        $this->assertNull($data->privacy);
        $this->assertNull($data->renewAuto);
        $this->assertNull($data->nameServers);
    }

    public function testToArray()
    {
        $consent = ['agreedAt' => '2023-01-01T00:00:00Z', 'agreedBy' => 'test@example.com'];
        $contacts = ['registrant' => ['nameFirst' => 'John', 'nameLast' => 'Doe']];
        $nameServers = ['ns1.example.com', 'ns2.example.com'];
        
        $data = new DomainRegisterData(
            domain: 'example.com',
            consent: $consent,
            contacts: $contacts,
            period: 1,
            privacy: true,
            renewAuto: true,
            nameServers: $nameServers
        );

        $array = $data->toArray();

        $this->assertEquals([
            'domain' => 'example.com',
            'consent' => $consent,
            'contacts' => $contacts,
            'period' => 1,
            'privacy' => true,
            'renewAuto' => true,
            'nameServers' => $nameServers
        ], $array);
    }

    public function testToArrayWithMinimalData()
    {
        $consent = ['agreedAt' => '2023-01-01T00:00:00Z', 'agreedBy' => 'test@example.com'];
        $contacts = ['registrant' => ['nameFirst' => 'John', 'nameLast' => 'Doe']];
        
        $data = new DomainRegisterData(
            domain: 'example.com',
            consent: $consent,
            contacts: $contacts,
            period: 1
        );

        $array = $data->toArray();

        $this->assertEquals([
            'domain' => 'example.com',
            'consent' => $consent,
            'contacts' => $contacts,
            'period' => 1
        ], $array);
    }

    public function testFromArray()
    {
        $consent = ['agreedAt' => '2023-01-01T00:00:00Z', 'agreedBy' => 'test@example.com'];
        $contacts = ['registrant' => ['nameFirst' => 'John', 'nameLast' => 'Doe']];
        $nameServers = ['ns1.example.com', 'ns2.example.com'];
        
        $array = [
            'domain' => 'example.com',
            'consent' => $consent,
            'contacts' => $contacts,
            'period' => 1,
            'privacy' => true,
            'renewAuto' => true,
            'nameServers' => $nameServers
        ];

        $data = DomainRegisterData::fromArray($array);

        $this->assertEquals('example.com', $data->domain);
        $this->assertEquals($consent, $data->consent);
        $this->assertEquals($contacts, $data->contacts);
        $this->assertEquals(1, $data->period);
        $this->assertTrue($data->privacy);
        $this->assertTrue($data->renewAuto);
        $this->assertEquals($nameServers, $data->nameServers);
    }

    public function testFromArrayWithMinimalData()
    {
        $consent = ['agreedAt' => '2023-01-01T00:00:00Z', 'agreedBy' => 'test@example.com'];
        $contacts = ['registrant' => ['nameFirst' => 'John', 'nameLast' => 'Doe']];
        
        $array = [
            'domain' => 'example.com',
            'consent' => $consent,
            'contacts' => $contacts,
            'period' => 1
        ];

        $data = DomainRegisterData::fromArray($array);

        $this->assertEquals('example.com', $data->domain);
        $this->assertEquals($consent, $data->consent);
        $this->assertEquals($contacts, $data->contacts);
        $this->assertEquals(1, $data->period);
        $this->assertNull($data->privacy);
        $this->assertNull($data->renewAuto);
        $this->assertNull($data->nameServers);
    }
} 
