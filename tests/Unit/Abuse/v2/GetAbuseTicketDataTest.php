<?php

use GoDaddy\Services\Abuse\v2\DTO\GetAbuseTicketData;

test('GetAbuseTicketData assigns ticketId correctly', function () {
    $data = new GetAbuseTicketData('ticket-123');
    expect($data->ticketId)->toBe('ticket-123');
}); 