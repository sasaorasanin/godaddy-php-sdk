<?php

use GoDaddy\Services\Domains\v1\DTO\ListDomainsQueryData;
use GoDaddy\Services\Domains\v1\Enums\DomainStatus;
use GoDaddy\Services\Domains\v1\Enums\DomainStatusGroup;
use GoDaddy\Services\Domains\v1\Enums\DomainInclude;

test('ListDomainsQueryData returns correct array structure', function () {
    $queryData = new ListDomainsQueryData(
        statuses: [DomainStatus::ACTIVE, DomainStatus::CANCELLED],
        statusGroups: [DomainStatusGroup::VISIBLE],
        limit: 10,
        marker: 'example.com',
        includes: [DomainInclude::CONTACTS, DomainInclude::NAME_SERVERS],
        modifiedDate: '2024-01-01T00:00:00Z'
    );

    $result = $queryData->toArray();

    expect($result)->toBe([
        'statuses' => ['ACTIVE', 'CANCELLED'],
        'statusGroups' => ['VISIBLE'],
        'limit' => 10,
        'marker' => 'example.com',
        'includes' => ['contacts', 'nameServers'],
        'modifiedDate' => '2024-01-01T00:00:00Z'
    ]);
});

test('ListDomainsQueryData filters null values', function () {
    $queryData = new ListDomainsQueryData(
        limit: 10,
        marker: 'example.com'
    );

    $result = $queryData->toArray();

    expect($result)->toBe([
        'limit' => 10,
        'marker' => 'example.com'
    ]);
});

test('ListDomainsQueryData uses default values', function () {
    $queryData = new ListDomainsQueryData();

    $result = $queryData->toArray();

    expect($result)->toBe([]);
}); 
