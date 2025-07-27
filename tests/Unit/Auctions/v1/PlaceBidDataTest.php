<?php

use GoDaddy\Services\Auctions\v1\DTO\PlaceBidData;

test('PlaceBidData assigns and outputs correct values', function () {
    $bid = new PlaceBidData(100.0, true, 555555);
    expect($bid->toArray())->toBe([
        'bidAmountUsd' => 100.0,
        'tosAccepted' => true,
        'listingId' => 555555,
    ]);
}); 
