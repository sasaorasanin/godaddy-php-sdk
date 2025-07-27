<?php

namespace Tests\Feature\v2;

use GoDaddy\Services\Domains\v2\DomainsService;
use GoDaddy\Services\Domains\v2\DTO\DnssecRecordData;
use GoDaddy\Services\Domains\v2\DTO\NameServerUpdateData;
use GoDaddy\Services\Domains\v2\DTO\PrivacyForwardingData;
use GoDaddy\Services\Domains\v2\DTO\DomainRedeemData;
use GoDaddy\Services\Domains\v2\DTO\DomainRenewData;
use GoDaddy\Services\Domains\v2\DTO\DomainTransferData;
use GoDaddy\Services\Domains\v2\DTO\DomainForwardData;
use GoDaddy\Services\Domains\v2\DTO\NotificationOptInData;
use GoDaddy\Services\Domains\v2\DTO\DomainRegisterData;
use GoDaddy\Services\Domains\v2\DTO\GetDomainDetailsQueryData;
use GoDaddy\Services\Domains\v2\Enums\ActionType;
use GoDaddy\Services\Domains\v2\Exceptions\DnssecException;
use GoDaddy\Services\Domains\v2\Exceptions\NameServerException;
use GoDaddy\Services\Domains\v2\Exceptions\PrivacyForwardingException;
use GoDaddy\Services\Domains\v2\Exceptions\DomainRedeemException;
use GoDaddy\Services\Domains\v2\Exceptions\DomainRenewException;
use GoDaddy\Services\Domains\v2\Exceptions\DomainTransferException;
use GoDaddy\Services\Domains\v2\Exceptions\DomainForwardException;
use GoDaddy\Services\Domains\v2\Exceptions\DomainActionException;
use GoDaddy\Services\Domains\v2\Exceptions\NotificationException;
use GoDaddy\Services\Domains\v2\Exceptions\DomainRegisterException;
use GoDaddy\Services\Domains\v2\Exceptions\MaintenanceException;
use GoDaddy\Services\Domains\v2\Exceptions\UsageException;
use GoDaddy\Services\Domains\v2\Exceptions\DomainContactsException;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\TestCase;

class DomainsServiceTest extends TestCase
{
    private DomainsService $service;
    private MockHandler $mockHandler;

    protected function setUp(): void
    {
        $this->mockHandler = new MockHandler();
        $handlerStack = HandlerStack::create($this->mockHandler);
        $client = new Client(['handler' => $handlerStack]);
        
        $this->service = new DomainsService('test-key', 'test-secret', 'https://api.example.com');
        $this->service->setClient($client);
    }

    public function testGetDomainDetails()
    {
        $responseData = [
            'domainId' => '12345',
            'domain' => 'example.com',
            'status' => 'ACTIVE'
        ];

        $this->mockHandler->append(
            new Response(200, [], json_encode($responseData))
        );

        $queryData = new GetDomainDetailsQueryData();
        $queryData->includes = ['actions', 'contacts'];

        $result = $this->service->getDomainDetails('customer123', 'example.com', $queryData, 'request123');

        $this->assertEquals('12345', $result->domainId);
        $this->assertEquals('example.com', $result->domain);
        $this->assertEquals('ACTIVE', $result->status);
    }

    public function testCancelChangeOfRegistrant()
    {
        $this->mockHandler->append(
            new Response(202)
        );

        $this->service->cancelChangeOfRegistrant('customer123', 'example.com', 'request123');

        $this->assertTrue(true); // No exception thrown
    }

    public function testAddDnssecRecords()
    {
        $this->mockHandler->append(
            new Response(202)
        );

        $records = [
            new DnssecRecordData('8', 'digest123', '1', '12345'),
            new DnssecRecordData('13', 'digest456', '2', '67890')
        ];

        $this->service->addDnssecRecords('customer123', 'example.com', $records, 'request123');

        $this->assertTrue(true); // No exception thrown
    }

