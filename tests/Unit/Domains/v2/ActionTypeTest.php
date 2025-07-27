<?php

namespace Tests\Unit\Domains\v2;

use GoDaddy\Services\Domains\v2\Enums\ActionType;
use PHPUnit\Framework\TestCase;

class ActionTypeTest extends TestCase
{
    public function testDnssecCreate()
    {
        $this->assertEquals('DNSSEC_CREATE', ActionType::DNSSEC_CREATE->value);
    }

    public function testDnssecDelete()
    {
        $this->assertEquals('DNSSEC_DELETE', ActionType::DNSSEC_DELETE->value);
    }

    public function testDomainUpdateNameServers()
    {
        $this->assertEquals('DOMAIN_UPDATE_NAME_SERVERS', ActionType::DOMAIN_UPDATE_NAME_SERVERS->value);
    }

    public function testChangeOfRegistrantDelete()
    {
        $this->assertEquals('CHANGE_OF_REGISTRANT_DELETE', ActionType::CHANGE_OF_REGISTRANT_DELETE->value);
    }

    public function testDomainRenew()
    {
        $this->assertEquals('DOMAIN_RENEW', ActionType::DOMAIN_RENEW->value);
    }

    public function testDomainTransferIn()
    {
        $this->assertEquals('DOMAIN_TRANSFER_IN', ActionType::DOMAIN_TRANSFER_IN->value);
    }

    public function testDomainTransferOut()
    {
        $this->assertEquals('DOMAIN_TRANSFER_OUT', ActionType::DOMAIN_TRANSFER_OUT->value);
    }

    public function testDomainRedeem()
    {
        $this->assertEquals('DOMAIN_REDEEM', ActionType::DOMAIN_REDEEM->value);
    }
} 
