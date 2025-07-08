<?php

use GoDaddy\Services\Certificates\v1\DTO\CertificateRevokeData;

test('CertificateRevokeData returns correct array structure', function () {
    $data = new CertificateRevokeData('Compromised');

    $result = $data->toArray();
    
    expect($result)->toBe([
        'reason' => 'Compromised',
    ]);
});

test('CertificateRevokeData handles different reasons', function () {
    $data = new CertificateRevokeData('Key Compromise');

    $result = $data->toArray();
    
    expect($result)->toBe([
        'reason' => 'Key Compromise',
    ]);
}); 