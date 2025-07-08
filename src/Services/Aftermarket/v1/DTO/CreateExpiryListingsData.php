<?php

namespace GoDaddy\Services\Aftermarket\v1\DTO;

class CreateExpiryListingsData
{
    /**
     * @param ExpiryListingItem[] $listings
     */
    public function __construct(public array $listings) {}

    public function toArray(): array
    {
        return array_map(fn($item) => $item->toArray(), $this->listings);
    }
}
