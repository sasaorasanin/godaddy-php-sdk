<?php

namespace Tests\Unit\Domains\v2;

use GoDaddy\Services\Domains\v2\DTO\NotificationOptInData;
use PHPUnit\Framework\TestCase;

class NotificationOptInDataTest extends TestCase
{
    public function testConstructorAndGetters()
    {
        $channels = ['email', 'sms'];
        $data = new NotificationOptInData('DOMAIN_EXPIRY', $channels);

        $this->assertEquals('DOMAIN_EXPIRY', $data->type);
        $this->assertEquals($channels, $data->channels);
    }

    public function testToArray()
    {
        $channels = ['email', 'sms'];
        $data = new NotificationOptInData('DOMAIN_EXPIRY', $channels);

        $array = $data->toArray();

        $this->assertEquals([
            'type' => 'DOMAIN_EXPIRY',
            'channels' => $channels
        ], $array);
    }

    public function testFromArray()
    {
        $channels = ['email', 'sms'];
        $array = [
            'type' => 'DOMAIN_EXPIRY',
            'channels' => $channels
        ];

        $data = NotificationOptInData::fromArray($array);

        $this->assertEquals('DOMAIN_EXPIRY', $data->type);
        $this->assertEquals($channels, $data->channels);
    }
} 
