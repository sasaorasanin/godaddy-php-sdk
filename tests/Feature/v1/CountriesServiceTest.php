<?php

use GoDaddy\Services\Countries\v1\CountriesService;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Client;

test('CountriesService can get all countries', function () {
    $mock = new MockHandler([
        new Response(200, [], json_encode([
            ['countryKey' => 'US', 'name' => 'United States'],
            ['countryKey' => 'CA', 'name' => 'Canada'],
            ['countryKey' => 'GB', 'name' => 'United Kingdom'],
        ])),
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack, 'base_uri' => 'https://api.example.com']);

    $service = new class('key', 'secret', 'https://api.example.com') extends CountriesService {
        public function setClient($client) { $this->client = $client; }
    };
    $service->setClient($client);

    $result = $service->getAll('US');
    expect($result)->toBe([
        ['countryKey' => 'US', 'name' => 'United States'],
        ['countryKey' => 'CA', 'name' => 'Canada'],
        ['countryKey' => 'GB', 'name' => 'United Kingdom'],
    ]);
});

test('CountriesService can get specific country by key', function () {
    $mock = new MockHandler([
        new Response(200, [], json_encode([
            'countryKey' => 'US',
            'name' => 'United States',
            'currency' => 'USD',
            'phoneCode' => '1'
        ])),
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack, 'base_uri' => 'https://api.example.com']);

    $service = new class('key', 'secret', 'https://api.example.com') extends CountriesService {
        public function setClient($client) { $this->client = $client; }
    };
    $service->setClient($client);

    $result = $service->getByKey('US', 'US');
    expect($result)->toBe([
        'countryKey' => 'US',
        'name' => 'United States',
        'currency' => 'USD',
        'phoneCode' => '1'
    ]);
}); 