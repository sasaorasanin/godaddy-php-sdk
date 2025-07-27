<?php

namespace GoDaddy\Services\Domains\v2\DTO;

class NameServerUpdateData
{
    public function __construct(
        public array $nameServers
    ) {}

    public function toArray(): array
    {
        return [
            'nameServers' => $this->nameServers
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            nameServers: $data['nameServers']
        );
    }
} 