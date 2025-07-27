<?php

use GoDaddy\Services\Domains\v1\DTO\ValidateContactsData;
use GoDaddy\Services\Domains\v1\DTO\ContactData;
use GoDaddy\Services\Domains\v1\DTO\ContactAddressData;

test('ValidateContactsData returns correct array structure', function () {
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
        nameLast: 'Doe',
        fax: null,
        jobTitle: null,
        nameMiddle: null,
        organization: null,
        phone: null
    );

    $validateData = new ValidateContactsData(
        contactAdmin: $contactData,
        contactRegistrant: $contactData,
        domains: ['example.com', 'test.com'],
        entityType: 'INDIVIDUAL'
    );

    $result = $validateData->toArray();

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
        'domains' => ['example.com', 'test.com'],
        'entityType' => 'INDIVIDUAL'
    ]);
});

test('ValidateContactsData filters null values', function () {
    $validateData = new ValidateContactsData(
        domains: ['example.com']
    );

    $result = $validateData->toArray();

    expect($result)->toBe([
        'domains' => ['example.com']
    ]);
}); 
