<?php

use GoDaddy\Services\Domains\v1\DTO\TransferDomainData;
use GoDaddy\Services\Domains\v1\DTO\ConsentData;
use GoDaddy\Services\Domains\v1\DTO\ContactData;
use GoDaddy\Services\Domains\v1\DTO\ContactAddressData;

test('TransferDomainData returns correct array structure', function () {
    $consentData = new ConsentData(
        agreedAt: '2023-01-01T00:00:00Z',
        agreedBy: 'test@example.com',
        agreementKeys: ['TRANSFER_AGREEMENT']
    );
    
    $contactAddressData = new ContactAddressData(
        address1: '123 Main St',
        city: 'New York',
        country: 'US',
        postalCode: '10001'
    );
    
    $contactData = new ContactData(
        addressMailing: $contactAddressData,
        email: 'admin@example.com',
        nameFirst: 'John',
        nameLast: 'Doe'
    );
    
    $transferData = new TransferDomainData(
        authCode: 'ABC123',
        consent: $consentData,
        contactAdmin: $contactData,
        period: 2,
        privacy: true,
        renewAuto: false
    );
    
    $result = $transferData->toArray();
    
    expect($result)->toMatchArray([
        'authCode' => 'ABC123',
        'consent' => [
            'agreedAt' => '2023-01-01T00:00:00Z',
            'agreedBy' => 'test@example.com',
            'agreementKeys' => ['TRANSFER_AGREEMENT']
        ],
        'contactAdmin' => [
            'addressMailing' => [
                'address1' => '123 Main St',
                'city' => 'New York',
                'country' => 'US',
                'postalCode' => '10001'
            ],
            'email' => 'admin@example.com',
            'nameFirst' => 'John',
            'nameLast' => 'Doe'
        ],
        'period' => 2,
        'privacy' => true,
        'renewAuto' => false
    ]);
});

test('TransferDomainData uses default values', function () {
    $transferData = new TransferDomainData(
        authCode: 'ABC123'
    );
    
    $result = $transferData->toArray();
    
    expect($result)->toMatchArray([
        'authCode' => 'ABC123',
        'period' => 1,
        'privacy' => false,
        'renewAuto' => true
    ]);
}); 
