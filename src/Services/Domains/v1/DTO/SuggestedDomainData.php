<?php

namespace GoDaddy\Services\Domains\v1\DTO;

class SuggestedDomainData
{
    public function __construct(
        public string $domain,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            domain: $data['domain'],
        );
    }

    public function toArray(): array
    {
        return [
            'domain' => $this->domain,
        ];
    }
} 