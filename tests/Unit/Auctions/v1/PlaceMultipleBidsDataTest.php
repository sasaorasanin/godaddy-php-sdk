<?php

use GoDaddy\Services\Auctions\v1\DTO\PlaceBidData;
use GoDaddy\Services\Auctions\v1\DTO\PlaceMultipleBidsData;

test('PlaceMultipleBidsData assigns and outputs correct values', function () {
    $bid1 = new PlaceBidData(100.0, true, 555555);
    $bid2 = new PlaceBidData(150.0, true, 666666);
    $data = new PlaceMultipleBidsData('customer-1', [$bid1, $bid2]);
    expect($data->toArray())->toBe([
        [
            'bidAmountUsd' => 100.0,
            'tosAccepted' => true,
            'listingId' => 555555,
        ],
        [
            'bidAmountUsd' => 150.0,
            'tosAccepted' => true,
            'listingId' => 666666,
        ],
    ]);
}); 