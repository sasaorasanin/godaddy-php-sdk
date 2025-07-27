<?php

namespace GoDaddy\Services\Domains\v2\DTO;

class PrivacyForwardingData
{
    public function __construct(
        public string $email
    ) {}

    public function toArray(): array
    {
        return [
            'email' => $this->email
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            email: $data['email']
        );
    }
} 