    public function testRemoveDnssecRecords()
    {
        $this->mockHandler->append(
            new Response(202)
        );

        $records = [
            new DnssecRecordData('8', 'digest123', '1', '12345')
        ];

        $this->service->removeDnssecRecords('customer123', 'example.com', $records, 'request123');

        $this->assertTrue(true); // No exception thrown
    }

    public function testUpdateNameServers()
    {
        $this->mockHandler->append(
            new Response(202)
        );

        $nameServers = ['ns1.example.com', 'ns2.example.com'];
        $data = new NameServerUpdateData($nameServers);

        $this->service->updateNameServers('customer123', 'example.com', $data, 'request123');

        $this->assertTrue(true); // No exception thrown
    }

    public function testGetPrivacyForwarding()
    {
        $responseData = [
            'email' => 'test@example.com'
        ];

        $this->mockHandler->append(
            new Response(200, [], json_encode($responseData))
        );

        $result = $this->service->getPrivacyForwarding('customer123', 'example.com', 'request123');

        $this->assertEquals('test@example.com', $result->email);
    }

    public function testUpdatePrivacyForwarding()
    {
        $this->mockHandler->append(
            new Response(200)
        );

        $data = new PrivacyForwardingData('test@example.com');

        $this->service->updatePrivacyForwarding('customer123', 'example.com', $data, 'request123');

        $this->assertTrue(true); // No exception thrown
    }

    public function testRedeemDomain()
    {
        $responseData = [
            'orderId' => '12345',
            'status' => 'PENDING'
        ];

        $this->mockHandler->append(
            new Response(200, [], json_encode($responseData))
        );

        $data = new DomainRedeemData(1);

        $result = $this->service->redeemDomain('customer123', 'example.com', $data, 'request123');

        $this->assertEquals('12345', $result['orderId']);
        $this->assertEquals('PENDING', $result['status']);
    }

    public function testRenewDomain()
    {
        $responseData = [
            'orderId' => '12345',
            'status' => 'PENDING'
        ];

        $this->mockHandler->append(
            new Response(200, [], json_encode($responseData))
        );

        $data = new DomainRenewData(1);

        $result = $this->service->renewDomain('customer123', 'example.com', $data, 'request123');

        $this->assertEquals('12345', $result['orderId']);
        $this->assertEquals('PENDING', $result['status']);
    }

    public function testTransferDomain()
    {
        $responseData = [
            'orderId' => '12345',
            'status' => 'PENDING'
        ];

        $this->mockHandler->append(
            new Response(200, [], json_encode($responseData))
        );

        $data = new DomainTransferData('auth-code-123', 'consent-data');

        $result = $this->service->transferDomain('customer123', 'example.com', $data, 'request123');

        $this->assertEquals('12345', $result['orderId']);
        $this->assertEquals('PENDING', $result['status']);
    }

    public function testValidateTransfer()
    {
        $responseData = [
            'valid' => true,
            'message' => 'Transfer is valid'
        ];

        $this->mockHandler->append(
            new Response(200, [], json_encode($responseData))
        );

        $data = new DomainTransferData('auth-code-123');

        $result = $this->service->validateTransfer('customer123', 'example.com', $data, 'request123');

        $this->assertTrue($result['valid']);
        $this->assertEquals('Transfer is valid', $result['message']);
    }

    public function testAcceptTransferIn()
    {
        $responseData = [
            'status' => 'ACCEPTED'
        ];

        $this->mockHandler->append(
            new Response(200, [], json_encode($responseData))
        );

        $result = $this->service->acceptTransferIn('customer123', 'example.com', 'request123');

        $this->assertEquals('ACCEPTED', $result['status']);
    }

    public function testCancelTransferIn()
    {
        $responseData = [
            'status' => 'CANCELLED'
        ];

        $this->mockHandler->append(
            new Response(200, [], json_encode($responseData))
        );

        $result = $this->service->cancelTransferIn('customer123', 'example.com', 'request123');

        $this->assertEquals('CANCELLED', $result['status']);
    }

    public function testRestartTransferIn()
    {
        $responseData = [
            'status' => 'RESTARTED'
        ];

        $this->mockHandler->append(
            new Response(200, [], json_encode($responseData))
        );

        $result = $this->service->restartTransferIn('customer123', 'example.com', 'request123');

        $this->assertEquals('RESTARTED', $result['status']);
    }

