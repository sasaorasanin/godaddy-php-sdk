<?php

namespace Tests\Unit\Domains\v1;

use GoDaddy\Services\Domains\v1\Enums\DomainSuggestionSource;
use PHPUnit\Framework\TestCase;

class DomainSuggestionSourceTest extends TestCase
{
    public function testCcTld()
    {
        $this->assertEquals('CC_TLD', DomainSuggestionSource::CC_TLD->value);
    }

    public function testExtension()
    {
        $this->assertEquals('EXTENSION', DomainSuggestionSource::EXTENSION->value);
    }

    public function testKeywordSpin()
    {
        $this->assertEquals('KEYWORD_SPIN', DomainSuggestionSource::KEYWORD_SPIN->value);
    }

    public function testPremium()
    {
        $this->assertEquals('PREMIUM', DomainSuggestionSource::PREMIUM->value);
    }

    public function testCctldLowercase()
    {
        $this->assertEquals('cctld', DomainSuggestionSource::CCTLD->value);
    }

    public function testExtensionLowercase()
    {
        $this->assertEquals('extension', DomainSuggestionSource::EXTENSION_LOWERCASE->value);
    }

    public function testKeywordSpinLowercase()
    {
        $this->assertEquals('keywordspin', DomainSuggestionSource::KEYWORD_SPIN_LOWERCASE->value);
    }

    public function testPremiumLowercase()
    {
        $this->assertEquals('premium', DomainSuggestionSource::PREMIUM_LOWERCASE->value);
    }
} 
