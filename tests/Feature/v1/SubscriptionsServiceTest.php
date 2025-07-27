<?php

use GoDaddy\Services\Subscriptions\v1\SubscriptionsService;
use GoDaddy\Services\Subscriptions\v1\DTO\{
    SubscriptionListQueryData,
    SubscriptionHeadersData,
    UpdateSubscriptionData
};
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Client;

test('SubscriptionsService can get subscriptions', function () {
    $mock = new MockHandler([
        new Response(200, [], json_encode([
            ['subscriptionId' => 'sub123', 'status' => 'ACTIVE'],
            ['subscriptionId' => 'sub456', 'status' => 'CANCELLED'],
        ])),
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack, 'base_uri' => 'https://api.example.com']);

    $service = new class('key', 'secret', 'https://api.example.com') extends SubscriptionsService {
        public function setClient(Client $client): void { $this->client = $client; }
    };
    $service->setClient($client);

    $query = new SubscriptionListQueryData(
        limit: 10,
        offset: 0,
        productGroupKeys: ['domains', 'hosting']
    );
    $headers = new SubscriptionHeadersData('shopper-id-123');
    
    $result = $service->getSubscriptions($query, $headers);
    expect($result)->toBe([
        ['subscriptionId' => 'sub123', 'status' => 'ACTIVE'],
        ['subscriptionId' => 'sub456', 'status' => 'CANCELLED'],
    ]);
});

test('SubscriptionsService can get specific subscription', function () {
    $mock = new MockHandler([
        new Response(200, [], json_encode([
            'subscriptionId' => 'sub123',
            'status' => 'ACTIVE',
            'quantity' => 1,
            'autoRenew' => true
        ])),
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack, 'base_uri' => 'https://api.example.com']);

    $service = new class('key', 'secret', 'https://api.example.com') extends SubscriptionsService {
        public function setClient(Client $client): void { $this->client = $client; }
    };
    $service->setClient($client);

    $headers = new SubscriptionHeadersData('shopper-id-123');
    
    $result = $service->getSubscription('sub123', $headers);
    expect($result)->toBe([
        'subscriptionId' => 'sub123',
        'status' => 'ACTIVE',
        'quantity' => 1,
        'autoRenew' => true
    ]);
});

test('SubscriptionsService can cancel subscription', function () {
    $mock = new MockHandler([
        new Response(200, [], ''),
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack, 'base_uri' => 'https://api.example.com']);

    $service = new class('key', 'secret', 'https://api.example.com') extends SubscriptionsService {
        public function setClient(Client $client): void { $this->client = $client; }
    };
    $service->setClient($client);

    $headers = new SubscriptionHeadersData('shopper-id-123');
    
    $service->cancelSubscription('sub123', $headers);
    expect(true)->toBeTrue();
});

test('SubscriptionsService can update subscription', function () {
    $mock = new MockHandler([
        new Response(200, [], ''),
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack, 'base_uri' => 'https://api.example.com']);

    $service = new class('key', 'secret', 'https://api.example.com') extends SubscriptionsService {
        public function setClient(Client $client): void { $this->client = $client; }
    };
    $service->setClient($client);

    $updateData = new UpdateSubscriptionData(
        paymentProfileId: 123,
        renewAuto: true
    );
    $headers = new SubscriptionHeadersData('shopper-id-123');
    
    $service->updateSubscription('sub123', $updateData, $headers);
    expect(true)->toBeTrue();
});

test('SubscriptionsService can get product groups', function () {
    $mock = new MockHandler([
        new Response(200, [], json_encode([
            ['productGroupKey' => 'domains', 'name' => 'Domain Names'],
            ['productGroupKey' => 'hosting', 'name' => 'Web Hosting'],
        ])),
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack, 'base_uri' => 'https://api.example.com']);

    $service = new class('key', 'secret', 'https://api.example.com') extends SubscriptionsService {
        public function setClient(Client $client): void { $this->client = $client; }
    };
    $service->setClient($client);

    $headers = new SubscriptionHeadersData('shopper-id-123');
    
    $result = $service->getProductGroups($headers);
    expect($result)->toBe([
        ['productGroupKey' => 'domains', 'name' => 'Domain Names'],
        ['productGroupKey' => 'hosting', 'name' => 'Web Hosting'],
    ]);
}); 
