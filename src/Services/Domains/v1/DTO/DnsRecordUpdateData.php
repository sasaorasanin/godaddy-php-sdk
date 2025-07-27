<?php

namespace GoDaddy\Services\Domains\v1\DTO;

class DnsRecordUpdateData
{
    public function __construct(
        public string $data,
        public ?int $port = null,
        public ?int $priority = null,
        public ?string $protocol = null,
        public ?string $service = null,
        public ?int $ttl = null,
        public ?int $weight = null,
    ) {}

    public function toArray(): array
    {
        $data = [
            'data' => $this->data,
        ];
        
        if ($this->port !== null) {
            $data['port'] = $this->port;
        }
        
        if ($this->priority !== null) {
            $data['priority'] = $this->priority;
        }
        
        if ($this->protocol !== null) {
            $data['protocol'] = $this->protocol;
        }
        
        if ($this->service !== null) {
            $data['service'] = $this->service;
        }
        
        if ($this->ttl !== null) {
            $data['ttl'] = $this->ttl;
        }
        
        if ($this->weight !== null) {
            $data['weight'] = $this->weight;
        }
        
        return $data;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            data: $data['data'],
            port: $data['port'] ?? null,
            priority: $data['priority'] ?? null,
            protocol: $data['protocol'] ?? null,
            service: $data['service'] ?? null,
            ttl: $data['ttl'] ?? null,
            weight: $data['weight'] ?? null,
        );
    }
} 