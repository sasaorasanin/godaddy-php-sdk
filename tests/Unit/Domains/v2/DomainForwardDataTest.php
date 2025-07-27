<?php

namespace Tests\Unit\Domains\v2;

use GoDaddy\Services\Domains\v2\DTO\DomainForwardData;
use PHPUnit\Framework\TestCase;

class DomainForwardDataTest extends TestCase
{
    public function testConstructorAndGetters()
    {
        $data = new DomainForwardData(
            forwardTo: 'https://example.com',
            mask: true,
            title: 'Test Title',
            description: 'Test Description',
            keywords: 'test, keywords'
        );

        $this->assertEquals('https://example.com', $data->forwardTo);
        $this->assertTrue($data->mask);
        $this->assertEquals('Test Title', $data->title);
        $this->assertEquals('Test Description', $data->description);
        $this->assertEquals('test, keywords', $data->keywords);
    }

    public function testConstructorWithMinimalData()
    {
        $data = new DomainForwardData(
            forwardTo: 'https://example.com',
            mask: false
        );

        $this->assertEquals('https://example.com', $data->forwardTo);
        $this->assertFalse($data->mask);
        $this->assertNull($data->title);
        $this->assertNull($data->description);
        $this->assertNull($data->keywords);
    }

    public function testToArray()
    {
        $data = new DomainForwardData(
            forwardTo: 'https://example.com',
            mask: true,
            title: 'Test Title',
            description: 'Test Description',
            keywords: 'test, keywords'
        );

        $array = $data->toArray();

        $this->assertEquals([
            'forwardTo' => 'https://example.com',
            'mask' => true,
            'title' => 'Test Title',
            'description' => 'Test Description',
            'keywords' => 'test, keywords'
        ], $array);
    }

    public function testToArrayWithMinimalData()
    {
        $data = new DomainForwardData(
            forwardTo: 'https://example.com',
            mask: false
        );

        $array = $data->toArray();

        $this->assertEquals([
            'forwardTo' => 'https://example.com',
            'mask' => false
        ], $array);
    }

    public function testFromArray()
    {
        $array = [
            'forwardTo' => 'https://example.com',
            'mask' => true,
            'title' => 'Test Title',
            'description' => 'Test Description',
            'keywords' => 'test, keywords'
        ];

        $data = DomainForwardData::fromArray($array);

        $this->assertEquals('https://example.com', $data->forwardTo);
        $this->assertTrue($data->mask);
        $this->assertEquals('Test Title', $data->title);
        $this->assertEquals('Test Description', $data->description);
        $this->assertEquals('test, keywords', $data->keywords);
    }

    public function testFromArrayWithMinimalData()
    {
        $array = [
            'forwardTo' => 'https://example.com',
            'mask' => false
        ];

        $data = DomainForwardData::fromArray($array);

        $this->assertEquals('https://example.com', $data->forwardTo);
        $this->assertFalse($data->mask);
        $this->assertNull($data->title);
        $this->assertNull($data->description);
        $this->assertNull($data->keywords);
    }
} 
