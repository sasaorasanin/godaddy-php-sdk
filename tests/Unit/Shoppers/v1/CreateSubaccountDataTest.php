<?php

use GoDaddy\Services\Shoppers\v1\DTO\CreateSubaccountData;

test('CreateSubaccountData returns correct array structure', function () {
    $data = new CreateSubaccountData(
        'john@example.com',
        12345,
        'en-US',
        'John',
        'Doe',
        'securePassword123'
    );

    $result = $data->toArray();
    
    expect($result)->toBe([
        'email' => 'john@example.com',
        'externalId' => 12345,
        'marketId' => 'en-US',
        'nameFirst' => 'John',
        'nameLast' => 'Doe',
        'password' => 'securePassword123',
    ]);
}); 