# Abuse Service v2

This version of the service uses GoDaddy v2 Abuse API endpoints.

## Usage

```php
use GoDaddy\Services\Abuse\v2\AbuseService;
use GoDaddy\Services\Abuse\v2\DTO\ListAbuseTicketsFilter;
use GoDaddy\Services\Abuse\v2\DTO\CreateAbuseTicketData;
use GoDaddy\Services\Abuse\v2\DTO\GetAbuseTicketData;

$service = new AbuseService($apiKey, $apiSecret, $baseUrl);

// List abuse tickets
$filter = new ListAbuseTicketsFilter(type: 'phishing', limit: 10);
$tickets = $service->listTickets($filter);

// Create a new abuse ticket
$data = new CreateAbuseTicketData(
    'info value',
    'https://info.url',
    'source value',
    'target value',
    'type value',
    'proxy value',
    'useragent value'
);
$response = $service->createTicket($data);

// Get abuse ticket by ID
$ticketData = new GetAbuseTicketData('ticket-id-123');
$ticket = $service->getTicket($ticketData);
```

## DTO Reference

- **ListAbuseTicketsFilter**: Filter for listing abuse tickets (type, closed, sourceDomainOrIp, target, createdStart, createdEnd, limit, offset)
- **CreateAbuseTicketData**: Data for creating abuse tickets (info, infoUrl, source, target, type, proxy, useragent)
- **GetAbuseTicketData**: Data for retrieving abuse tickets (ticketId)

## Note
This documentation refers exclusively to v2 endpoints. For v1, see the README in the v1 folder. 