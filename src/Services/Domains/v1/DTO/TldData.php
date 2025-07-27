<?php

namespace GoDaddy\Services\Domains\v1\DTO;

class TldData
{
    public function __construct(
        public string $name,
        public string $type,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            type: $data['type'],
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'type' => $this->type,
        ];
    }
} 