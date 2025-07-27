<?php

namespace GoDaddy\Services\Domains\v2\DTO;

class DomainTransferData
{
    public function __construct(
        public string $authCode,
        public ?string $consent = null
    ) {}

    public function toArray(): array
    {
        $data = [
            'authCode' => $this->authCode
        ];
        
        if ($this->consent !== null) {
            $data['consent'] = $this->consent;
        }
        
        return $data;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            authCode: $data['authCode'],
            consent: $data['consent'] ?? null
        );
    }
} 