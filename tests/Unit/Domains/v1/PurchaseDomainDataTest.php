<?php

use GoDaddy\Services\Domains\v1\DTO\PurchaseDomainData;
use GoDaddy\Services\Domains\v1\DTO\ConsentData;
use GoDaddy\Services\Domains\v1\DTO\ContactData;
use GoDaddy\Services\Domains\v1\DTO\ContactAddressData;

test('PurchaseDomainData returns correct array structure', function () {
    $addressData = new ContactAddressData(
        address1: '123 Main St',
        city: 'New York',
        country: 'US',
        postalCode: '10001'
    );

    $contactData = new ContactData(
        addressMailing: $addressData,
        email: 'john@example.com',
        nameFirst: 'John',
        nameLast: 'Doe'
    );

    $consentData = new ConsentData(
        agreedAt: '2024-01-01T00:00:00Z',
        agreedBy: '192.168.1.1',
        agreementKeys: ['DNRA', 'ICANN']
    );

    $purchaseData = new PurchaseDomainData(
        consent: $consentData,
        contactAdmin: $contactData,
        contactRegistrant: $contactData,
        domain: 'example.com',
        nameServers: ['ns1.example.com', 'ns2.example.com'],
        period: 2,
        privacy: true,
        renewAuto: false
    );

    $result = $purchaseData->toArray();

    expect($result)->toBe([
        'consent' => [
            'agreedAt' => '2024-01-01T00:00:00Z',
            'agreedBy' => '192.168.1.1',
            'agreementKeys' => ['DNRA', 'ICANN']
        ],
        'contactAdmin' => [
            'addressMailing' => [
                'address1' => '123 Main St',
                'city' => 'New York',
                'country' => 'US',
                'postalCode' => '10001'
            ],
            'email' => 'john@example.com',
            'nameFirst' => 'John',
            'nameLast' => 'Doe'
        ],
        'contactRegistrant' => [
            'addressMailing' => [
                'address1' => '123 Main St',
                'city' => 'New York',
                'country' => 'US',
                'postalCode' => '10001'
            ],
            'email' => 'john@example.com',
            'nameFirst' => 'John',
            'nameLast' => 'Doe'
        ],
        'domain' => 'example.com',
        'nameServers' => ['ns1.example.com', 'ns2.example.com'],
        'period' => 2,
        'privacy' => true,
        'renewAuto' => false
    ]);
});

test('PurchaseDomainData uses default values', function () {
    $purchaseData = new PurchaseDomainData(
        domain: 'example.com'
    );

    $result = $purchaseData->toArray();

    expect($result)->toBe([
        'domain' => 'example.com',
        'period' => 1,
        'privacy' => false,
        'renewAuto' => true
    ]);
}); 