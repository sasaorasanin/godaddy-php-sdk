<?php

use GoDaddy\Services\Domains\v1\DomainsService;
use GoDaddy\Services\Domains\v1\DTO\ListDomainsQueryData;
use GoDaddy\Services\Domains\v1\DTO\GetAgreementsQueryData;
use GoDaddy\Services\Domains\v1\DTO\CheckDomainAvailabilityQueryData;
use GoDaddy\Services\Domains\v1\DTO\CheckDomainsAvailabilityData;
use GoDaddy\Services\Domains\v1\DTO\ValidateContactsData;
use GoDaddy\Services\Domains\v1\DTO\PurchaseDomainData;
use GoDaddy\Services\Domains\v1\DTO\PurchaseSchemaData;
use GoDaddy\Services\Domains\v1\DTO\ValidatePurchaseData;
use GoDaddy\Services\Domains\v1\DTO\SuggestDomainsQueryData;
use GoDaddy\Services\Domains\v1\DTO\SuggestedDomainData;
use GoDaddy\Services\Domains\v1\DTO\TldData;
use GoDaddy\Services\Domains\v1\DTO\DomainDetailsData;
use GoDaddy\Services\Domains\v1\DTO\UpdateDomainData;
use GoDaddy\Services\Domains\v1\DTO\UpdateDomainContactsData;
use GoDaddy\Services\Domains\v1\DTO\ContactData;
use GoDaddy\Services\Domains\v1\DTO\ContactAddressData;
use GoDaddy\Services\Domains\v1\DTO\ConsentData;
use GoDaddy\Services\Domains\v1\DTO\PurchasePrivacyData;
use GoDaddy\Services\Domains\v1\DTO\PurchasePrivacyResponseData;
use GoDaddy\Services\Domains\v1\DTO\DnsRecordData;
use GoDaddy\Services\Domains\v1\DTO\GetDnsRecordsQueryData;
use GoDaddy\Services\Domains\v1\DTO\DnsRecordUpdateData;
use GoDaddy\Services\Domains\v1\DTO\RenewDomainData;
use GoDaddy\Services\Domains\v1\DTO\TransferDomainData;
use GoDaddy\Services\Domains\v1\Enums\DomainStatus;
use GoDaddy\Services\Domains\v1\Enums\DomainStatusGroup;
use GoDaddy\Services\Domains\v1\Enums\DomainInclude;
use GoDaddy\Services\Domains\v1\Enums\CheckType;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsListException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsAgreementsException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsAvailabilityException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsContactValidationException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsPurchaseException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsPurchaseSchemaException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsPurchaseValidationException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsSuggestException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsTldsException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsCancelException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsDetailsException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsUpdateException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsContactsUpdateException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsPrivacyCancelException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsPrivacyPurchaseException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsRecordsAddException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsRecordsReplaceException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsRecordsGetException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsRecordsUpdateException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsRecordsDeleteException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsRecordsReplaceByTypeException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsRenewException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsTransferException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsVerifyRegistrantEmailException;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;

beforeEach(function () {
    $this->mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($this->mockHandler);
    $this->client = new Client(['handler' => $handlerStack, 'base_uri' => 'https://api.example.com']);
    
    $this->service = new class('test-api-key', 'test-api-secret', 'https://api.test.com') extends DomainsService {
        public function setClient(\GuzzleHttp\Client $client): void { $this->client = $client; }
    };
    $this->service->setClient($this->client);
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
        statusGroups: [DomainStatusGroup::VISIBLE],
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
        privacy: true
    );

    $result = $this->service->getAgreements('en-US', $queryData);

    expect($result)->toBe($expectedResponse);
});

