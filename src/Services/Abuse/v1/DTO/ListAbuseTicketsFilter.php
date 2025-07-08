<?php

namespace GoDaddy\Services\Abuse\v1\DTO;

class ListAbuseTicketsFilter
{
    public function __construct(
        public ?string $type = null,
        public ?bool $closed = null,
        public ?string $sourceDomainOrIp = null,
        public ?string $target = null,
        public ?string $createdStart = null,
        public ?string $createdEnd = null,
        public ?int $limit = 100,
        public ?int $offset = 0,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'type' => $this->type,
            'closed' => $this->closed,
            'sourceDomainOrIp' => $this->sourceDomainOrIp,
            'target' => $this->target,
            'createdStart' => $this->createdStart,
            'createdEnd' => $this->createdEnd,
            'limit' => $this->limit,
            'offset' => $this->offset,
        ], fn($v) => $v !== null);
    }
} 