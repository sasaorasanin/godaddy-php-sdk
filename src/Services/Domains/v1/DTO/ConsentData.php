<?php

namespace GoDaddy\Services\Domains\v1\DTO;

class ConsentData
{
    public function __construct(
        public string $agreedAt,
        public string $agreedBy,
        public array $agreementKeys,
    ) {}

    public function toArray(): array
    {
        return [
            'agreedAt' => $this->agreedAt,
            'agreedBy' => $this->agreedBy,
            'agreementKeys' => $this->agreementKeys,
        ];
    }
} 