<?php

use GoDaddy\Services\Domains\v1\DTO\ContactAddressData;

test('ContactAddressData returns correct array structure', function () {
    $addressData = new ContactAddressData(
        address1: '123 Main St',
        address2: 'Apt 4B',
        city: 'New York',
        country: 'US',
        postalCode: '10001',
        state: 'NY'
    );

    $result = $addressData->toArray();

    expect($result)->toBe([
        'address1' => '123 Main St',
        'address2' => 'Apt 4B',
        'city' => 'New York',
        'country' => 'US',
        'postalCode' => '10001',
        'state' => 'NY'
    ]);
});

test('ContactAddressData filters null values', function () {
    $addressData = new ContactAddressData(
        address1: '123 Main St',
        city: 'New York',
        country: 'US',
        postalCode: '10001'
    );

    $result = $addressData->toArray();

    expect($result)->toBe([
        'address1' => '123 Main St',
        'city' => 'New York',
        'country' => 'US',
        'postalCode' => '10001'
    ]);
}); 