<?php

namespace GoDaddy\Services\Orders\v1\DTO;

class OrdersHeadersData
{
    public function __construct(
        public string $appKey,
        public ?string $shopperId = null,
        public ?string $marketId = 'en-US'
    ) {}

    public function toArray(string $context = 'list'): array
    {
        return array_filter([
            'X-App-Key' => $this->appKey,
            'X-Shopper-Id' => $this->shopperId,
            'X-Market-Id' => $context === 'single' ? $this->marketId : null,
        ]);
    }
}
