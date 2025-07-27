<?php

use GoDaddy\Services\Domains\v1\DTO\PurchasePrivacyResponseData;

test('PurchasePrivacyResponseData returns correct array structure', function () {
    $responseData = new PurchasePrivacyResponseData(
        currency: 'USD',
        itemCount: 1,
        orderId: 12345,
        total: 999
    );
    
    $result = $responseData->toArray();
    
    expect($result)->toMatchArray([
        'currency' => 'USD',
        'itemCount' => 1,
        'orderId' => 12345,
        'total' => 999
    ]);
});

test('PurchasePrivacyResponseData fromArray creates correct object', function () {
    $data = [
        'currency' => 'EUR',
        'itemCount' => 2,
        'orderId' => 67890,
        'total' => 1999
    ];
    
    $responseData = PurchasePrivacyResponseData::fromArray($data);
    
    expect($responseData->currency)->toBe('EUR');
    expect($responseData->itemCount)->toBe(2);
    expect($responseData->orderId)->toBe(67890);
    expect($responseData->total)->toBe(1999);
}); 
