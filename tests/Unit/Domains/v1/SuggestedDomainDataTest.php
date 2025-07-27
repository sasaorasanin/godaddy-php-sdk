<?php

use GoDaddy\Services\Domains\v1\DTO\SuggestedDomainData;

test('SuggestedDomainData returns correct array structure', function () {
    $domainData = new SuggestedDomainData(
        domain: 'example.com'
    );

    $result = $domainData->toArray();

    expect($result)->toBe([
        'domain' => 'example.com'
    ]);
});

test('SuggestedDomainData fromArray creates correct object', function () {
    $data = [
        'domain' => 'example.net'
    ];

    $domainData = SuggestedDomainData::fromArray($data);

    expect($domainData->domain)->toBe('example.net');
}); 
