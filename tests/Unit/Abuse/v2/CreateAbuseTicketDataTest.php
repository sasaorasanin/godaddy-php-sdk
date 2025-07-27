<?php

use GoDaddy\Services\Abuse\v2\DTO\CreateAbuseTicketData;

test('CreateAbuseTicketData returns correct array structure', function () {
    $data = new CreateAbuseTicketData(
        'info value',
        'https://info.url',
        'source value',
        'target value',
        'type value',
        'proxy value',
        'useragent value'
    );

    expect($data->toArray())->toBe([
        'info' => 'info value',
        'infoUrl' => 'https://info.url',
        'source' => 'source value',
        'target' => 'target value',
        'type' => 'type value',
        'proxy' => 'proxy value',
        'useragent' => 'useragent value',
    ]);
});
