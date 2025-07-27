<?php

use GoDaddy\Services\Parking\v1\ParkingService;
use GoDaddy\Services\Parking\v1\DTO\ParkingMetricsQueryData;
use GoDaddy\Services\Parking\v1\DTO\MetricsByDomainQueryData;
use GoDaddy\Services\Parking\v1\DTO\ParkingHeadersData;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Client;

test('ParkingService can get parking metrics', function () {
    $mock = new MockHandler([
        new Response(200, [], json_encode([
            ['date' => '2024-01-01', 'pageViews' => 100, 'revenue' => 50.00],
            ['date' => '2024-01-02', 'pageViews' => 150, 'revenue' => 75.00],
        ])),
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack, 'base_uri' => 'https://api.example.com']);

    $service = new class('key', 'secret', 'https://api.example.com') extends ParkingService {
        public function setClient(Client $client): void { $this->client = $client; }
    };
    $service->setClient($client);

    $queryData = new ParkingMetricsQueryData(
        periodStartPtz: '2024-01-01',
        periodEndPtz: '2024-01-31'
    );
    $headers = new ParkingHeadersData('shopper-id-123');
    
    $result = $service->getMetrics('customer-id-456', $queryData, $headers);
    expect($result)->toEqual([
        ['date' => '2024-01-01', 'pageViews' => 100, 'revenue' => 50.00],
        ['date' => '2024-01-02', 'pageViews' => 150, 'revenue' => 75.00],
    ]);
});

test('ParkingService can get parking metrics by domain', function () {
    $mock = new MockHandler([
        new Response(200, [], json_encode([
            ['domain' => 'example.com', 'pageViews' => 100, 'revenue' => 50.00],
            ['domain' => 'test.com', 'pageViews' => 75, 'revenue' => 37.50],
        ])),
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack, 'base_uri' => 'https://api.example.com']);

    $service = new class('key', 'secret', 'https://api.example.com') extends ParkingService {
        public function setClient(Client $client): void { $this->client = $client; }
    };
    $service->setClient($client);

    $domainQueryData = new MetricsByDomainQueryData(
        startDate: '2024-01-01',
        endDate: '2024-01-31',
        domains: 'example.com,test.com'
    );
    $headers = new ParkingHeadersData('shopper-id-123');
    
    $result = $service->getMetricsByDomain('customer-id-456', $domainQueryData, $headers);
    expect($result)->toEqual([
        ['domain' => 'example.com', 'pageViews' => 100, 'revenue' => 50.00],
        ['domain' => 'test.com', 'pageViews' => 75, 'revenue' => 37.50],
    ]);
}); 
