<?php

use GoDaddy\Services\Domains\v1\DTO\UpdateDomainContactsData;
use GoDaddy\Services\Domains\v1\DTO\ContactData;
use GoDaddy\Services\Domains\v1\DTO\ContactAddressData;

test('UpdateDomainContactsData returns correct array structure', function () {
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

    $updateContactsData = new UpdateDomainContactsData(
        contactAdmin: $contactData,
        contactRegistrant: $contactData,
        contactTech: $contactData
    );

    $result = $updateContactsData->toArray();

    expect($result)->toBe([
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
        'contactTech' => [
            'addressMailing' => [
                'address1' => '123 Main St',
                'city' => 'New York',
                'country' => 'US',
                'postalCode' => '10001'
            ],
            'email' => 'john@example.com',
            'nameFirst' => 'John',
            'nameLast' => 'Doe'
        ]
    ]);
});

test('UpdateDomainContactsData filters null values', function () {
    $updateContactsData = new UpdateDomainContactsData(
        contactAdmin: null,
        contactRegistrant: null
    );

    $result = $updateContactsData->toArray();

    expect($result)->toBe([]);
}); 
