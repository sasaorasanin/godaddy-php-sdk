<?php

namespace GoDaddy\Services\Aftermarket\v1\DTO;

class ExpiryListingItem
{
    public function __construct(
        public string $domain,
        public string $expiresAt,
        public int $losingRegistrarId,
        public int $pageViewsMonthly = 0,
        public int $revenueMonthly = 0,
    ) {}

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}