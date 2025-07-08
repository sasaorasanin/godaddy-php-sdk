<?php

namespace GoDaddy\Services\Parking\v1\DTO;

class ParkingHeadersData
{
    public function __construct(
        public string $requestId
    ) {}

    public function toArray(): array
    {
        return [
            'X-Request-Id' => $this->requestId,
        ];
    }
}
