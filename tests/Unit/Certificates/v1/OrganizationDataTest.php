<?php

use GoDaddy\Services\Certificates\v1\DTO\OrganizationData;
use GoDaddy\Services\Certificates\v1\DTO\AddressData;

test('OrganizationData returns correct array structure', function () {
    $addressData = new AddressData(
        '123 Main St',
        'Suite 100',
        'New York',
        'US',
        '10001',
        'NY'
    );

    $data = new OrganizationData(
        $addressData,
        'Example Corp Assumed',
        'Example Corp',
        '123456789',
        'Registration Agent',
        'REG123456'
    );

    $result = $data->toArray();
    
    expect($result)->toHaveKey('address');
    expect($result)->toHaveKey('assumedName');
    expect($result)->toHaveKey('name');
    expect($result)->toHaveKey('phone');
    expect($result)->toHaveKey('registrationAgent');
    expect($result)->toHaveKey('registrationNumber');
    
    expect($result['assumedName'])->toBe('Example Corp Assumed');
    expect($result['name'])->toBe('Example Corp');
    expect($result['phone'])->toBe('123456789');
    expect($result['registrationAgent'])->toBe('Registration Agent');
    expect($result['registrationNumber'])->toBe('REG123456');
    expect($result['address'])->toBeArray();
}); 