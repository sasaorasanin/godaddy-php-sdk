<?php

use GoDaddy\Services\Domains\v1\DTO\TldData;

test('TldData returns correct array structure', function () {
    $tldData = new TldData(
        name: 'com',
        type: 'GENERIC'
    );

    $result = $tldData->toArray();

    expect($result)->toBe([
        'name' => 'com',
        'type' => 'GENERIC'
    ]);
});

test('TldData fromArray creates correct object', function () {
    $data = [
        'name' => 'net',
        'type' => 'GENERIC'
    ];

    $tldData = TldData::fromArray($data);

    expect($tldData->name)->toBe('net');
    expect($tldData->type)->toBe('GENERIC');
}); 