    public function testRetryTransferIn()
    {
        $responseData = [
            'status' => 'RETRYING'
        ];

        $this->mockHandler->append(
            new Response(200, [], json_encode($responseData))
        );

        $result = $this->service->retryTransferIn('customer123', 'example.com', 'request123');

        $this->assertEquals('RETRYING', $result['status']);
    }

    public function testTransferOut()
    {
        $responseData = [
            'status' => 'INITIATED'
        ];

        $this->mockHandler->append(
            new Response(200, [], json_encode($responseData))
        );

        $result = $this->service->transferOut('customer123', 'example.com', 'request123');

        $this->assertEquals('INITIATED', $result['status']);
    }

    public function testAcceptTransferOut()
    {
        $responseData = [
            'status' => 'ACCEPTED'
        ];

        $this->mockHandler->append(
            new Response(200, [], json_encode($responseData))
        );

        $result = $this->service->acceptTransferOut('customer123', 'example.com', 'request123');

        $this->assertEquals('ACCEPTED', $result['status']);
    }

    public function testRejectTransferOut()
    {
        $responseData = [
            'status' => 'REJECTED'
        ];

        $this->mockHandler->append(
            new Response(200, [], json_encode($responseData))
        );

        $result = $this->service->rejectTransferOut('customer123', 'example.com', 'request123');

        $this->assertEquals('REJECTED', $result['status']);
    }

    public function testGetDomainForward()
    {
        $responseData = [
            'forwardTo' => 'https://example.com',
            'mask' => true,
            'title' => 'Test Title'
        ];

        $this->mockHandler->append(
            new Response(200, [], json_encode($responseData))
        );

        $result = $this->service->getDomainForward('customer123', 'test.example.com', 'request123');

        $this->assertEquals('https://example.com', $result->forwardTo);
        $this->assertTrue($result->mask);
        $this->assertEquals('Test Title', $result->title);
    }

    public function testCreateDomainForward()
    {
        $responseData = [
            'status' => 'CREATED'
        ];

        $this->mockHandler->append(
            new Response(200, [], json_encode($responseData))
        );

        $data = new DomainForwardData('https://example.com', true, 'Test Title');

        $result = $this->service->createDomainForward('customer123', 'test.example.com', $data, 'request123');

        $this->assertEquals('CREATED', $result['status']);
    }

    public function testUpdateDomainForward()
    {
        $responseData = [
            'status' => 'UPDATED'
        ];

        $this->mockHandler->append(
            new Response(200, [], json_encode($responseData))
        );

        $data = new DomainForwardData('https://example.com', false);

        $result = $this->service->updateDomainForward('customer123', 'test.example.com', $data, 'request123');

        $this->assertEquals('UPDATED', $result['status']);
    }

    public function testDeleteDomainForward()
    {
        $this->mockHandler->append(
            new Response(200)
        );

        $this->service->deleteDomainForward('customer123', 'test.example.com', 'request123');

        $this->assertTrue(true); // No exception thrown
    }

    public function testGetDomainActions()
    {
        $responseData = [
            'actions' => [
                ['type' => 'DNSSEC_CREATE', 'status' => 'COMPLETED'],
                ['type' => 'DOMAIN_RENEW', 'status' => 'PENDING']
            ]
        ];

        $this->mockHandler->append(
            new Response(200, [], json_encode($responseData))
        );

        $result = $this->service->getDomainActions('customer123', 'example.com', 'request123');

        $this->assertCount(2, $result['actions']);
        $this->assertEquals('DNSSEC_CREATE', $result['actions'][0]['type']);
        $this->assertEquals('COMPLETED', $result['actions'][0]['status']);
    }

