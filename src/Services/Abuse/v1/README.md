# Abuse Service v1

This version of the service uses GoDaddy v1 Abuse API endpoints.

## Usage

```php
use GoDaddy\Services\Abuse\v1\AbuseService;
use GoDaddy\Services\Abuse\v1\DTO\ListAbuseTicketsFilter;
use GoDaddy\Services\Abuse\v1\DTO\CreateAbuseTicketData;
use GoDaddy\Services\Abuse\v1\DTO\GetAbuseTicketData;

$service = new AbuseService($apiKey, $apiSecret, $baseUrl);

// List abuse ticket IDs
$filter = new ListAbuseTicketsFilter(type: 'PHISHING', limit: 10);
$tickets = $service->listTickets($filter);

// Create a new abuse ticket
$data = new CreateAbuseTicketData(
    'info value',
    'https://info.url',
    'source value',
    'target value',
    false, // intentional
    'proxy value',
    'A_RECORD'
);
$response = $service->createTicket($data);

// Get abuse ticket by ID
$ticketData = new GetAbuseTicketData('ticket-id-123');
$ticket = $service->getTicket($ticketData);
```

## DTO Reference

- **ListAbuseTicketsFilter**: Filter for listing abuse tickets (type, closed, sourceDomainOrIp, target, createdStart, createdEnd, limit, offset)
- **CreateAbuseTicketData**: Data for creating abuse tickets (info, infoUrl, source, target, intentional, proxy, type)
- **GetAbuseTicketData**: Data for retrieving abuse tickets (ticketId)

## Note
This documentation refers exclusively to v1 endpoints. For v2, see the README in the v2 folder. 