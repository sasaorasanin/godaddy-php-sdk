<?php

namespace GoDaddy\Services\Domains\v1\DTO;

class TransferDomainData
{
    public function __construct(
        public string $authCode,
        public ?ConsentData $consent = null,
        public ?ContactData $contactAdmin = null,
        public ?ContactData $contactBilling = null,
        public ?ContactData $contactRegistrant = null,
        public ?ContactData $contactTech = null,
        public int $period = 1,
        public bool $privacy = false,
        public bool $renewAuto = true,
    ) {}

    public function toArray(): array
    {
        $data = [
            'authCode' => $this->authCode,
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
        
        return $data;
    }
} 