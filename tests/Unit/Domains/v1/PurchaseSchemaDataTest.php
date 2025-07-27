<?php

use GoDaddy\Services\Domains\v1\DTO\PurchaseSchemaData;

test('PurchaseSchemaData returns correct array structure', function () {
    $schemaData = new PurchaseSchemaData(
        id: 'com-domain-schema',
        models: ['contact' => ['type' => 'object']],
        properties: ['domain' => ['type' => 'string']],
        required: ['domain', 'contact']
    );

    $result = $schemaData->toArray();

    expect($result)->toBe([
        'id' => 'com-domain-schema',
        'models' => ['contact' => ['type' => 'object']],
        'properties' => ['domain' => ['type' => 'string']],
        'required' => ['domain', 'contact']
    ]);
});

test('PurchaseSchemaData fromArray creates correct object', function () {
    $data = [
        'id' => 'com-domain-schema',
        'models' => ['contact' => ['type' => 'object']],
        'properties' => ['domain' => ['type' => 'string']],
        'required' => ['domain', 'contact']
    ];

    $schemaData = PurchaseSchemaData::fromArray($data);

    expect($schemaData->id)->toBe('com-domain-schema');
    expect($schemaData->models)->toBe(['contact' => ['type' => 'object']]);
    expect($schemaData->properties)->toBe(['domain' => ['type' => 'string']]);
    expect($schemaData->required)->toBe(['domain', 'contact']);
});

test('PurchaseSchemaData fromArray handles missing optional fields', function () {
    $data = [
        'id' => 'com-domain-schema'
    ];

    $schemaData = PurchaseSchemaData::fromArray($data);

    expect($schemaData->id)->toBe('com-domain-schema');
    expect($schemaData->models)->toBe([]);
    expect($schemaData->properties)->toBe([]);
    expect($schemaData->required)->toBe([]);
}); 
