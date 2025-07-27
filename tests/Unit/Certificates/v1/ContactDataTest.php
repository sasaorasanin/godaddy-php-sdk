<?php

use GoDaddy\Services\Certificates\v1\DTO\ContactData;

test('ContactData returns correct array structure', function () {
    $data = new ContactData(
        'john@example.com',
        'Developer',
        'John',
        'Doe',
        'M',
        '123456789',
        'Jr'
    );

    $result = $data->toArray();
    
    expect($result)->toBe([
        'email' => 'john@example.com',
        'jobTitle' => 'Developer',
        'nameFirst' => 'John',
        'nameLast' => 'Doe',
        'nameMiddle' => 'M',
        'phone' => '123456789',
        'suffix' => 'Jr',
    ]);
}); 