    public function testGetDomainAction()
    {
        $responseData = [
            'type' => 'DNSSEC_CREATE',
            'status' => 'COMPLETED',
            'createdAt' => '2023-01-01T00:00:00Z'
        ];

        $this->mockHandler->append(
            new Response(200, [], json_encode($responseData))
        );

        $result = $this->service->getDomainAction('customer123', 'example.com', ActionType::DNSSEC_CREATE, 'request123');

        $this->assertEquals('DNSSEC_CREATE', $result['type']);
        $this->assertEquals('COMPLETED', $result['status']);
    }

    public function testGetNotifications()
    {
        $responseData = [
            'notifications' => [
                ['id' => '1', 'type' => 'DOMAIN_EXPIRY', 'message' => 'Domain expiring soon'],
                ['id' => '2', 'type' => 'DOMAIN_TRANSFER', 'message' => 'Transfer completed']
            ]
        ];

        $this->mockHandler->append(
            new Response(200, [], json_encode($responseData))
        );

        $result = $this->service->getNotifications('customer123', 'request123');

        $this->assertCount(2, $result['notifications']);
        $this->assertEquals('1', $result['notifications'][0]['id']);
        $this->assertEquals('DOMAIN_EXPIRY', $result['notifications'][0]['type']);
    }

    public function testOptInNotifications()
    {
        $responseData = [
            'status' => 'OPTED_IN'
        ];

        $this->mockHandler->append(
            new Response(200, [], json_encode($responseData))
        );

        $channels = ['email', 'sms'];
        $data = new NotificationOptInData('DOMAIN_EXPIRY', $channels);

        $result = $this->service->optInNotifications('customer123', $data, 'request123');

        $this->assertEquals('OPTED_IN', $result['status']);
    }

    public function testGetNotificationSchema()
    {
        $responseData = [
            'type' => 'DOMAIN_EXPIRY',
            'channels' => ['email', 'sms'],
            'template' => 'Your domain {domain} expires on {date}'
        ];

        $this->mockHandler->append(
            new Response(200, [], json_encode($responseData))
        );

        $result = $this->service->getNotificationSchema('customer123', 'DOMAIN_EXPIRY', 'request123');

        $this->assertEquals('DOMAIN_EXPIRY', $result['type']);
        $this->assertCount(2, $result['channels']);
    }

    public function testAcknowledgeNotification()
    {
        $responseData = [
            'status' => 'ACKNOWLEDGED'
        ];

        $this->mockHandler->append(
            new Response(200, [], json_encode($responseData))
        );

        $result = $this->service->acknowledgeNotification('customer123', 'notification123', 'request123');

        $this->assertEquals('ACKNOWLEDGED', $result['status']);
    }

    public function testRegisterDomain()
    {
        $responseData = [
            'orderId' => '12345',
            'status' => 'PENDING'
        ];

        $this->mockHandler->append(
            new Response(200, [], json_encode($responseData))
        );

        $consent = ['agreedAt' => '2023-01-01T00:00:00Z', 'agreedBy' => 'test@example.com'];
        $contacts = ['registrant' => ['nameFirst' => 'John', 'nameLast' => 'Doe']];
        
        $data = new DomainRegisterData(
            domain: 'example.com',
            consent: $consent,
            contacts: $contacts,
            period: 1,
            privacy: true,
            renewAuto: true
        );

        $result = $this->service->registerDomain('customer123', $data, 'request123');

        $this->assertEquals('12345', $result['orderId']);
        $this->assertEquals('PENDING', $result['status']);
    }

    public function testGetRegistrationSchema()
    {
        $responseData = [
            'tld' => 'com',
            'requiredFields' => ['registrant', 'admin', 'tech'],
            'optionalFields' => ['billing']
        ];

        $this->mockHandler->append(
            new Response(200, [], json_encode($responseData))
        );

        $result = $this->service->getRegistrationSchema('customer123', 'com', 'request123');

        $this->assertEquals('com', $result['tld']);
        $this->assertCount(3, $result['requiredFields']);
    }

