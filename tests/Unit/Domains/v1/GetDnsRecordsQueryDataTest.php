<?php

use GoDaddy\Services\Domains\v1\DTO\GetDnsRecordsQueryData;

test('GetDnsRecordsQueryData returns correct array structure', function () {
    $queryData = new GetDnsRecordsQueryData(
        offset: 10,
        limit: 50
    );
    
    $result = $queryData->toArray();
    
    expect($result)->toMatchArray([
        'offset' => 10,
        'limit' => 50
    ]);
});

test('GetDnsRecordsQueryData filters null values', function () {
    $queryData = new GetDnsRecordsQueryData();
    
    $result = $queryData->toArray();
    
    expect($result)->toBe([]);
});

test('GetDnsRecordsQueryData handles partial values', function () {
    $queryData = new GetDnsRecordsQueryData(
        offset: 5
    );
    
    $result = $queryData->toArray();
    
    expect($result)->toMatchArray([
        'offset' => 5
    ]);
}); 
