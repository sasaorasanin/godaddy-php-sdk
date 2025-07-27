<?php

use GoDaddy\Services\Domains\v1\DTO\DomainDetailsData;
use GoDaddy\Services\Domains\v1\DTO\ContactData;
use GoDaddy\Services\Domains\v1\DTO\ContactAddressData;

test('DomainDetailsData fromArray creates correct object', function () {
    $data = [
        'domain' => 'example.com',
        'domainId' => 12345,
        'expirationProtected' => true,
        'exposeRegistrantOrganization' => false,
        'exposeWhois' => true,
        'holdRegistrar' => false,
        'locked' => true,
        'privacy' => true,
        'renewAuto' => true,
        'status' => 'ACTIVE',
        'transferProtected' => false,
        'createdAt' => '2024-01-01T00:00:00Z',
        'expires' => '2025-01-01T00:00:00Z',
        'nameServers' => ['ns1.example.com', 'ns2.example.com'],
        'verifications' => [
            'domainName' => ['status' => 'APPROVED'],
            'realName' => ['status' => 'APPROVED']
        ]
    ];

    $domainDetails = DomainDetailsData::fromArray($data);

    expect($domainDetails->domain)->toBe('example.com');
    expect($domainDetails->domainId)->toBe(12345);
    expect($domainDetails->expirationProtected)->toBeTrue();
    expect($domainDetails->exposeRegistrantOrganization)->toBeFalse();
    expect($domainDetails->exposeWhois)->toBeTrue();
    expect($domainDetails->holdRegistrar)->toBeFalse();
    expect($domainDetails->locked)->toBeTrue();
    expect($domainDetails->privacy)->toBeTrue();
    expect($domainDetails->renewAuto)->toBeTrue();
    expect($domainDetails->status)->toBe('ACTIVE');
    expect($domainDetails->transferProtected)->toBeFalse();
    expect($domainDetails->createdAt)->toBe('2024-01-01T00:00:00Z');
    expect($domainDetails->expires)->toBe('2025-01-01T00:00:00Z');
    expect($domainDetails->nameServers)->toBe(['ns1.example.com', 'ns2.example.com']);
    expect($domainDetails->verifications)->toBe([
        'domainName' => ['status' => 'APPROVED'],
        'realName' => ['status' => 'APPROVED']
    ]);
});

test('DomainDetailsData toArray returns correct structure', function () {
    $domainDetails = new DomainDetailsData(
        domain: 'example.com',
        domainId: 12345,
        expirationProtected: true,
        exposeRegistrantOrganization: false,
        exposeWhois: true,
        holdRegistrar: false,
        locked: true,
        privacy: true,
        renewAuto: true,
        status: 'ACTIVE',
        transferProtected: false,
        createdAt: '2024-01-01T00:00:00Z',
        expires: '2025-01-01T00:00:00Z',
        nameServers: ['ns1.example.com', 'ns2.example.com']
    );

    $result = $domainDetails->toArray();

    expect($result)->toBe([
        'domain' => 'example.com',
        'domainId' => 12345,
        'expirationProtected' => true,
        'exposeRegistrantOrganization' => false,
        'exposeWhois' => true,
        'holdRegistrar' => false,
        'locked' => true,
        'privacy' => true,
        'renewAuto' => true,
        'status' => 'ACTIVE',
        'transferProtected' => false,
        'createdAt' => '2024-01-01T00:00:00Z',
        'expires' => '2025-01-01T00:00:00Z',
        'nameServers' => ['ns1.example.com', 'ns2.example.com']
    ]);
}); 
