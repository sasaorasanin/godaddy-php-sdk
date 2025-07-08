<?php

namespace GoDaddy\Services\Auctions\v1\DTO;

class PlaceMultipleBidsData
{
    /**
     * @param PlaceBidData[] $bids
     */
    public function __construct(
        public string $customerId,
        public array $bids
    ) {}

    public function toArray(): array
    {
        return array_map(fn($bid) => $bid->toArray(), $this->bids);
    }
} 