    public function testValidateRegistration()
    {
        $responseData = [
            'valid' => true,
            'message' => 'Registration is valid'
        ];

        $this->mockHandler->append(
            new Response(200, [], json_encode($responseData))
        );

        $consent = ['agreedAt' => '2023-01-01T00:00:00Z', 'agreedBy' => 'test@example.com'];
        $contacts = ['registrant' => ['nameFirst' => 'John', 'nameLast' => 'Doe']];
        
        $data = new DomainRegisterData(
            domain: 'example.com',
            consent: $consent,
            contacts: $contacts,
            period: 1
        );

        $result = $this->service->validateRegistration('customer123', $data, 'request123');

        $this->assertTrue($result['valid']);
        $this->assertEquals('Registration is valid', $result['message']);
    }

    public function testGetMaintenances()
    {
        $responseData = [
            'maintenances' => [
                ['id' => '1', 'type' => 'SCHEDULED', 'startDate' => '2023-01-01T00:00:00Z'],
                ['id' => '2', 'type' => 'EMERGENCY', 'startDate' => '2023-01-02T00:00:00Z']
            ]
        ];

        $this->mockHandler->append(
            new Response(200, [], json_encode($responseData))
        );

        $result = $this->service->getMaintenances('request123');

        $this->assertCount(2, $result['maintenances']);
        $this->assertEquals('1', $result['maintenances'][0]['id']);
        $this->assertEquals('SCHEDULED', $result['maintenances'][0]['type']);
    }

    public function testGetMaintenance()
    {
        $responseData = [
            'id' => '1',
            'type' => 'SCHEDULED',
            'startDate' => '2023-01-01T00:00:00Z',
            'endDate' => '2023-01-01T23:59:59Z',
            'description' => 'Scheduled maintenance'
        ];

        $this->mockHandler->append(
            new Response(200, [], json_encode($responseData))
        );

        $result = $this->service->getMaintenance('1', 'request123');

        $this->assertEquals('1', $result['id']);
        $this->assertEquals('SCHEDULED', $result['type']);
        $this->assertEquals('Scheduled maintenance', $result['description']);
    }

    public function testGetUsage()
    {
        $responseData = [
            'period' => '202301',
            'domains' => [
                ['domain' => 'example.com', 'actions' => 5],
                ['domain' => 'test.com', 'actions' => 3]
            ]
        ];

        $this->mockHandler->append(
            new Response(200, [], json_encode($responseData))
        );

        $result = $this->service->getUsage('202301', 'request123');

        $this->assertEquals('202301', $result['period']);
        $this->assertCount(2, $result['domains']);
        $this->assertEquals('example.com', $result['domains'][0]['domain']);
        $this->assertEquals(5, $result['domains'][0]['actions']);
    }

    public function testGetDomainContacts()
    {
        $responseData = [
            'registrant' => ['nameFirst' => 'John', 'nameLast' => 'Doe'],
            'admin' => ['nameFirst' => 'Jane', 'nameLast' => 'Smith'],
            'tech' => ['nameFirst' => 'Bob', 'nameLast' => 'Johnson']
        ];

        $this->mockHandler->append(
            new Response(200, [], json_encode($responseData))
        );

        $result = $this->service->getDomainContacts('customer123', 'example.com', 'request123');

        $this->assertEquals('John', $result['registrant']['nameFirst']);
        $this->assertEquals('Doe', $result['registrant']['nameLast']);
        $this->assertEquals('Jane', $result['admin']['nameFirst']);
    }

    public function testUpdateDomainContacts()
    {
        $this->mockHandler->append(
            new Response(200)
        );

        $contacts = [
            'registrant' => ['nameFirst' => 'John', 'nameLast' => 'Doe'],
            'admin' => ['nameFirst' => 'Jane', 'nameLast' => 'Smith']
        ];

        $this->service->updateDomainContacts('customer123', 'example.com', $contacts, 'request123');

        $this->assertTrue(true); // No exception thrown
    }

    public function testExceptionHandling()
    {
        $this->mockHandler->append(
            new RequestException('Error Communicating with Server', new Request('GET', 'test'))
        );

        $this->expectException(DnssecException::class);

        $records = [new DnssecRecordData('8', 'digest123', '1', '12345')];
        $this->service->addDnssecRecords('customer123', 'example.com', $records, 'request123');
    }
} 
