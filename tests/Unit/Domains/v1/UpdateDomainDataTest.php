<?php

use GoDaddy\Services\Domains\v1\DTO\UpdateDomainData;
use GoDaddy\Services\Domains\v1\DTO\ConsentData;

test('UpdateDomainData returns correct array structure', function () {
    $consentData = new ConsentData(
        agreedAt: '2024-01-01T00:00:00Z',
        agreedBy: '192.168.1.1',
        agreementKeys: ['EXPOSE_REGISTRANT_ORGANIZATION']
    );

    $updateData = new UpdateDomainData(
        locked: true,
        nameServers: ['ns1.example.com', 'ns2.example.com'],
        renewAuto: true,
        subaccountId: 'test-subaccount',
        exposeRegistrantOrganization: true,
        exposeWhois: true,
        consent: $consentData
    );

    $result = $updateData->toArray();

    expect($result)->toBe([
        'locked' => true,
        'nameServers' => ['ns1.example.com', 'ns2.example.com'],
        'renewAuto' => true,
        'subaccountId' => 'test-subaccount',
        'exposeRegistrantOrganization' => true,
        'exposeWhois' => true,
        'consent' => [
            'agreedAt' => '2024-01-01T00:00:00Z',
            'agreedBy' => '192.168.1.1',
            'agreementKeys' => ['EXPOSE_REGISTRANT_ORGANIZATION']
        ]
    ]);
});

test('UpdateDomainData filters null values', function () {
    $updateData = new UpdateDomainData(
        locked: true,
        nameServers: ['ns1.example.com', 'ns2.example.com']
    );

    $result = $updateData->toArray();

    expect($result)->toBe([
        'locked' => true,
        'nameServers' => ['ns1.example.com', 'ns2.example.com']
    ]);
}); 
