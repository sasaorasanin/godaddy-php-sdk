<?php

use GoDaddy\Services\Certificates\v1\DTO\AddressData;

test('AddressData returns correct array structure', function () {
    $data = new AddressData(
        '123 Main St',
        'Suite 100',
        'New York',
        'US',
        '10001',
        'NY'
    );

    $result = $data->toArray();
    
    expect($result)->toBe([
        'address1' => '123 Main St',
        'address2' => 'Suite 100',
        'city' => 'New York',
        'country' => 'US',
        'postalCode' => '10001',
        'state' => 'NY',
    ]);
});

test('AddressData handles empty address2', function () {
    $data = new AddressData(
        '123 Main St',
        '',
        'New York',
        'US',
        '10001',
        'NY'
    );

    $result = $data->toArray();
    
    expect($result)->toHaveKey('address2');
    expect($result['address2'])->toBe('');
}); 