test('getAgreements throws exception on error', function () {
    $this->mockHandler->append(
        new RequestException('Error', new Request('GET', '/v1/domains/agreements'))
    );

    $queryData = new GetAgreementsQueryData(
        tlds: ['com'],
        privacy: true
    );

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
        postalCode: '10001',
        address2: null
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
        postalCode: '10001',
        address2: null
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
        domain: 'example.com',
        consent: $consentData,
        contactRegistrant: $contactData,
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

test('getPurchaseSchema returns schema successfully', function () {
    $expectedResponse = [
        'id' => 'com-domain-schema',
        'models' => [
            'contact' => [
                'type' => 'object',
                'properties' => [
                    'nameFirst' => ['type' => 'string'],
                    'nameLast' => ['type' => 'string'],
                    'email' => ['type' => 'string']
                ]
            ]
        ],
        'properties' => [
            'domain' => ['type' => 'string'],
            'period' => ['type' => 'integer']
        ],
        'required' => ['domain', 'contact']
    ];

    $this->mockHandler->append(
        new Response(200, [], json_encode($expectedResponse))
    );

    $result = $this->service->getPurchaseSchema('com');

    expect($result)->toBeInstanceOf(PurchaseSchemaData::class);
    expect($result->id)->toBe('com-domain-schema');
    expect($result->models)->toBe($expectedResponse['models']);
    expect($result->properties)->toBe($expectedResponse['properties']);
    expect($result->required)->toBe($expectedResponse['required']);
});

test('getPurchaseSchema throws exception on error', function () {
    $this->mockHandler->append(
        new RequestException('Error', new Request('GET', '/v1/domains/purchase/schema/com'))
    );

    expect(fn() => $this->service->getPurchaseSchema('com'))
        ->toThrow(DomainsPurchaseSchemaException::class, 'Failed to get purchase schema: Error');
});

test('validatePurchase returns validation results successfully', function () {
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
        postalCode: '10001',
        address2: null
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

    $validateData = new ValidatePurchaseData(
        domain: 'example.com',
        consent: $consentData,
        contactRegistrant: $contactData
    );

    $result = $this->service->validatePurchase($validateData);

    expect($result)->toBe($expectedResponse);
});

test('validatePurchase throws exception on error', function () {
    $this->mockHandler->append(
        new RequestException('Error', new Request('POST', '/v1/domains/purchase/validate'))
    );

    $validateData = new ValidatePurchaseData(domain: 'example.com');

    expect(fn() => $this->service->validatePurchase($validateData))
        ->toThrow(DomainsPurchaseValidationException::class, 'Failed to validate purchase data: Error');
});

test('suggestDomains returns suggestions successfully', function () {
    $expectedResponse = [
        ['domain' => 'example.com'],
        ['domain' => 'example.net'],
        ['domain' => 'example.org']
    ];

    $this->mockHandler->append(
        new Response(200, [], json_encode($expectedResponse))
    );

    $queryData = new SuggestDomainsQueryData(
        query: 'example',
        country: 'US',
        sources: ['EXTENSION', 'KEYWORD_SPIN'],
        limit: 10
    );

    $result = $this->service->suggestDomains('test-shopper-id', $queryData);

    expect($result)->toHaveCount(3);
    expect($result[0])->toBeInstanceOf(SuggestedDomainData::class);
    expect($result[0]->domain)->toBe('example.com');
    expect($result[1]->domain)->toBe('example.net');
    expect($result[2]->domain)->toBe('example.org');
});

test('suggestDomains throws exception on error', function () {
    $this->mockHandler->append(
        new RequestException('Error', new Request('GET', '/v1/domains/suggest'))
    );

    $queryData = new SuggestDomainsQueryData(query: 'example');

    expect(fn() => $this->service->suggestDomains('test-shopper-id', $queryData))
        ->toThrow(DomainsSuggestException::class, 'Failed to suggest domains: Error');
});

test('getTlds returns TLDs successfully', function () {
    $expectedResponse = [
        ['name' => 'com', 'type' => 'GENERIC'],
        ['name' => 'net', 'type' => 'GENERIC'],
        ['name' => 'org', 'type' => 'GENERIC'],
        ['name' => 'us', 'type' => 'COUNTRY']
    ];

    $this->mockHandler->append(
        new Response(200, [], json_encode($expectedResponse))
    );

    $result = $this->service->getTlds();

    expect($result)->toHaveCount(4);
    expect($result[0])->toBeInstanceOf(TldData::class);
    expect($result[0]->name)->toBe('com');
    expect($result[0]->type)->toBe('GENERIC');
    expect($result[1]->name)->toBe('net');
    expect($result[1]->type)->toBe('GENERIC');
    expect($result[3]->name)->toBe('us');
    expect($result[3]->type)->toBe('COUNTRY');
});

test('getTlds throws exception on error', function () {
    $this->mockHandler->append(
        new RequestException('Error', new Request('GET', '/v1/domains/tlds'))
    );

    expect(fn() => $this->service->getTlds())
        ->toThrow(DomainsTldsException::class, 'Failed to get TLDs: Error');
});

test('cancelDomain cancels domain successfully', function () {
    $this->mockHandler->append(
        new Response(200)
    );

    $this->service->cancelDomain('example.com');

    // Test passes if no exception is thrown
    expect(true)->toBeTrue();
});

test('cancelDomain throws exception on error', function () {
    $this->mockHandler->append(
        new RequestException('Error', new Request('DELETE', '/v1/domains/example.com'))
    );

    expect(fn() => $this->service->cancelDomain('example.com'))
        ->toThrow(DomainsCancelException::class, 'Failed to cancel domain: Error');
});

test('getDomainDetails returns domain details successfully', function () {
    $expectedResponse = [
        'domain' => 'example.com',
        'domainId' => 12345,
        'expirationProtected' => true,
        'exposeRegistrantOrganization' => false,
        'exposeWhois' => true,
        'holdRegistrar' => false,
        'locked' => true,
        'privacy' => true,
        'renewAuto' => true,
        'status' => 'ACTIVE',
        'transferProtected' => false,
        'createdAt' => '2024-01-01T00:00:00Z',
        'expires' => '2025-01-01T00:00:00Z',
        'nameServers' => ['ns1.example.com', 'ns2.example.com'],
        'verifications' => [
            'domainName' => ['status' => 'APPROVED'],
            'realName' => ['status' => 'APPROVED']
        ]
    ];

    $this->mockHandler->append(
        new Response(200, [], json_encode($expectedResponse))
    );

    $result = $this->service->getDomainDetails('test-shopper-id', 'example.com');

    expect($result)->toBeInstanceOf(DomainDetailsData::class);
    expect($result->domain)->toBe('example.com');
    expect($result->domainId)->toBe(12345);
    expect($result->status)->toBe('ACTIVE');
    expect($result->nameServers)->toBe(['ns1.example.com', 'ns2.example.com']);
    expect($result->verifications)->toBe([
        'domainName' => ['status' => 'APPROVED'],
        'realName' => ['status' => 'APPROVED']
    ]);
});

test('getDomainDetails throws exception on error', function () {
    $this->mockHandler->append(
        new RequestException('Error', new Request('GET', '/v1/domains/example.com'))
    );

    expect(fn() => $this->service->getDomainDetails('test-shopper-id', 'example.com'))
        ->toThrow(DomainsDetailsException::class, 'Failed to get domain details: Error');
});

test('updateDomain updates domain successfully', function () {
    $this->mockHandler->append(
        new Response(200)
    );

    $consentData = new ConsentData(
        agreedAt: '2024-01-01T00:00:00Z',
        agreedBy: '192.168.1.1',
        agreementKeys: ['EXPOSE_REGISTRANT_ORGANIZATION']
    );

    $updateData = new UpdateDomainData(
        locked: true,
        nameServers: ['ns1.example.com', 'ns2.example.com'],
        renewAuto: true,
        exposeRegistrantOrganization: true,
        consent: $consentData
    );

    $this->service->updateDomain('example.com', $updateData, 'test-shopper-id');

    // Test passes if no exception is thrown
    expect(true)->toBeTrue();
});

test('updateDomain throws exception on error', function () {
    $this->mockHandler->append(
        new RequestException('Error', new Request('PATCH', '/v1/domains/example.com'))
    );

    $updateData = new UpdateDomainData(locked: true);

    expect(fn() => $this->service->updateDomain('example.com', $updateData))
        ->toThrow(DomainsUpdateException::class, 'Failed to update domain: Error');
});

test('updateDomainContacts updates domain contacts successfully', function () {
    $this->mockHandler->append(
        new Response(204)
    );

    $addressData = new ContactAddressData(
        address1: '123 Main St',
        city: 'New York',
        country: 'US',
        postalCode: '10001',
        address2: null
    );

    $contactData = new ContactData(
        addressMailing: $addressData,
        email: 'john@example.com',
        nameFirst: 'John',
        nameLast: 'Doe'
    );

    $updateContactsData = new UpdateDomainContactsData(
        contactAdmin: $contactData,
        contactRegistrant: $contactData
    );

    $this->service->updateDomainContacts('example.com', $updateContactsData, 'test-shopper-id');

    // Test passes if no exception is thrown
    expect(true)->toBeTrue();
});

test('updateDomainContacts throws exception on error', function () {
    $this->mockHandler->append(
        new RequestException('Error', new Request('PATCH', '/v1/domains/example.com/contacts'))
    );

    $updateContactsData = new UpdateDomainContactsData();

    expect(fn() => $this->service->updateDomainContacts('example.com', $updateContactsData))
        ->toThrow(DomainsContactsUpdateException::class, 'Failed to update domain contacts: Error');
});

test('cancelDomainPrivacy cancels domain privacy successfully', function () {
    $this->mockHandler->append(
        new Response(200)
    );

    $this->service->cancelDomainPrivacy('example.com', 'test-shopper-id');

    // Test passes if no exception is thrown
    expect(true)->toBeTrue();
});

test('cancelDomainPrivacy throws exception on error', function () {
    $this->mockHandler->append(
        new RequestException('Error', new Request('DELETE', '/v1/domains/example.com/privacy'))
    );

    expect(fn() => $this->service->cancelDomainPrivacy('example.com'))
        ->toThrow(DomainsPrivacyCancelException::class, 'Failed to cancel domain privacy: Error');
});

test('purchaseDomainPrivacy purchases privacy successfully', function () {
    $responseData = [
        'currency' => 'USD',
        'itemCount' => 1,
        'orderId' => 12345,
        'total' => 999
    ];
    
    $this->mockHandler->append(
        new Response(200, [], json_encode($responseData))
    );

    $purchasePrivacyData = new PurchasePrivacyData();
    $result = $this->service->purchaseDomainPrivacy('example.com', $purchasePrivacyData, 'test-shopper-id');

    expect($result)->toBeInstanceOf(PurchasePrivacyResponseData::class);
    expect($result->currency)->toBe('USD');
    expect($result->itemCount)->toBe(1);
    expect($result->orderId)->toBe(12345);
    expect($result->total)->toBe(999);
});

test('purchaseDomainPrivacy throws exception on error', function () {
    $this->mockHandler->append(
        new RequestException('Error', new Request('POST', '/v1/domains/example.com/privacy/purchase'))
    );

    $purchasePrivacyData = new PurchasePrivacyData();

    expect(fn() => $this->service->purchaseDomainPrivacy('example.com', $purchasePrivacyData))
        ->toThrow(DomainsPrivacyPurchaseException::class, 'Failed to purchase domain privacy: Error');
});

test('addDomainRecords adds records successfully', function () {
    $this->mockHandler->append(
        new Response(200)
    );

    $records = [
        new DnsRecordData(
            data: '192.168.1.1',
            name: '@',
            type: 'A',
            ttl: 3600
        ),
        new DnsRecordData(
            data: 'mail.example.com',
            name: '@',
            type: 'MX',
            priority: 10,
            ttl: 3600
        )
    ];

    $this->service->addDomainRecords('example.com', $records, 'test-shopper-id');

    // Test passes if no exception is thrown
    expect(true)->toBeTrue();
});

test('addDomainRecords throws exception on error', function () {
    $this->mockHandler->append(
        new RequestException('Error', new Request('PATCH', '/v1/domains/example.com/records'))
    );

    $records = [
        new DnsRecordData(
            data: '192.168.1.1',
            name: '@',
            type: 'A'
        )
    ];

    expect(fn() => $this->service->addDomainRecords('example.com', $records))
        ->toThrow(DomainsRecordsAddException::class, 'Failed to add domain records: Error');
});

test('replaceDomainRecords replaces records successfully', function () {
    $this->mockHandler->append(
        new Response(200)
    );

    $records = [
        new DnsRecordData(
            data: '192.168.1.1',
            name: '@',
            type: 'A',
            ttl: 3600
        ),
        new DnsRecordData(
            data: 'mail.example.com',
            name: '@',
            type: 'MX',
            priority: 10,
            ttl: 3600
        )
    ];

    $this->service->replaceDomainRecords('example.com', $records, 'test-shopper-id');

    // Test passes if no exception is thrown
    expect(true)->toBeTrue();
});

test('replaceDomainRecords throws exception on error', function () {
    $this->mockHandler->append(
        new RequestException('Error', new Request('PUT', '/v1/domains/example.com/records'))
    );

    $records = [
        new DnsRecordData(
            data: '192.168.1.1',
            name: '@',
            type: 'A'
        )
    ];

    expect(fn() => $this->service->replaceDomainRecords('example.com', $records))
        ->toThrow(DomainsRecordsReplaceException::class, 'Failed to replace domain records: Error');
});

test('getDomainRecords returns records successfully', function () {
    $responseData = [
        [
            'data' => '192.168.1.1',
            'name' => '@',
            'type' => 'A',
            'ttl' => 3600
        ],
        [
            'data' => '192.168.1.2',
            'name' => '@',
            'type' => 'A',
            'ttl' => 3600
        ]
    ];
    
    $this->mockHandler->append(
        new Response(200, [], json_encode($responseData))
    );

    $queryData = new GetDnsRecordsQueryData(
        offset: 0,
        limit: 10
    );
    
    $result = $this->service->getDomainRecords('example.com', 'A', '@', $queryData, 'test-shopper-id');

    expect($result)->toHaveCount(2);
    expect($result[0])->toBeInstanceOf(DnsRecordData::class);
    expect($result[0]->data)->toBe('192.168.1.1');
    expect($result[0]->name)->toBe('@');
    expect($result[0]->type)->toBe('A');
    expect($result[0]->ttl)->toBe(3600);
    expect($result[1]->data)->toBe('192.168.1.2');
});

test('getDomainRecords throws exception on error', function () {
    $this->mockHandler->append(
        new RequestException('Error', new Request('GET', '/v1/domains/example.com/records/A/@'))
    );

    expect(fn() => $this->service->getDomainRecords('example.com', 'A', '@'))
        ->toThrow(DomainsRecordsGetException::class, 'Failed to get domain records: Error');
});

test('updateDomainRecords updates records successfully', function () {
    $this->mockHandler->append(
        new Response(200)
    );

    $records = [
        new DnsRecordUpdateData(
            data: '192.168.1.1',
            ttl: 3600
        ),
        new DnsRecordUpdateData(
            data: '192.168.1.2',
            ttl: 3600
        )
    ];

    $this->service->updateDomainRecords('example.com', 'A', '@', $records, 'test-shopper-id');

    // Test passes if no exception is thrown
    expect(true)->toBeTrue();
});

test('updateDomainRecords throws exception on error', function () {
    $this->mockHandler->append(
        new RequestException('Error', new Request('PUT', '/v1/domains/example.com/records/A/@'))
    );

    $records = [
        new DnsRecordUpdateData(
            data: '192.168.1.1'
        )
    ];

    expect(fn() => $this->service->updateDomainRecords('example.com', 'A', '@', $records))
        ->toThrow(DomainsRecordsUpdateException::class, 'Failed to update domain records: Error');
});

test('deleteDomainRecords deletes records successfully', function () {
    $this->mockHandler->append(
        new Response(204)
    );

    $this->service->deleteDomainRecords('example.com', 'A', '@', 'test-shopper-id');

    // Test passes if no exception is thrown
    expect(true)->toBeTrue();
});

test('deleteDomainRecords throws exception on error', function () {
    $this->mockHandler->append(
        new RequestException('Error', new Request('DELETE', '/v1/domains/example.com/records/A/@'))
    );

    expect(fn() => $this->service->deleteDomainRecords('example.com', 'A', '@'))
        ->toThrow(DomainsRecordsDeleteException::class, 'Failed to delete domain records: Error');
});

test('replaceDomainRecordsByType replaces records successfully', function () {
    $this->mockHandler->append(
        new Response(200)
    );

    $records = [
        new DnsRecordData(
            data: '192.168.1.1',
            name: '@',
            type: 'A',
            ttl: 3600
        ),
        new DnsRecordData(
            data: '192.168.1.2',
            name: 'www',
            type: 'A',
            ttl: 3600
        )
    ];

    $this->service->replaceDomainRecordsByType('example.com', 'A', $records, 'test-shopper-id');

    // Test passes if no exception is thrown
    expect(true)->toBeTrue();
});

test('replaceDomainRecordsByType throws exception on error', function () {
    $this->mockHandler->append(
        new RequestException('Error', new Request('PUT', '/v1/domains/example.com/records/A'))
    );

    $records = [
        new DnsRecordData(
            data: '192.168.1.1',
            name: '@',
            type: 'A'
        )
    ];

    expect(fn() => $this->service->replaceDomainRecordsByType('example.com', 'A', $records))
        ->toThrow(DomainsRecordsReplaceByTypeException::class, 'Failed to replace domain records by type: Error');
});

test('renewDomain renews domain successfully', function () {
    $responseData = [
        'currency' => 'USD',
        'itemCount' => 1,
        'orderId' => 12345,
        'total' => 999
    ];
    
    $this->mockHandler->append(
        new Response(200, [], json_encode($responseData))
    );

    $renewData = new RenewDomainData(
        period: 5
    );
    
    $result = $this->service->renewDomain('example.com', $renewData, 'test-shopper-id');

    expect($result)->toMatchArray($responseData);
});

test('renewDomain throws exception on error', function () {
    $this->mockHandler->append(
        new RequestException('Error', new Request('POST', '/v1/domains/example.com/renew'))
    );

    expect(fn() => $this->service->renewDomain('example.com'))
        ->toThrow(DomainsRenewException::class, 'Failed to renew domain: Error');
});

test('transferDomain transfers domain successfully', function () {
    $responseData = [
        'currency' => 'USD',
        'itemCount' => 1,
        'orderId' => 12345,
        'total' => 999
    ];
    
    $this->mockHandler->append(
        new Response(200, [], json_encode($responseData))
    );

    $transferData = new TransferDomainData(
        authCode: 'ABC123',
        period: 2,
        privacy: true,
        renewAuto: false
    );
    
    $result = $this->service->transferDomain('example.com', $transferData, 'test-shopper-id');

    expect($result)->toMatchArray($responseData);
});

test('transferDomain throws exception on error', function () {
    $this->mockHandler->append(
        new RequestException('Error', new Request('POST', '/v1/domains/example.com/transfer'))
    );

    $transferData = new TransferDomainData(
        authCode: 'ABC123'
    );

    expect(fn() => $this->service->transferDomain('example.com', $transferData))
        ->toThrow(DomainsTransferException::class, 'Failed to transfer domain: Error');
});

test('verifyRegistrantEmail verifies email successfully', function () {
    $this->mockHandler->append(new Response(200));
    
    $this->service->verifyRegistrantEmail('example.com', 'test-shopper-id');
    
    expect(true)->toBeTrue();
});

test('verifyRegistrantEmail throws exception on error', function () {
    $this->mockHandler->append(
        new RequestException('Error', new Request('POST', '/v1/domains/example.com/verifyRegistrantEmail'))
    );

    expect(fn() => $this->service->verifyRegistrantEmail('example.com'))
        ->toThrow(DomainsVerifyRegistrantEmailException::class, 'Failed to verify registrant email: Error');
}); 
