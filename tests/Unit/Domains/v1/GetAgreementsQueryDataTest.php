<?php

use GoDaddy\Services\Domains\v1\DTO\GetAgreementsQueryData;

test('GetAgreementsQueryData returns correct array structure', function () {
    $queryData = new GetAgreementsQueryData(
        tlds: ['com', 'net'],
        privacy: true,
        forTransfer: false
    );

    $result = $queryData->toArray();

    expect($result)->toBe([
        'tlds' => ['com', 'net'],
        'privacy' => true,
        'forTransfer' => false
    ]);
});

test('GetAgreementsQueryData filters null forTransfer', function () {
    $queryData = new GetAgreementsQueryData(
        tlds: ['com'],
        privacy: false
    );

    $result = $queryData->toArray();

    expect($result)->toBe([
        'tlds' => ['com'],
        'privacy' => false
    ]);
}); 
