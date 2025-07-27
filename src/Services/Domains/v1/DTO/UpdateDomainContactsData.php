<?php

namespace GoDaddy\Services\Domains\v1\DTO;

class UpdateDomainContactsData
{
    public function __construct(
        public ?ContactData $contactAdmin = null,
        public ?ContactData $contactBilling = null,
        public ?ContactData $contactRegistrant = null,
        public ?ContactData $contactTech = null,
    ) {}

    public function toArray(): array
    {
        $data = [];
        
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