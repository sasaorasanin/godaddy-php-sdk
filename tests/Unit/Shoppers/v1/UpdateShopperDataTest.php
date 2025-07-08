<?php

use GoDaddy\Services\Shoppers\v1\DTO\UpdateShopperData;

test('UpdateShopperData returns correct array structure', function () {
    $data = new UpdateShopperData(
        'john.smith@example.com',
        67890,
        'en-US',
        'John',
        'Smith'
    );

    $result = $data->toArray();
    
    expect($result)->toBe([
        'email' => 'john.smith@example.com',
        'externalId' => 67890,
        'marketId' => 'en-US',
        'nameFirst' => 'John',
        'nameLast' => 'Smith',
    ]);
}); 