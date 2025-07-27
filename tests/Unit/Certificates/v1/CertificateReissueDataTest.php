<?php

use GoDaddy\Services\Certificates\v1\DTO\CertificateReissueData;

test('CertificateReissueData returns correct array structure', function () {
    $data = new CertificateReissueData(
        'https://example.com/callback',
        'example.com',
        '-----BEGIN CERTIFICATE REQUEST-----\nMII...\n-----END CERTIFICATE REQUEST-----',
        0,
        'RSA',
        ['www.example.com', 'api.example.com'],
        ['example.com']
    );

    $result = $data->toArray();
    
    expect($result)->toBe([
        'callbackUrl' => 'https://example.com/callback',
        'commonName' => 'example.com',
        'csr' => '-----BEGIN CERTIFICATE REQUEST-----\nMII...\n-----END CERTIFICATE REQUEST-----',
        'delayExistingRevoke' => 0,
        'rootType' => 'RSA',
        'subjectAlternativeNames' => ['www.example.com', 'api.example.com'],
        'forceDomainRevetting' => ['example.com'],
    ]);
});

test('CertificateReissueData uses default arrays', function () {
    $data = new CertificateReissueData(
        'https://example.com/callback',
        'example.com',
        '-----BEGIN CERTIFICATE REQUEST-----\nMII...\n-----END CERTIFICATE REQUEST-----',
        0,
        'RSA'
    );

    $result = $data->toArray();
    
    expect($result)->toHaveKey('subjectAlternativeNames');
    expect($result)->toHaveKey('forceDomainRevetting');
    expect($result['subjectAlternativeNames'])->toBe([]);
    expect($result['forceDomainRevetting'])->toBe([]);
}); 
