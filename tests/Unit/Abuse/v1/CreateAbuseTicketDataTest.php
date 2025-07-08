<?php

use GoDaddy\Services\Abuse\v1\DTO\CreateAbuseTicketData;

test('CreateAbuseTicketData returns correct array structure', function () {
    $data = new CreateAbuseTicketData(
        'info value',
        'https://info.url',
        'source value',
        'target value',
        true,
        'proxy value',
        'type value',
    );

    expect($data->toArray())->toBe([
        'info' => 'info value',
        'infoUrl' => 'https://info.url',
        'source' => 'source value',
        'target' => 'target value',
        'intentional' => true,
        'proxy' => 'proxy value',
        'type' => 'type value',
    ]);
});
