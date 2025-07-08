<?php

use GoDaddy\Services\Abuse\v1\DTO\GetAbuseTicketData;

test('GetAbuseTicketData returns correct ticketId', function () {
    $data = new GetAbuseTicketData('ticket-123');
    expect($data->ticketId)->toBe('ticket-123');
});
