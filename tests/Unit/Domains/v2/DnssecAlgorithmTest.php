<?php

namespace Tests\Unit\Domains\v2;

use GoDaddy\Services\Domains\v2\Enums\DnssecAlgorithm;
use PHPUnit\Framework\TestCase;

class DnssecAlgorithmTest extends TestCase
{
    public function testRsaSha1()
    {
        $this->assertEquals('1', DnssecAlgorithm::RSA_SHA1->value);
    }

    public function testRsaSha256()
    {
        $this->assertEquals('8', DnssecAlgorithm::RSA_SHA256->value);
    }

    public function testRsaSha512()
    {
        $this->assertEquals('10', DnssecAlgorithm::RSA_SHA512->value);
    }

    public function testEcdsaP256Sha256()
    {
        $this->assertEquals('13', DnssecAlgorithm::ECDSA_P256_SHA256->value);
    }

    public function testEcdsaP384Sha384()
    {
        $this->assertEquals('14', DnssecAlgorithm::ECDSA_P384_SHA384->value);
    }

    public function testEd25519()
    {
        $this->assertEquals('15', DnssecAlgorithm::ED25519->value);
    }

    public function testEd448()
    {
        $this->assertEquals('16', DnssecAlgorithm::ED448->value);
    }
} 
