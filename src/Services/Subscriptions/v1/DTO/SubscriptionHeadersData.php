<?php

namespace GoDaddy\Services\Subscriptions\v1\DTO;

class SubscriptionHeadersData
{
    public function __construct(
        public string $xAppKey,
        public ?string $xShopperId = null,
        public ?string $xMarketId = 'en-US',
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'X-App-Key' => $this->xAppKey,
            'X-Shopper-Id' => $this->xShopperId,
            'X-Market-Id' => $this->xMarketId,
        ], fn ($v) => $v !== null);
    }
}
