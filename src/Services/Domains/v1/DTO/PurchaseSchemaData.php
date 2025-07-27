<?php

namespace GoDaddy\Services\Domains\v1\DTO;

class PurchaseSchemaData
{
    public function __construct(
        public string $id,
        public array $models,
        public array $properties,
        public array $required,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            models: $data['models'] ?? [],
            properties: $data['properties'] ?? [],
            required: $data['required'] ?? [],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'models' => $this->models,
            'properties' => $this->properties,
            'required' => $this->required,
        ];
    }
} 