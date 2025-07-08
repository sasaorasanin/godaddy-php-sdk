<?php

namespace GoDaddy\Services\Aftermarket\v1\DTO;

class GetAuctionListingsFilter
{
    public function __construct(
        public string $customerId,
        public ?string $domains = null,
        public ?string $listingStatus = null,
        public ?string $transferBefore = null,
        public ?string $transferAfter = null,
        public ?int $limit = null,
        public ?int $offset = null
    ) {}

    public function toQuery(): array
    {
        return array_filter([
            'domains' => $this->domains,
            'listingStatus' => $this->listingStatus,
            'transferBefore' => $this->transferBefore,
            'transferAfter' => $this->transferAfter,
            'limit' => $this->limit,
            'offset' => $this->offset,
        ], fn ($v) => $v !== null);
    }
}
