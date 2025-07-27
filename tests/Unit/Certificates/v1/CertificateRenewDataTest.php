<?php

use GoDaddy\Services\Certificates\v1\DTO\CertificateRenewData;

test('CertificateRenewData returns correct array structure', function () {
    $data = new CertificateRenewData(
        'https://example.com/callback',
        'example.com',
        '-----BEGIN CERTIFICATE REQUEST-----\nMII...\n-----END CERTIFICATE REQUEST-----',
        12,
        'RSA',
        ['www.example.com', 'api.example.com']
    );

    $result = $data->toArray();
    
    expect($result)->toBe([
        'callbackUrl' => 'https://example.com/callback',
        'commonName' => 'example.com',
        'csr' => '-----BEGIN CERTIFICATE REQUEST-----\nMII...\n-----END CERTIFICATE REQUEST-----',
        'period' => 12,
        'rootType' => 'RSA',
        'subjectAlternativeNames' => ['www.example.com', 'api.example.com'],
    ]);
});

test('CertificateRenewData uses default subjectAlternativeNames', function () {
    $data = new CertificateRenewData(
        'https://example.com/callback',
        'example.com',
        '-----BEGIN CERTIFICATE REQUEST-----\nMII...\n-----END CERTIFICATE REQUEST-----',
        12,
        'RSA'
    );

    $result = $data->toArray();
    
    expect($result)->toHaveKey('subjectAlternativeNames');
    expect($result['subjectAlternativeNames'])->toBe([]);
}); 
