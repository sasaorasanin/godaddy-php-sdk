<?php

namespace GoDaddy\Services\Domains\v2\DTO;

class DomainRegisterData
{
    public function __construct(
        public string $domain,
        public array $consent,
        public array $contacts,
        public int $period,
        public ?bool $privacy = null,
        public ?bool $renewAuto = null,
        public ?array $nameServers = null
    ) {}

    public function toArray(): array
    {
        $data = [
            'domain' => $this->domain,
            'consent' => $this->consent,
            'contacts' => $this->contacts,
            'period' => $this->period
        ];
        
        if ($this->privacy !== null) {
            $data['privacy'] = $this->privacy;
        }
        
        if ($this->renewAuto !== null) {
            $data['renewAuto'] = $this->renewAuto;
        }
        
        if ($this->nameServers !== null) {
            $data['nameServers'] = $this->nameServers;
        }
        
        return $data;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            domain: $data['domain'],
            consent: $data['consent'],
            contacts: $data['contacts'],
            period: $data['period'],
            privacy: $data['privacy'] ?? null,
            renewAuto: $data['renewAuto'] ?? null,
            nameServers: $data['nameServers'] ?? null
        );
    }
} 