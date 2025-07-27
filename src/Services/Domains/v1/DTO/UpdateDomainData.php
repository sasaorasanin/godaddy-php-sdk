<?php

namespace GoDaddy\Services\Domains\v1\DTO;

class UpdateDomainData
{
    public function __construct(
        public ?bool $locked = null,
        public ?array $nameServers = null,
        public ?bool $renewAuto = null,
        public ?string $subaccountId = null,
        public ?bool $exposeRegistrantOrganization = null,
        public ?bool $exposeWhois = null,
        public ?ConsentData $consent = null,
    ) {}

    public function toArray(): array
    {
        $data = [];
        
        if ($this->locked !== null) {
            $data['locked'] = $this->locked;
        }
        
        if ($this->nameServers !== null) {
            $data['nameServers'] = $this->nameServers;
        }
        
        if ($this->renewAuto !== null) {
            $data['renewAuto'] = $this->renewAuto;
        }
        
        if ($this->subaccountId !== null) {
            $data['subaccountId'] = $this->subaccountId;
        }
        
        if ($this->exposeRegistrantOrganization !== null) {
            $data['exposeRegistrantOrganization'] = $this->exposeRegistrantOrganization;
        }
        
        if ($this->exposeWhois !== null) {
            $data['exposeWhois'] = $this->exposeWhois;
        }
        
        if ($this->consent !== null) {
            $data['consent'] = $this->consent->toArray();
        }
        
        return $data;
    }
} 