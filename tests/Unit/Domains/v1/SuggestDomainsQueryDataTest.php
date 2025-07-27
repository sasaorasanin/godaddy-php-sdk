<?php

use GoDaddy\Services\Domains\v1\DTO\SuggestDomainsQueryData;

test('SuggestDomainsQueryData returns correct array structure', function () {
    $queryData = new SuggestDomainsQueryData(
        query: 'example',
        country: 'US',
        city: 'New York',
        sources: ['EXTENSION', 'KEYWORD_SPIN'],
        tlds: ['com', 'net', 'org'],
        lengthMax: 20,
        lengthMin: 3,
        limit: 10,
        waitMs: 2000
    );

    $result = $queryData->toArray();

    expect($result)->toBe([
        'query' => 'example',
        'country' => 'US',
        'city' => 'New York',
        'sources' => ['EXTENSION', 'KEYWORD_SPIN'],
        'tlds' => ['com', 'net', 'org'],
        'lengthMax' => 20,
        'lengthMin' => 3,
        'limit' => 10,
        'waitMs' => 2000
    ]);
});

test('SuggestDomainsQueryData filters null values', function () {
    $queryData = new SuggestDomainsQueryData(
        query: 'example'
    );

    $result = $queryData->toArray();

    expect($result)->toBe([
        'query' => 'example'
    ]);
}); 
