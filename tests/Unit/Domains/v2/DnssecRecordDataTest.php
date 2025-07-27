<?php

namespace Tests\Unit\Domains\v2;

use GoDaddy\Services\Domains\v2\DTO\DnssecRecordData;
use PHPUnit\Framework\TestCase;

class DnssecRecordDataTest extends TestCase
{
    public function testConstructorAndGetters()
    {
        $data = new DnssecRecordData(
            algorithm: '8',
            digest: 'test-digest',
            digestType: '1',
            keyTag: '12345'
        );

        $this->assertEquals('8', $data->algorithm);
        $this->assertEquals('test-digest', $data->digest);
        $this->assertEquals('1', $data->digestType);
        $this->assertEquals('12345', $data->keyTag);
    }

    public function testToArray()
    {
        $data = new DnssecRecordData(
            algorithm: '8',
            digest: 'test-digest',
            digestType: '1',
            keyTag: '12345'
        );

        $array = $data->toArray();

        $this->assertEquals([
            'algorithm' => '8',
            'digest' => 'test-digest',
            'digestType' => '1',
            'keyTag' => '12345'
        ], $array);
    }

    public function testFromArray()
    {
        $array = [
            'algorithm' => '8',
            'digest' => 'test-digest',
            'digestType' => '1',
            'keyTag' => '12345'
        ];

        $data = DnssecRecordData::fromArray($array);

        $this->assertEquals('8', $data->algorithm);
        $this->assertEquals('test-digest', $data->digest);
        $this->assertEquals('1', $data->digestType);
        $this->assertEquals('12345', $data->keyTag);
    }
} 
