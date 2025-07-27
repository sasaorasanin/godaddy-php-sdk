<?php

use GoDaddy\Services\Domains\v1\DTO\CheckDomainsAvailabilityData;
use GoDaddy\Services\Domains\v1\Enums\CheckType;

test('CheckDomainsAvailabilityData returns correct array structure', function () {
    $data = new CheckDomainsAvailabilityData(
        domains: ['example.com', 'test.com'],
        checkType: CheckType::FULL
    );

    $result = $data->toArray();

    expect($result)->toBe([
        'domains' => ['example.com', 'test.com'],
        'checkType' => 'FULL'
    ]);
});

test('CheckDomainsAvailabilityData filters null checkType', function () {
    $data = new CheckDomainsAvailabilityData(
        domains: ['example.com']
    );

    $result = $data->toArray();

    expect($result)->toBe([
        'domains' => ['example.com']
    ]);
}); 
