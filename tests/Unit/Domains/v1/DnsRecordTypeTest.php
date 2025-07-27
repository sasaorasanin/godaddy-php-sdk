<?php

namespace Tests\Unit\Domains\v1;

use GoDaddy\Services\Domains\v1\Enums\DnsRecordType;
use PHPUnit\Framework\TestCase;

class DnsRecordTypeTest extends TestCase
{
    public function testA()
    {
        $this->assertEquals('A', DnsRecordType::A->value);
    }

    public function testAaaa()
    {
        $this->assertEquals('AAAA', DnsRecordType::AAAA->value);
    }

    public function testCname()
    {
        $this->assertEquals('CNAME', DnsRecordType::CNAME->value);
    }

    public function testMx()
    {
        $this->assertEquals('MX', DnsRecordType::MX->value);
    }

    public function testNs()
    {
        $this->assertEquals('NS', DnsRecordType::NS->value);
    }

    public function testSoa()
    {
        $this->assertEquals('SOA', DnsRecordType::SOA->value);
    }

    public function testSrv()
    {
        $this->assertEquals('SRV', DnsRecordType::SRV->value);
    }

    public function testTxt()
    {
        $this->assertEquals('TXT', DnsRecordType::TXT->value);
    }
} 
