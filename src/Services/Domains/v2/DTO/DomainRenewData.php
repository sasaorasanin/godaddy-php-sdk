<?php

namespace GoDaddy\Services\Domains\v2\DTO;

class DomainRenewData
{
    public function __construct(
        public int $period
    ) {}

    public function toArray(): array
    {
        return [
            'period' => $this->period
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            period: $data['period']
        );
    }
} 