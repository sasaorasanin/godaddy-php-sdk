<?php

use GoDaddy\Services\Subscriptions\v1\DTO\SubscriptionListQueryData;

test('SubscriptionListQueryData returns correct array structure', function () {
    $data = new SubscriptionListQueryData(
        productGroupKeys: ['domains', 'hosting'],
        includes: ['details', 'pricing'],
        offset: 10,
        limit: 50,
        sort: '-expiresAt'
    );

    $result = $data->toArray();
    
    expect($result)->toBe([
        'productGroupKeys' => ['domains', 'hosting'],
        'includes' => ['details', 'pricing'],
        'offset' => 10,
        'limit' => 50,
        'sort' => '-expiresAt',
    ]);
});

test('SubscriptionListQueryData uses default values', function () {
    $data = new SubscriptionListQueryData();

    $result = $data->toArray();
    
    expect($result)->toBe([
        'productGroupKeys' => [],
        'includes' => [],
        'offset' => 0,
        'limit' => 25,
        'sort' => '-expiresAt',
    ]);
}); 
