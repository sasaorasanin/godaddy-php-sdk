<?php

namespace Tests\Unit\Domains\v2;

use GoDaddy\Services\Domains\v2\Enums\NotificationType;
use PHPUnit\Framework\TestCase;

class NotificationTypeTest extends TestCase
{
    public function testDomainExpiry()
    {
        $this->assertEquals('DOMAIN_EXPIRY', NotificationType::DOMAIN_EXPIRY->value);
    }

    public function testDomainTransfer()
    {
        $this->assertEquals('DOMAIN_TRANSFER', NotificationType::DOMAIN_TRANSFER->value);
    }

    public function testDomainRenewal()
    {
        $this->assertEquals('DOMAIN_RENEWAL', NotificationType::DOMAIN_RENEWAL->value);
    }

    public function testDomainRegistration()
    {
        $this->assertEquals('DOMAIN_REGISTRATION', NotificationType::DOMAIN_REGISTRATION->value);
    }
} 
