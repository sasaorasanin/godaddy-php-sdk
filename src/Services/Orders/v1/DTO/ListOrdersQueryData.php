<?php

namespace GoDaddy\Services\Orders\v1\DTO;

class ListOrdersQueryData
{
    public function __construct(
        public ?string $periodStart = null,
        public ?string $periodEnd = null,
        public ?string $domain = null,
        public ?int $productGroupId = null,
        public ?int $paymentProfileId = null,
        public ?string $parentOrderId = null,
        public int $offset = 0,
        public int $limit = 25,
        public string $sort = '-createdAt'
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'periodStart' => $this->periodStart,
            'periodEnd' => $this->periodEnd,
            'domain' => $this->domain,
            'productGroupId' => $this->productGroupId,
            'paymentProfileId' => $this->paymentProfileId,
            'parentOrderId' => $this->parentOrderId,
            'offset' => $this->offset,
            'limit' => $this->limit,
            'sort' => $this->sort,
        ]);
    }
}
