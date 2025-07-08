<?php

use GoDaddy\Services\Agreements\v1\AgreementsService;
use GoDaddy\Services\Agreements\v1\DTO\GetAgreementsData;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Client;

test('AgreementsService can retrieve agreements', function () {
    $mock = new MockHandler([
        new Response(200, [], json_encode([
            ['key' => 'UNIVERSAL_TERMS', 'content' => 'Universal Terms...'],
            ['key' => 'PRIVACY_POLICY', 'content' => 'Privacy Policy...'],
        ])),
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack, 'base_uri' => 'https://api.example.com']);

    $service = new class('key', 'secret', 'https://api.example.com') extends AgreementsService {
        public function setClient($client) { $this->client = $client; }
    };
    $service->setClient($client);

    $data = new GetAgreementsData(
        keys: ['UNIVERSAL_TERMS', 'PRIVACY_POLICY'],
        privateLabelId: 1234,
        marketId: 'en-US'
    );
    $result = $service->getAgreements($data);
    expect($result)->toBe([
        ['key' => 'UNIVERSAL_TERMS', 'content' => 'Universal Terms...'],
        ['key' => 'PRIVACY_POLICY', 'content' => 'Privacy Policy...'],
    ]);
}); 