<?php

use GoDaddy\Services\Orders\v1\DTO\OrdersHeadersData;

test('OrdersHeadersData returns correct array structure for list context', function () {
    $data = new OrdersHeadersData('app-key-xyz', 'shopper-id-123');

    $result = $data->toArray('list');
    
    expect($result)->toHaveKey('X-App-Key');
    expect($result)->toHaveKey('X-Shopper-Id');
    expect($result['X-App-Key'])->toBe('app-key-xyz');
    expect($result['X-Shopper-Id'])->toBe('shopper-id-123');
    expect($result)->not->toHaveKey('X-Market-Id');
});

test('OrdersHeadersData returns correct array structure for single context', function () {
    $data = new OrdersHeadersData('app-key-xyz', 'shopper-id-123', 'en-US');

    $result = $data->toArray('single');
    
    expect($result)->toHaveKey('X-App-Key');
    expect($result)->toHaveKey('X-Shopper-Id');
    expect($result)->toHaveKey('X-Market-Id');
    expect($result['X-App-Key'])->toBe('app-key-xyz');
    expect($result['X-Shopper-Id'])->toBe('shopper-id-123');
    expect($result['X-Market-Id'])->toBe('en-US');
}); 