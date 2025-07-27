<?php

use GoDaddy\Services\Certificates\v1\CertificatesService;
use GoDaddy\Services\Certificates\v1\DTO\CertificateCreateData;
use GoDaddy\Services\Certificates\v1\DTO\CertificateReissueData;
use GoDaddy\Services\Certificates\v1\DTO\CertificateRenewData;
use GoDaddy\Services\Certificates\v1\DTO\CertificateRevokeData;
use GoDaddy\Services\Certificates\v1\DTO\AddressData;
use GoDaddy\Services\Certificates\v1\DTO\ContactData;
use GoDaddy\Services\Certificates\v1\DTO\OrganizationData;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Client;

test('CertificatesService can create a certificate', function () {
    $mock = new MockHandler([
        new Response(200, [], json_encode(['certificateId' => 'cert123', 'status' => 'pending'])),
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack, 'base_uri' => 'https://api.example.com']);

    $service = new class('key', 'secret', 'https://api.example.com') extends CertificatesService {
        public function setClient(Client $client): void { $this->client = $client; }
    };
    $service->setClient($client);

    $contactData = new ContactData(
        'John Doe',
        'john@example.com',
        '123456789',
        '123 Main St',
        'City',
        'State',
        '12345',
        'US'
    );

    $addressData = new AddressData(
        '123 Main St',
        '',
        'City',
        'US',
        '12345',
        'State'
    );

    $orgData = new OrganizationData(
        $addressData,
        'Example Corp',
        'Example Corporation',
        '123456789',
        'Registration Agent',
        'REG123456'
    );

    $createData = new CertificateCreateData(
        'https://callback.example.com', // callbackUrl
        'example.com', // commonName
        $contactData, // contact
        'CSR_STRING', // csr
        false, // intelVPro
        $orgData, // organization
        12, // period
        'DV', // productType
        'ROOT_TYPE', // rootType
        'SLOT_SIZE', // slotSize
        ['example.com'] // subjectAlternativeNames
    );

    $result = $service->createCertificate($createData);
    expect($result)->toBe(['certificateId' => 'cert123', 'status' => 'pending']);
});

test('CertificatesService can validate a certificate', function () {
    $mock = new MockHandler([
        new Response(200, [], json_encode(['valid' => true, 'errors' => []])),
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack, 'base_uri' => 'https://api.example.com']);

    $service = new class('key', 'secret', 'https://api.example.com') extends CertificatesService {
        public function setClient(Client $client): void { $this->client = $client; }
    };
    $service->setClient($client);

    $contactData = new ContactData(
        'John Doe',
        'john@example.com',
        '123456789',
        '123 Main St',
        'City',
        'State',
        '12345',
        'US'
    );

    $addressData = new AddressData(
        '123 Main St',
        '',
        'City',
        'US',
        '12345',
        'State'
    );

    $orgData = new OrganizationData(
        $addressData,
        'Example Corp',
        'Example Corporation',
        '123456789',
        'Registration Agent',
        'REG123456'
    );

    $createData = new CertificateCreateData(
        'https://callback.example.com',
        'example.com',
        $contactData,
        'CSR_STRING',
        false,
        $orgData,
        12,
        'DV',
        'ROOT_TYPE',
        'SLOT_SIZE',
        ['example.com']
    );

    $result = $service->validateCertificate($createData);
    expect($result)->toBe(['valid' => true, 'errors' => []]);
});

test('CertificatesService can get certificate details', function () {
    $mock = new MockHandler([
        new Response(200, [], json_encode(['certificateId' => 'cert123', 'domain' => 'example.com', 'status' => 'active'])),
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack, 'base_uri' => 'https://api.example.com']);

    $service = new class('key', 'secret', 'https://api.example.com') extends CertificatesService {
        public function setClient(Client $client): void { $this->client = $client; }
    };
    $service->setClient($client);

    $result = $service->getCertificate('cert123');
    expect($result)->toBe(['certificateId' => 'cert123', 'domain' => 'example.com', 'status' => 'active']);
});

test('CertificatesService can download a certificate', function () {
    $mock = new MockHandler([
        new Response(200, [], '-----BEGIN CERTIFICATE-----\nMII...\n-----END CERTIFICATE-----'),
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack, 'base_uri' => 'https://api.example.com']);

    $service = new class('key', 'secret', 'https://api.example.com') extends CertificatesService {
        public function setClient(Client $client): void { $this->client = $client; }
    };
    $service->setClient($client);

    $result = $service->downloadCertificate('cert123');
    expect($result)->toBe('-----BEGIN CERTIFICATE-----\nMII...\n-----END CERTIFICATE-----');
});

test('CertificatesService can reissue a certificate', function () {
    $mock = new MockHandler([
        new Response(200, [], json_encode(['certificateId' => 'cert123', 'status' => 'reissued'])),
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack, 'base_uri' => 'https://api.example.com']);

    $service = new class('key', 'secret', 'https://api.example.com') extends CertificatesService {
        public function setClient(Client $client): void { $this->client = $client; }
    };
    $service->setClient($client);

    $contactData = new ContactData(
        'John Doe',
        'john@example.com',
        '123456789',
        '123 Main St',
        'City',
        'State',
        '12345',
        'US'
    );

    $reissueData = new CertificateReissueData(
        'https://callback.example.com', // callbackUrl
        'example.com', // commonName
        'CSR_STRING', // csr
        0, // delayExistingRevoke
        'ROOT_TYPE', // rootType
        ['example.com'], // subjectAlternativeNames
        [] // forceDomainRevetting
    );

    $result = $service->reissueCertificate('cert123', $reissueData);
    expect($result)->toBe(['certificateId' => 'cert123', 'status' => 'reissued']);
});

test('CertificatesService can revoke a certificate', function () {
    $mock = new MockHandler([
        new Response(200, [], ''),
    ]);
    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack, 'base_uri' => 'https://api.example.com']);

    $service = new class('key', 'secret', 'https://api.example.com') extends CertificatesService {
        public function setClient(Client $client): void { $this->client = $client; }
    };
    $service->setClient($client);

    $revokeData = new CertificateRevokeData('Compromised');
    
    $service->revokeCertificate('cert123', $revokeData);
    expect(true)->toBeTrue();
}); 
