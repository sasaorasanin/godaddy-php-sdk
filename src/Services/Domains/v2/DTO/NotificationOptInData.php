<?php

namespace GoDaddy\Services\Domains\v2\DTO;

class NotificationOptInData
{
    public function __construct(
        public string $type,
        public array $channels
    ) {}

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'channels' => $this->channels
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            type: $data['type'],
            channels: $data['channels']
        );
    }
} 