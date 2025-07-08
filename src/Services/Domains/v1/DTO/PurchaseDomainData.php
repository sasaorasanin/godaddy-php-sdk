<?php

namespace GoDaddy\Services\Domains\v1\DTO;

class PurchaseDomainData
{
    public function __construct(
        public ?ConsentData $consent = null,
        public ?ContactData $contactAdmin = null,
        public ?ContactData $contactBilling = null,
        public ?ContactData $contactRegistrant = null,
        public ?ContactData $contactTech = null,
        public string $domain,
        public ?array $nameServers = null,
        public int $period = 1,
        public bool $privacy = false,
        public bool $renewAuto = true,
    ) {}

    public function toArray(): array
    {
        $data = [
            'domain' => $this->domain,
            'period' => $this->period,
            'privacy' => $this->privacy,
            'renewAuto' => $this->renewAuto,
        ];
        
        if ($this->consent !== null) {
            $data['consent'] = $this->consent->toArray();
        }
        
        if ($this->contactAdmin !== null) {
            $data['contactAdmin'] = $this->contactAdmin->toArray();
        }
        
        if ($this->contactBilling !== null) {
            $data['contactBilling'] = $this->contactBilling->toArray();
        }
        
        if ($this->contactRegistrant !== null) {
            $data['contactRegistrant'] = $this->contactRegistrant->toArray();
        }
        
        if ($this->contactTech !== null) {
            $data['contactTech'] = $this->contactTech->toArray();
        }
        
        if ($this->nameServers !== null) {
            $data['nameServers'] = $this->nameServers;
        }
        
        return $data;
    }
} 