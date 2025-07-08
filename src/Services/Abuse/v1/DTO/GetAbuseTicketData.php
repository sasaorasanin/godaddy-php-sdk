<?php

namespace GoDaddy\Services\Abuse\v1\DTO;

class GetAbuseTicketData
{
    public function __construct(
        public string $ticketId
    ) {}
} 