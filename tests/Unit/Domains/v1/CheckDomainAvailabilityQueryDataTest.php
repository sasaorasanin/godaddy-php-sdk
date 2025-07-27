<?php

use GoDaddy\Services\Domains\v1\DTO\CheckDomainAvailabilityQueryData;
use GoDaddy\Services\Domains\v1\Enums\CheckType;

test('CheckDomainAvailabilityQueryData returns correct array structure', function () {
    $queryData = new CheckDomainAvailabilityQueryData(
        domain: 'example.com',
        checkType: CheckType::FULL,
        forTransfer: true
    );

    $result = $queryData->toArray();

    expect($result)->toBe([
        'domain' => 'example.com',
        'checkType' => 'FULL',
        'forTransfer' => true
    ]);
});

test('CheckDomainAvailabilityQueryData filters null values', function () {
    $queryData = new CheckDomainAvailabilityQueryData(
        domain: 'example.com'
    );

    $result = $queryData->toArray();

    expect($result)->toBe([
        'domain' => 'example.com'
    ]);
});

test('CheckDomainAvailabilityQueryData uses default values', function () {
    $queryData = new CheckDomainAvailabilityQueryData(
        domain: 'example.com',
        checkType: CheckType::FAST
    );

    $result = $queryData->toArray();

    expect($result)->toBe([
        'domain' => 'example.com',
        'checkType' => 'FAST'
    ]);
}); 
