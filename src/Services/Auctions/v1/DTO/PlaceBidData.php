<?php

namespace GoDaddy\Services\Auctions\v1\DTO;

class PlaceBidData
{
    public function __construct(
        public float $bidAmountUsd,
        public bool $tosAccepted,
        public int $listingId,
    ) {}

    public function toArray(): array
    {
        return [
            'bidAmountUsd' => $this->bidAmountUsd,
            'tosAccepted' => $this->tosAccepted,
            'listingId' => $this->listingId,
        ];
    }
} 