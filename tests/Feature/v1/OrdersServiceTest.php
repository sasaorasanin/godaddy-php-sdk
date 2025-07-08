<?php

use GoDaddy\Services\Orders\v1\OrdersService;
use GoDaddy\Services\Orders\v1\DTO\ListOrdersQueryData;
use GoDaddy\Services\Orders\v1\DTO\OrdersHeadersData;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Client;

test('OrdersService can get all orders', function () {
    $mock = new MockHandler([
        new Response(200, [], json_encode([
            ['orderId' => 'order123', 'status' => 'ACTIVE'],
            ['orderId' => 'order456', 'status' => 'COMPLETED'],
        ])),
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack, 'base_uri' => 'https://api.example.com']);

    $service = new class('key', 'secret', 'https://api.example.com') extends OrdersService {
        public function setClient($client) { $this->client = $client; }
    };
    $service->setClient($client);

    $query = new ListOrdersQueryData(
        limit: 10,
        offset: 0
    );
    $headers = new OrdersHeadersData('shopper-id-123');
    
    $result = $service->getAll($query, $headers, 'list');
    expect($result)->toBe([
        ['orderId' => 'order123', 'status' => 'ACTIVE'],
        ['orderId' => 'order456', 'status' => 'COMPLETED'],
    ]);
});

test('OrdersService can get specific order by ID', function () {
    $mock = new MockHandler([
        new Response(200, [], json_encode([
            'orderId' => 'order123',
            'status' => 'ACTIVE',
            'total' => 99.99,
            'currency' => 'USD'
        ])),
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack, 'base_uri' => 'https://api.example.com']);

    $service = new class('key', 'secret', 'https://api.example.com') extends OrdersService {
        public function setClient($client) { $this->client = $client; }
    };
    $service->setClient($client);

    $headers = new OrdersHeadersData('shopper-id-123');
    
    $result = $service->getById('order123', $headers, 'single');
    expect($result)->toBe([
        'orderId' => 'order123',
        'status' => 'ACTIVE',
        'total' => 99.99,
        'currency' => 'USD'
    ]);
}); 