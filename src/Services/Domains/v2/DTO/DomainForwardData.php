<?php

namespace GoDaddy\Services\Domains\v2\DTO;

class DomainForwardData
{
    public function __construct(
        public string $forwardTo,
        public bool $mask,
        public ?string $title = null,
        public ?string $description = null,
        public ?string $keywords = null
    ) {}

    public function toArray(): array
    {
        $data = [
            'forwardTo' => $this->forwardTo,
            'mask' => $this->mask
        ];
        
        if ($this->title !== null) {
            $data['title'] = $this->title;
        }
        
        if ($this->description !== null) {
            $data['description'] = $this->description;
        }
        
        if ($this->keywords !== null) {
            $data['keywords'] = $this->keywords;
        }
        
        return $data;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            forwardTo: $data['forwardTo'],
            mask: $data['mask'],
            title: $data['title'] ?? null,
            description: $data['description'] ?? null,
            keywords: $data['keywords'] ?? null
        );
    }
} 