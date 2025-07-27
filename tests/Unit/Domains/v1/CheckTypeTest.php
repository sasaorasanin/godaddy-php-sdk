<?php

namespace Tests\Unit\Domains\v1;

use GoDaddy\Services\Domains\v1\Enums\CheckType;
use PHPUnit\Framework\TestCase;

class CheckTypeTest extends TestCase
{
    public function testFast()
    {
        $this->assertEquals('FAST', CheckType::FAST->value);
    }

    public function testFull()
    {
        $this->assertEquals('FULL', CheckType::FULL->value);
    }

    public function testFastLowercase()
    {
        $this->assertEquals('fast', CheckType::FAST_LOWERCASE->value);
    }

    public function testFullLowercase()
    {
        $this->assertEquals('full', CheckType::FULL_LOWERCASE->value);
    }
} 
