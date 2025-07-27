<?php

use GoDaddy\Services\Domains\v2\DTO\GetDomainDetailsQueryData;
use GoDaddy\Services\Domains\v2\Enums\DomainInclude;

test('GetDomainDetailsQueryData returns correct array structure', function () {
    $queryData = new GetDomainDetailsQueryData(
        includes: [DomainInclude::ACTIONS, DomainInclude::CONTACTS]
    );
    
    $result = $queryData->toArray();
    
    expect($result)->toMatchArray([
        'includes' => ['actions', 'contacts']
    ]);
});

test('GetDomainDetailsQueryData handles null includes', function () {
    $queryData = new GetDomainDetailsQueryData();
    
    $result = $queryData->toArray();
    
    expect($result)->toMatchArray([]);
    expect($result)->toBeArray();
}); 
