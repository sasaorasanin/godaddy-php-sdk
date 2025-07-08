<?php

use GoDaddy\Services\Parking\v1\DTO\ParkingMetricsQueryData;

test('ParkingMetricsQueryData returns correct array structure', function () {
    $data = new ParkingMetricsQueryData(
        periodStartPtz: '2024-01-01T00:00:00Z',
        periodEndPtz: '2024-01-31T23:59:59Z',
        limit: 50,
        offset: 10
    );

    $result = $data->toArray();
    
    expect($result)->toHaveKey('periodStartPtz');
    expect($result)->toHaveKey('periodEndPtz');
    expect($result)->toHaveKey('limit');
    expect($result)->toHaveKey('offset');
    
    expect($result['periodStartPtz'])->toBe('2024-01-01T00:00:00Z');
    expect($result['periodEndPtz'])->toBe('2024-01-31T23:59:59Z');
    expect($result['limit'])->toBe(50);
    expect($result['offset'])->toBe(10);
});

test('ParkingMetricsQueryData uses default values', function () {
    $data = new ParkingMetricsQueryData();

    $result = $data->toArray();
    
    expect($result)->toHaveKey('limit');
    expect($result)->toHaveKey('offset');
    expect($result['limit'])->toBe(20);
    expect($result['offset'])->toBe(0);
}); 