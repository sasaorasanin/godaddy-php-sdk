<?php

use GoDaddy\Services\Orders\v1\DTO\ListOrdersQueryData;

test('ListOrdersQueryData returns correct array structure', function () {
    $data = new ListOrdersQueryData(
        periodStart: '2024-01-01',
        periodEnd: '2024-01-31',
        domain: 'example.com',
        productGroupId: 123,
        paymentProfileId: 456,
        parentOrderId: 'parent123',
        offset: 10,
        limit: 50,
        sort: '-createdAt'
    );

    $result = $data->toArray();
    
    expect($result)->toHaveKey('periodStart');
    expect($result)->toHaveKey('periodEnd');
    expect($result)->toHaveKey('domain');
    expect($result)->toHaveKey('productGroupId');
    expect($result)->toHaveKey('paymentProfileId');
    expect($result)->toHaveKey('parentOrderId');
    expect($result)->toHaveKey('offset');
    expect($result)->toHaveKey('limit');
    expect($result)->toHaveKey('sort');
    
    expect($result['periodStart'])->toBe('2024-01-01');
    expect($result['periodEnd'])->toBe('2024-01-31');
    expect($result['domain'])->toBe('example.com');
    expect($result['productGroupId'])->toBe(123);
    expect($result['paymentProfileId'])->toBe(456);
    expect($result['parentOrderId'])->toBe('parent123');
    expect($result['offset'])->toBe(10);
    expect($result['limit'])->toBe(50);
    expect($result['sort'])->toBe('-createdAt');
});

test('ListOrdersQueryData filters null values', function () {
    $data = new ListOrdersQueryData(
        offset: 10,
        limit: 50
    );

    $result = $data->toArray();
    
    expect($result)->not->toHaveKey('periodStart');
    expect($result)->not->toHaveKey('periodEnd');
    expect($result)->not->toHaveKey('domain');
    expect($result)->not->toHaveKey('productGroupId');
    expect($result)->not->toHaveKey('paymentProfileId');
    expect($result)->not->toHaveKey('parentOrderId');
    expect($result)->toHaveKey('offset');
    expect($result)->toHaveKey('limit');
    expect($result)->toHaveKey('sort');
    
    expect($result['offset'])->toBe(10);
    expect($result['limit'])->toBe(50);
    expect($result['sort'])->toBe('-createdAt');
}); 