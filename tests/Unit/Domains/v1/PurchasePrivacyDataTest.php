<?php

use GoDaddy\Services\Domains\v1\DTO\PurchasePrivacyData;
use GoDaddy\Services\Domains\v1\DTO\ConsentData;

test('PurchasePrivacyData returns correct array structure', function () {
    $consentData = new ConsentData(
        agreedAt: '2023-01-01T00:00:00Z',
        agreedBy: 'test@example.com',
        agreementKeys: ['PRIVACY_AGREEMENT']
    );
    
    $purchasePrivacyData = new PurchasePrivacyData(
        consent: $consentData
    );
    
    $result = $purchasePrivacyData->toArray();
    
    expect($result)->toMatchArray([
        'consent' => [
            'agreedAt' => '2023-01-01T00:00:00Z',
            'agreedBy' => 'test@example.com',
            'agreementKeys' => ['PRIVACY_AGREEMENT']
        ]
    ]);
});

test('PurchasePrivacyData filters null values', function () {
    $purchasePrivacyData = new PurchasePrivacyData();
    
    $result = $purchasePrivacyData->toArray();
    
    expect($result)->toBe([]);
}); 
