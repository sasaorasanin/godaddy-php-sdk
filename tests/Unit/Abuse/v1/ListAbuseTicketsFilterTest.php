<?php

use GoDaddy\Services\Abuse\v1\DTO\ListAbuseTicketsFilter;

test('ListAbuseTicketsFilter returns correct filtered array', function () {
    $filter = new ListAbuseTicketsFilter(
        type: 'phishing',
        closed: true,
        sourceDomainOrIp: '1.2.3.4',
        target: 'target.com',
        createdStart: '2024-01-01',
        createdEnd: '2024-12-31',
        limit: 50,
        offset: 10
    );

    expect($filter->toArray())->toBe([
        'type' => 'phishing',
        'closed' => true,
        'sourceDomainOrIp' => '1.2.3.4',
        'target' => 'target.com',
        'createdStart' => '2024-01-01',
        'createdEnd' => '2024-12-31',
        'limit' => 50,
        'offset' => 10,
    ]);
});
