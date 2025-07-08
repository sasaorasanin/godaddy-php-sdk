<?php

namespace GoDaddy\Services\Abuse\v2\DTO;

class GetAbuseTicketData
{
    public function __construct(
        public string $ticketId
    ) {}
}
