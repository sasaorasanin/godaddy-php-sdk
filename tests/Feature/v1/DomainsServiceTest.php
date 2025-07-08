<?php

use GoDaddy\Services\Domains\v1\DomainsService;
use GoDaddy\Services\Domains\v1\DTO\ListDomainsQueryData;
use GoDaddy\Services\Domains\v1\DTO\GetAgreementsQueryData;
use GoDaddy\Services\Domains\v1\DTO\CheckDomainAvailabilityQueryData;
use GoDaddy\Services\Domains\v1\DTO\CheckDomainsAvailabilityData;
use GoDaddy\Services\Domains\v1\DTO\ValidateContactsData;
use GoDaddy\Services\Domains\v1\DTO\PurchaseDomainData;
use GoDaddy\Services\Domains\v1\DTO\ContactData;
use GoDaddy\Services\Domains\v1\DTO\ContactAddressData;
use GoDaddy\Services\Domains\v1\DTO\ConsentData;
use GoDaddy\Services\Domains\v1\Enums\DomainStatus;
use GoDaddy\Services\Domains\v1\Enums\DomainStatusGroup;
use GoDaddy\Services\Domains\v1\Enums\DomainInclude;
use GoDaddy\Services\Domains\v1\Enums\CheckType;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsListException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsAgreementsException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsAvailabilityException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsContactValidationException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsPurchaseException;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;

beforeEach(function () {
    $this->mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($this->mockHandler);
    $this->client = new Client(['handler' => $handlerStack]);
    $this->service = new DomainsService($this->client);
});

test('listDomains returns domains successfully', function () {
    $expectedResponse = [
        'domains' => [
            [
                'domain' => 'example.com',
                'status' => 'ACTIVE'
            ]
        ]
    ];

    $this->mockHandler->append(
        new Response(200, [], json_encode($expectedResponse))
    );

    $queryData = new ListDomainsQueryData(
        statuses: [DomainStatus::ACTIVE],
        statusGroups: [DomainStatusGroup::ACTIVE],
        includes: [DomainInclude::CONTACTS]
    );

    $result = $this->service->listDomains('test-shopper-id', $queryData);

    expect($result)->toBe($expectedResponse);
});

test('listDomains throws exception on error', function () {
    $this->mockHandler->append(
        new RequestException('Error', new Request('GET', '/v1/domains'))
    );

    expect(fn() => $this->service->listDomains('test-shopper-id'))
        ->toThrow(DomainsListException::class, 'Failed to list domains: Error');
});

test('getAgreements returns agreements successfully', function () {
    $expectedResponse = [
        'agreements' => [
            [
                'agreementKey' => 'DNRA',
                'title' => 'Domain Name Registration Agreement'
            ]
        ]
    ];

    $this->mockHandler->append(
        new Response(200, [], json_encode($expectedResponse))
    );

    $queryData = new GetAgreementsQueryData(
        tlds: ['com'],
        privacy: true,
        forTransfer: false
    );

    $result = $this->service->getAgreements('en-US', $queryData);

    expect($result)->toBe($expectedResponse);
});

test('getAgreements throws exception on error', function () {
    $this->mockHandler->append(
        new RequestException('Error', new Request('GET', '/v1/domains/agreements'))
    );

    $queryData = new GetAgreementsQueryData(tlds: ['com']);

    expect(fn() => $this->service->getAgreements('en-US', $queryData))
        ->toThrow(DomainsAgreementsException::class, 'Failed to get domain agreements: Error');
});

test('checkDomainAvailability returns availability successfully', function () {
    $expectedResponse = [
        'available' => true,
        'currency' => 'USD',
        'definitive' => true,
        'domain' => 'example.com',
        'period' => 1,
        'price' => 11990000
    ];

    $this->mockHandler->append(
        new Response(200, [], json_encode($expectedResponse))
    );

    $queryData = new CheckDomainAvailabilityQueryData(
        domain: 'example.com',
        checkType: CheckType::FULL,
        forTransfer: false
    );

    $result = $this->service->checkDomainAvailability($queryData);

    expect($result)->toBe($expectedResponse);
});

