<?php

use GoDaddy\Services\Auctions\v1\AuctionsService;
use GoDaddy\Services\Auctions\v1\DTO\PlaceBidData;
use GoDaddy\Services\Auctions\v1\DTO\PlaceMultipleBidsData;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Client;

test('AuctionsService can place multiple bids', function () {
    $mock = new MockHandler([
        new Response(200, [], json_encode([
            ['listingId' => 555555, 'status' => 'success'],
            ['listingId' => 666666, 'status' => 'success'],
        ])),
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack, 'base_uri' => 'https://api.example.com']);

    $service = new class('key', 'secret', 'https://api.example.com') extends AuctionsService {
        public function setClient(Client $client): void { $this->client = $client; }
    };
    $service->setClient($client);

    $bid1 = new PlaceBidData(100.0, true, 555555);
    $bid2 = new PlaceBidData(150.0, true, 666666);
    $data = new PlaceMultipleBidsData('customer-1', [$bid1, $bid2]);
    $result = $service->placeBids($data);
    expect($result)->toBe([
        ['listingId' => 555555, 'status' => 'success'],
        ['listingId' => 666666, 'status' => 'success'],
    ]);
}); 
