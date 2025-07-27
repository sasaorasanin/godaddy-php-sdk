<?php

use GoDaddy\Services\Parking\v1\DTO\MetricsByDomainQueryData;

test('MetricsByDomainQueryData returns correct array structure', function () {
    $data = new MetricsByDomainQueryData(
        startDate: '2024-01-01',
        endDate: '2024-01-31',
        domains: 'example.com,test.com',
        domainLike: 'example',
        portfolioId: 'portfolio123',
        limit: 50,
        offset: 10
    );

    $result = $data->toArray();
    
    expect($result)->toHaveKey('startDate');
    expect($result)->toHaveKey('endDate');
    expect($result)->toHaveKey('domains');
    expect($result)->toHaveKey('domainLike');
    expect($result)->toHaveKey('portfolioId');
    expect($result)->toHaveKey('limit');
    expect($result)->toHaveKey('offset');
    
    expect($result['startDate'])->toBe('2024-01-01');
    expect($result['endDate'])->toBe('2024-01-31');
    expect($result['domains'])->toBe('example.com,test.com');
    expect($result['domainLike'])->toBe('example');
    expect($result['portfolioId'])->toBe('portfolio123');
    expect($result['limit'])->toBe(50);
    expect($result['offset'])->toBe(10);
});

test('MetricsByDomainQueryData uses default values', function () {
    $data = new MetricsByDomainQueryData(
        startDate: '2024-01-01',
        endDate: '2024-01-31'
    );

    $result = $data->toArray();
    
    expect($result)->toHaveKey('startDate');
    expect($result)->toHaveKey('endDate');
    expect($result)->toHaveKey('limit');
    expect($result)->toHaveKey('offset');
    expect($result['startDate'])->toBe('2024-01-01');
    expect($result['endDate'])->toBe('2024-01-31');
    expect($result['limit'])->toBe(20);
    expect($result['offset'])->toBe(0);
}); 