test('checkDomainAvailability throws exception on error', function () {
    $this->mockHandler->append(
        new RequestException('Error', new Request('GET', '/v1/domains/available'))
    );

    $queryData = new CheckDomainAvailabilityQueryData(domain: 'example.com');

    expect(fn() => $this->service->checkDomainAvailability($queryData))
        ->toThrow(DomainsAvailabilityException::class, 'Failed to check domain availability: Error');
});

test('checkDomainsAvailability returns availability successfully', function () {
    $expectedResponse = [
        'domains' => [
            [
                'available' => true,
                'currency' => 'USD',
                'definitive' => true,
                'domain' => 'example.com',
                'period' => 1,
                'price' => 11990000
            ]
        ]
    ];

    $this->mockHandler->append(
        new Response(200, [], json_encode($expectedResponse))
    );

    $data = new CheckDomainsAvailabilityData(
        domains: ['example.com'],
        checkType: CheckType::FULL
    );

    $result = $this->service->checkDomainsAvailability($data);

    expect($result)->toBe($expectedResponse);
});

test('checkDomainsAvailability throws exception on error', function () {
    $this->mockHandler->append(
        new RequestException('Error', new Request('POST', '/v1/domains/available'))
    );

    $data = new CheckDomainsAvailabilityData(domains: ['example.com']);

    expect(fn() => $this->service->checkDomainsAvailability($data))
        ->toThrow(DomainsAvailabilityException::class, 'Failed to check domains availability: Error');
});

test('validateContacts returns validation results successfully', function () {
    $expectedResponse = [
        'valid' => true,
        'errors' => []
    ];

    $this->mockHandler->append(
        new Response(200, [], json_encode($expectedResponse))
    );

    $addressData = new ContactAddressData(
        address1: '123 Main St',
        city: 'New York',
        country: 'US',
        postalCode: '10001'
    );

    $contactData = new ContactData(
        addressMailing: $addressData,
        email: 'john@example.com',
        nameFirst: 'John',
        nameLast: 'Doe'
    );

    $validateData = new ValidateContactsData(
        contactRegistrant: $contactData,
        domains: ['example.com']
    );

    $result = $this->service->validateContacts($validateData, 'en-US', 1);

    expect($result)->toBe($expectedResponse);
});

test('validateContacts throws exception on error', function () {
    $this->mockHandler->append(
        new RequestException('Error', new Request('POST', '/v1/domains/contacts/validate'))
    );

    $validateData = new ValidateContactsData(domains: ['example.com']);

    expect(fn() => $this->service->validateContacts($validateData))
        ->toThrow(DomainsContactValidationException::class, 'Failed to validate domain contacts: Error');
});

test('purchaseDomain returns purchase result successfully', function () {
    $expectedResponse = [
        'orderId' => 12345,
        'itemCount' => 1,
        'total' => 11990000,
        'currency' => 'USD'
    ];

    $this->mockHandler->append(
        new Response(200, [], json_encode($expectedResponse))
    );

    $addressData = new ContactAddressData(
        address1: '123 Main St',
        city: 'New York',
        country: 'US',
        postalCode: '10001'
    );

    $contactData = new ContactData(
        addressMailing: $addressData,
        email: 'john@example.com',
        nameFirst: 'John',
        nameLast: 'Doe'
    );

    $consentData = new ConsentData(
        agreedAt: '2024-01-01T00:00:00Z',
        agreedBy: '192.168.1.1',
        agreementKeys: ['DNRA', 'ICANN']
    );

    $purchaseData = new PurchaseDomainData(
        consent: $consentData,
        contactRegistrant: $contactData,
        domain: 'example.com',
        period: 1
    );

    $result = $this->service->purchaseDomain('test-shopper-id', $purchaseData);

    expect($result)->toBe($expectedResponse);
});

test('purchaseDomain throws exception on error', function () {
    $this->mockHandler->append(
        new RequestException('Error', new Request('POST', '/v1/domains/purchase'))
    );

    $purchaseData = new PurchaseDomainData(domain: 'example.com');

    expect(fn() => $this->service->purchaseDomain('test-shopper-id', $purchaseData))
        ->toThrow(DomainsPurchaseException::class, 'Failed to purchase domain: Error');
}); 