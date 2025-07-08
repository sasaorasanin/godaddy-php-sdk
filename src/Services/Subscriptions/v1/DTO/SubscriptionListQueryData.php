<?php

namespace GoDaddy\Services\Subscriptions\v1\DTO;

class SubscriptionListQueryData
{
    public function __construct(
        public array $productGroupKeys = [],
        public array $includes = [],
        public int $offset = 0,
        public int $limit = 25,
        public string $sort = '-expiresAt',
    ) {}

    public function toArray(): array
    {
        return [
            'productGroupKeys' => $this->productGroupKeys,
            'includes' => $this->includes,
            'offset' => $this->offset,
            'limit' => $this->limit,
            'sort' => $this->sort,
        ];
    }
}
