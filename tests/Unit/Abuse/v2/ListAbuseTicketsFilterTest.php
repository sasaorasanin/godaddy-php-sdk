<?php

use GoDaddy\Services\Abuse\v2\DTO\ListAbuseTicketsFilter;

test('ListAbuseTicketsFilter assigns and outputs correct values', function () {
    $filter = new ListAbuseTicketsFilter(
        type: 'phishing',
        closed: true,
        sourceDomainOrIp: '1.2.3.4',
        target: 'target.com',
        createdStart: '2024-01-01',
        createdEnd: '2024-01-31',
        limit: 10,
        offset: 5
    );

    expect($filter->toArray())->toBe([
        'type' => 'phishing',
        'closed' => true,
        'sourceDomainOrIp' => '1.2.3.4',
        'target' => 'target.com',
        'createdStart' => '2024-01-01',
        'createdEnd' => '2024-01-31',
        'limit' => 10,
        'offset' => 5,
    ]);
});

test('ListAbuseTicketsFilter uses default values', function () {
    $filter = new ListAbuseTicketsFilter();
    expect($filter->toArray())->toBe([
        'limit' => 100,
        'offset' => 0,
    ]);
}); 
