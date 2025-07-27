<?php

use GoDaddy\Services\Domains\v1\DTO\ContactAddressData;

test('ContactAddressData returns correct array structure', function () {
    $addressData = new ContactAddressData(
        address1: '123 Main St',
        city: 'New York',
        country: 'US',
        postalCode: '10001',
        address2: 'Apt 4B',
        state: 'NY'
    );

    $result = $addressData->toArray();

    expect($result)->toBe([
        'address1' => '123 Main St',
        'city' => 'New York',
        'country' => 'US',
        'postalCode' => '10001',
        'address2' => 'Apt 4B',
        'state' => 'NY'
    ]);
});

test('ContactAddressData filters null values', function () {
    $addressData = new ContactAddressData(
        address1: '123 Main St',
        city: 'New York',
        country: 'US',
        postalCode: '10001',
        address2: null
    );

    $result = $addressData->toArray();

    expect($result)->toBe([
        'address1' => '123 Main St',
        'city' => 'New York',
        'country' => 'US',
        'postalCode' => '10001'
    ]);
}); 
