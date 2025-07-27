<?php

use GoDaddy\Services\Domains\v2\DTO\DomainDetailsV2Data;

test('DomainDetailsV2Data fromArray creates correct object', function () {
    $data = [
        'domainId' => '12345',
        'domain' => 'example.com',
        'status' => 'ACTIVE',
        'expiresAt' => '2025-12-31T23:59:59Z',
        'privacy' => true,
        'renewAuto' => false,
        'nameServers' => ['ns1.example.com', 'ns2.example.com'],
        'renewal' => [
            'renewable' => true,
            'price' => 999,
            'currency' => 'USD'
        ],
        'verifications' => [
            'icann' => 'COMPLETED',
            'realName' => 'APPROVED',
            'domainName' => 'APPROVED'
        ]
    ];
    
    $domainDetails = DomainDetailsV2Data::fromArray($data);
    
    expect($domainDetails->domainId)->toBe('12345');
    expect($domainDetails->domain)->toBe('example.com');
    expect($domainDetails->status)->toBe('ACTIVE');
    expect($domainDetails->expiresAt)->toBe('2025-12-31T23:59:59Z');
    expect($domainDetails->privacy)->toBeTrue();
    expect($domainDetails->renewAuto)->toBeFalse();
    expect($domainDetails->nameServers)->toMatchArray(['ns1.example.com', 'ns2.example.com']);
    expect($domainDetails->renewal)->toMatchArray([
        'renewable' => true,
        'price' => 999,
        'currency' => 'USD'
    ]);
    expect($domainDetails->verifications)->toMatchArray([
        'icann' => 'COMPLETED',
        'realName' => 'APPROVED',
        'domainName' => 'APPROVED'
    ]);
});

test('DomainDetailsV2Data toArray returns correct structure', function () {
    $domainDetails = new DomainDetailsV2Data(
        domainId: '12345',
        domain: 'example.com',
        status: 'ACTIVE',
        privacy: true,
        renewAuto: false
    );
    
    $result = $domainDetails->toArray();
    
    expect($result)->toMatchArray([
        'domainId' => '12345',
        'domain' => 'example.com',
        'status' => 'ACTIVE',
        'privacy' => true,
        'renewAuto' => false
    ]);
}); 
