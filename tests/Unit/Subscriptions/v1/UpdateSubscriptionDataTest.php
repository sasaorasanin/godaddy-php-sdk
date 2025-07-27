<?php

use GoDaddy\Services\Subscriptions\v1\DTO\UpdateSubscriptionData;

test('UpdateSubscriptionData returns correct array structure', function () {
    $data = new UpdateSubscriptionData(
        paymentProfileId: 123,
        renewAuto: true
    );

    $result = $data->toArray();
    
    expect($result)->toBe([
        'paymentProfileId' => 123,
        'renewAuto' => true,
    ]);
}); 
