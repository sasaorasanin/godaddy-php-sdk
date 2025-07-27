<?php

use GoDaddy\Services\Certificates\v2\CertificatesService;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Client;

test('CertificatesService can search certificates by entitlement', function () {
    $mock = new MockHandler([
        new Response(200, [], json_encode([
            ['certificateId' => 'cert123', 'entitlementId' => 'ent123'],
            ['certificateId' => 'cert456', 'entitlementId' => 'ent123'],
        ])),
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack, 'base_uri' => 'https://api.example.com']);

    $service = new class('key', 'secret', 'https://api.example.com') extends CertificatesService {
        public function setClient(Client $client): void { $this->client = $client; }
    };
    $service->setClient($client);

    $result = $service->searchByEntitlement('ent123', true);
    expect($result)->toBe([
        ['certificateId' => 'cert123', 'entitlementId' => 'ent123'],
        ['certificateId' => 'cert456', 'entitlementId' => 'ent123'],
    ]);
});

test('CertificatesService can download certificate by entitlement', function () {
    $mock = new MockHandler([
        new Response(200, [], '-----BEGIN CERTIFICATE-----\nMII...\n-----END CERTIFICATE-----'),
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack, 'base_uri' => 'https://api.example.com']);

    $service = new class('key', 'secret', 'https://api.example.com') extends CertificatesService {
        public function setClient(Client $client): void { $this->client = $client; }
    };
    $service->setClient($client);

    $result = $service->downloadByEntitlement('ent123');
    expect($result)->toBe('-----BEGIN CERTIFICATE-----\nMII...\n-----END CERTIFICATE-----');
});

test('CertificatesService can get customer certificates', function () {
    $mock = new MockHandler([
        new Response(200, [], json_encode([
            ['certificateId' => 'cert123', 'customerId' => 'cust123'],
            ['certificateId' => 'cert456', 'customerId' => 'cust123'],
        ])),
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack, 'base_uri' => 'https://api.example.com']);

    $service = new class('key', 'secret', 'https://api.example.com') extends CertificatesService {
        public function setClient(Client $client): void { $this->client = $client; }
    };
    $service->setClient($client);

    $result = $service->getCustomerCertificates('cust123', 0, 50);
    expect($result)->toBe([
        ['certificateId' => 'cert123', 'customerId' => 'cust123'],
        ['certificateId' => 'cert456', 'customerId' => 'cust123'],
    ]);
});

test('CertificatesService can get customer certificate details', function () {
    $mock = new MockHandler([
        new Response(200, [], json_encode(['certificateId' => 'cert123', 'customerId' => 'cust123', 'status' => 'active'])),
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack, 'base_uri' => 'https://api.example.com']);

    $service = new class('key', 'secret', 'https://api.example.com') extends CertificatesService {
        public function setClient(Client $client): void { $this->client = $client; }
    };
    $service->setClient($client);

    $result = $service->getCustomerCertificateDetails('cust123', 'cert123');
    expect($result)->toBe(['certificateId' => 'cert123', 'customerId' => 'cust123', 'status' => 'active']);
});

test('CertificatesService can get domain verifications', function () {
    $mock = new MockHandler([
        new Response(200, [], json_encode([
            ['domain' => 'example.com', 'status' => 'verified'],
            ['domain' => 'test.com', 'status' => 'pending'],
        ])),
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack, 'base_uri' => 'https://api.example.com']);

    $service = new class('key', 'secret', 'https://api.example.com') extends CertificatesService {
        public function setClient(Client $client): void { $this->client = $client; }
    };
    $service->setClient($client);

    $result = $service->getDomainVerifications('cust123', 'cert123');
    expect($result)->toBe([
        ['domain' => 'example.com', 'status' => 'verified'],
        ['domain' => 'test.com', 'status' => 'pending'],
    ]);
});

test('CertificatesService can get domain verification details', function () {
    $mock = new MockHandler([
        new Response(200, [], json_encode(['domain' => 'example.com', 'status' => 'verified', 'verificationMethod' => 'dns'])),
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack, 'base_uri' => 'https://api.example.com']);

    $service = new class('key', 'secret', 'https://api.example.com') extends CertificatesService {
        public function setClient(Client $client): void { $this->client = $client; }
    };
    $service->setClient($client);

    $result = $service->getDomainVerificationDetails('cust123', 'cert123', 'example.com');
    expect($result)->toBe(['domain' => 'example.com', 'status' => 'verified', 'verificationMethod' => 'dns']);
});

test('CertificatesService can get ACME external account binding', function () {
    $mock = new MockHandler([
        new Response(200, [], json_encode(['kid' => 'key123', 'hmac' => 'hmac456'])),
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack, 'base_uri' => 'https://api.example.com']);

    $service = new class('key', 'secret', 'https://api.example.com') extends CertificatesService {
        public function setClient(Client $client): void { $this->client = $client; }
    };
    $service->setClient($client);

    $result = $service->getAcmeExternalAccountBinding('cust123');
    expect($result)->toBe(['kid' => 'key123', 'hmac' => 'hmac456']);
}); 
