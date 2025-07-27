<?php

use GoDaddy\Services\Aftermarket\v1\AftermarketService;
use GoDaddy\Services\Aftermarket\v1\DTO\GetAuctionListingsFilter;
use GoDaddy\Services\Aftermarket\v1\DTO\DeleteAuctionListingsData;
use GoDaddy\Services\Aftermarket\v1\DTO\CreateExpiryListingsData;
use GoDaddy\Services\Aftermarket\v1\DTO\ExpiryListingItem;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Client;

test('AftermarketService can get auction listings', function () {
    $mock = new MockHandler([
        new Response(200, [], json_encode([
            ['domain' => 'example.com', 'status' => 'active'],
            ['domain' => 'test.com', 'status' => 'expired'],
        ])),
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack, 'base_uri' => 'https://api.example.com']);

    $service = new class('key', 'secret', 'https://api.example.com') extends AftermarketService {
        public function setClient(\GuzzleHttp\Client $client): void { $this->client = $client; }
    };
    $service->setClient($client);

    $filter = new GetAuctionListingsFilter('cust-1', domains: 'example.com');
    $result = $service->getListings($filter);
    expect($result)->toBe([
        ['domain' => 'example.com', 'status' => 'active'],
        ['domain' => 'test.com', 'status' => 'expired'],
    ]);
});

test('AftermarketService can delete auction listings', function () {
    $mock = new MockHandler([
        new Response(200, [], json_encode(['deleted' => ['example.com', 'test.com']])),
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack, 'base_uri' => 'https://api.example.com']);

    $service = new class('key', 'secret', 'https://api.example.com') extends AftermarketService {
        public function setClient(\GuzzleHttp\Client $client): void { $this->client = $client; }
    };
    $service->setClient($client);

    $data = new DeleteAuctionListingsData(['example.com', 'test.com']);
    $result = $service->deleteListings($data);
    expect($result)->toBe(['deleted' => ['example.com', 'test.com']]);
});

test('AftermarketService can create expiry listings', function () {
    $mock = new MockHandler([
        new Response(200, [], json_encode(['created' => 2])),
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack, 'base_uri' => 'https://api.example.com']);

    $service = new class('key', 'secret', 'https://api.example.com') extends AftermarketService {
        public function setClient(\GuzzleHttp\Client $client): void { $this->client = $client; }
    };
    $service->setClient($client);

    $item1 = new ExpiryListingItem('example.com', '2024-01-01', 123, 10, 20);
    $item2 = new ExpiryListingItem('test.com', '2024-02-01', 456);
    $data = new CreateExpiryListingsData([$item1, $item2]);
    $result = $service->createExpiryListings($data);
    expect($result)->toBe(['created' => 2]);
}); 
