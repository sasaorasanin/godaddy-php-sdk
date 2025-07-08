<?php

namespace GoDaddy\Services\Aftermarket\v1\DTO;

class DeleteAuctionListingsData
{
    public function __construct(public array $domains) {}

    public function toQuery(): array
    {
        return ['domains' => implode(',', $this->domains)];
    }
}
