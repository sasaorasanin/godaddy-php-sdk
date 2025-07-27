<?php

namespace GoDaddy\Services\Domains\v1\DTO;

class PurchasePrivacyResponseData
{
    public function __construct(
        public string $currency,
        public int $itemCount,
        public int $orderId,
        public int $total,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            currency: $data['currency'],
            itemCount: $data['itemCount'],
            orderId: $data['orderId'],
            total: $data['total'],
        );
    }

    public function toArray(): array
    {
        return [
            'currency' => $this->currency,
            'itemCount' => $this->itemCount,
            'orderId' => $this->orderId,
            'total' => $this->total,
        ];
    }
} 