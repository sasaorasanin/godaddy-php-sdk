<?php

use GoDaddy\Services\Certificates\v1\DTO\CertificateCreateData;
use GoDaddy\Services\Certificates\v1\DTO\ContactData;
use GoDaddy\Services\Certificates\v1\DTO\OrganizationData;
use GoDaddy\Services\Certificates\v1\DTO\AddressData;

test('CertificateCreateData returns correct array structure', function () {
    $contactData = new ContactData(
        'john@example.com',
        'Developer',
        'John',
        'Doe',
        'M',
        '123456789',
        'Jr'
    );

    $addressData = new AddressData(
        '123 Main St',
        'Suite 100',
        'New York',
        'US',
        '10001',
        'NY'
    );

    $orgData = new OrganizationData(
        $addressData,
        'Example Corp Assumed',
        'Example Corp',
        '123456789',
        'Registration Agent',
        'REG123456'
    );

    $data = new CertificateCreateData(
        'https://example.com/callback',
        'example.com',
        $contactData,
        '-----BEGIN CERTIFICATE REQUEST-----\nMII...\n-----END CERTIFICATE REQUEST-----',
        false,
        $orgData,
        12,
        'DV',
        'RSA',
        '2048',
        ['www.example.com', 'api.example.com']
    );

    $result = $data->toArray();
    
    expect($result)->toHaveKey('callbackUrl');
    expect($result)->toHaveKey('commonName');
    expect($result)->toHaveKey('contact');
    expect($result)->toHaveKey('csr');
    expect($result)->toHaveKey('intelVPro');
    expect($result)->toHaveKey('organization');
    expect($result)->toHaveKey('period');
    expect($result)->toHaveKey('productType');
    expect($result)->toHaveKey('rootType');
    expect($result)->toHaveKey('slotSize');
    expect($result)->toHaveKey('subjectAlternativeNames');
    
    expect($result['callbackUrl'])->toBe('https://example.com/callback');
    expect($result['commonName'])->toBe('example.com');
    expect($result['period'])->toBe(12);
    expect($result['productType'])->toBe('DV');
    expect($result['rootType'])->toBe('RSA');
    expect($result['slotSize'])->toBe('2048');
    expect($result['intelVPro'])->toBe(false);
    expect($result['contact'])->toBeArray();
    expect($result['organization'])->toBeArray();
    expect($result['subjectAlternativeNames'])->toBe(['www.example.com', 'api.example.com']);
}); 
