<?php

use GoDaddy\Services\Domains\v1\DTO\ContactData;
use GoDaddy\Services\Domains\v1\DTO\ContactAddressData;

test('ContactData returns correct array structure', function () {
    $addressData = new ContactAddressData(
        address1: '123 Main St',
        city: 'New York',
        country: 'US',
        postalCode: '10001',
        state: 'NY'
    );

    $contactData = new ContactData(
        addressMailing: $addressData,
        email: 'john@example.com',
        fax: '+1-555-123-4567',
        jobTitle: 'Developer',
        nameFirst: 'John',
        nameLast: 'Doe',
        nameMiddle: 'M',
        organization: 'Example Corp',
        phone: '+1-555-987-6543'
    );

    $result = $contactData->toArray();

    expect($result)->toBe([
        'addressMailing' => [
            'address1' => '123 Main St',
            'city' => 'New York',
            'country' => 'US',
            'postalCode' => '10001',
            'state' => 'NY'
        ],
        'email' => 'john@example.com',
        'fax' => '+1-555-123-4567',
        'jobTitle' => 'Developer',
        'nameFirst' => 'John',
        'nameLast' => 'Doe',
        'nameMiddle' => 'M',
        'organization' => 'Example Corp',
        'phone' => '+1-555-987-6543'
    ]);
});

test('ContactData filters null values', function () {
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

    $result = $contactData->toArray();

    expect($result)->toBe([
        'addressMailing' => [
            'address1' => '123 Main St',
            'city' => 'New York',
            'country' => 'US',
            'postalCode' => '10001'
        ],
        'email' => 'john@example.com',
        'nameFirst' => 'John',
        'nameLast' => 'Doe'
    ]);
}); 