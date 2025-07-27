<?php

use GoDaddy\Services\Domains\v1\DTO\RenewDomainData;

test('RenewDomainData returns correct array structure', function () {
    $renewData = new RenewDomainData(
        period: 5
    );
    
    $result = $renewData->toArray();
    
    expect($result)->toMatchArray([
        'period' => 5
    ]);
});

test('RenewDomainData filters null values', function () {
    $renewData = new RenewDomainData();
    
    $result = $renewData->toArray();
    
    expect($result)->toBe([]);
}); 
