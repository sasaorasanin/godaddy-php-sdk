<?php

use GoDaddy\Services\Abuse\v1\AbuseService;
use GoDaddy\Services\Abuse\v1\DTO\CreateAbuseTicketData;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Client;


test('AbuseService can create an abuse ticket', function () {
    $mock = new MockHandler([
        new Response(200, [], json_encode(['ticketId' => 'abc123', 'status' => 'created'])),
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack, 'base_uri' => 'https://api.example.com']);

    $service = new class('key', 'secret', 'https://api.example.com') extends AbuseService {
        public function setClient(\GuzzleHttp\Client $client): void { $this->client = $client; }
    };
    $service->setClient($client);

    $data = new CreateAbuseTicketData(
        'info value',
        'https://info.url',
        'source value',
        'target value',
        'type value',
        'proxy value',
        'useragent value'
    );

    $result = $service->createTicket($data);
    expect($result)->toBe(['ticketId' => 'abc123', 'status' => 'created']);
});

test('AbuseService can list abuse tickets', function () {
    $mock = new MockHandler([
        new Response(200, [], json_encode([
            ['ticketId' => 'abc123', 'status' => 'open'],
            ['ticketId' => 'def456', 'status' => 'closed'],
        ])),
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack, 'base_uri' => 'https://api.example.com']);

    $service = new class('key', 'secret', 'https://api.example.com') extends AbuseService {
        public function setClient(\GuzzleHttp\Client $client): void { $this->client = $client; }
    };
    $service->setClient($client);

    $filter = new GoDaddy\Services\Abuse\v1\DTO\ListAbuseTicketsFilter(type: 'phishing');
    $result = $service->listTickets($filter);
    expect($result)->toBe([
        ['ticketId' => 'abc123', 'status' => 'open'],
        ['ticketId' => 'def456', 'status' => 'closed'],
    ]);
});

test('AbuseService can get a specific abuse ticket', function () {
    $mock = new MockHandler([
        new Response(200, [], json_encode(['ticketId' => 'abc123', 'status' => 'open'])),
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack, 'base_uri' => 'https://api.example.com']);

    $service = new class('key', 'secret', 'https://api.example.com') extends AbuseService {
        public function setClient(\GuzzleHttp\Client $client): void { $this->client = $client; }
    };
    $service->setClient($client);

    $ticketData = new GoDaddy\Services\Abuse\v1\DTO\GetAbuseTicketData('abc123');
    $result = $service->getTicket($ticketData);
    expect($result)->toBe(['ticketId' => 'abc123', 'status' => 'open']);
});
