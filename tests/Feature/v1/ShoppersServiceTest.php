<?php

use GoDaddy\Services\Shoppers\v1\ShoppersService;
use GoDaddy\Services\Shoppers\v1\DTO\{
    CreateSubaccountData,
    UpdateShopperData,
    SetPasswordData,
    DeleteShopperQueryData,
    ShopperIncludesQueryData,
    ShopperStatusQueryData
};
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Client;

test('ShoppersService can create sub-account', function () {
    $mock = new MockHandler([
        new Response(200, [], json_encode(['shopperId' => 'shopper123', 'status' => 'created'])),
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack, 'base_uri' => 'https://api.example.com']);

    $service = new class('key', 'secret', 'https://api.example.com') extends ShoppersService {
        public function setClient($client) { $this->client = $client; }
    };
    $service->setClient($client);

    $createData = new CreateSubaccountData(
        'john@example.com',
        123456789,
        'US',
        'John',
        'Doe',
        'securePassword123'
    );

    $result = $service->createSubaccount($createData);
    expect($result)->toBe(['shopperId' => 'shopper123', 'status' => 'created']);
});

test('ShoppersService can get shopper', function () {
    $mock = new MockHandler([
        new Response(200, [], json_encode([
            'shopperId' => 'shopper123',
            'name' => 'John Doe',
            'email' => 'john@example.com'
        ])),
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack, 'base_uri' => 'https://api.example.com']);

    $service = new class('key', 'secret', 'https://api.example.com') extends ShoppersService {
        public function setClient($client) { $this->client = $client; }
    };
    $service->setClient($client);

    $includes = new ShopperIncludesQueryData(['domains', 'subscriptions']);
    $result = $service->getShopper('shopper123', $includes);
    expect($result)->toBe([
        'shopperId' => 'shopper123',
        'name' => 'John Doe',
        'email' => 'john@example.com'
    ]);
});

test('ShoppersService can update shopper', function () {
    $mock = new MockHandler([
        new Response(200, [], json_encode([
            'shopperId' => 'shopper123',
            'name' => 'John Smith',
            'email' => 'john.smith@example.com'
        ])),
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack, 'base_uri' => 'https://api.example.com']);

    $service = new class('key', 'secret', 'https://api.example.com') extends ShoppersService {
        public function setClient($client) { $this->client = $client; }
    };
    $service->setClient($client);

    $updateData = new UpdateShopperData(
        'john.smith@example.com',
        987654321,
        'CA',
        'John',
        'Smith'
    );

    $result = $service->updateShopper('shopper123', $updateData);
    expect($result)->toBe([
        'shopperId' => 'shopper123',
        'name' => 'John Smith',
        'email' => 'john.smith@example.com'
    ]);
});

test('ShoppersService can set password', function () {
    $mock = new MockHandler([
        new Response(200, [], json_encode(['status' => 'success'])),
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack, 'base_uri' => 'https://api.example.com']);

    $service = new class('key', 'secret', 'https://api.example.com') extends ShoppersService {
        public function setClient($client) { $this->client = $client; }
    };
    $service->setClient($client);

    $passwordData = new SetPasswordData('newSecurePassword123');
    $result = $service->setPassword('shopper123', $passwordData);
    expect($result)->toBe(['status' => 'success']);
}); 