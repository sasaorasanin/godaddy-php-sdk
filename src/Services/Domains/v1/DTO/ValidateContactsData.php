<?php

namespace GoDaddy\Services\Domains\v1\DTO;

class ValidateContactsData
{
    public function __construct(
        public ?ContactData $contactAdmin = null,
        public ?ContactData $contactBilling = null,
        public ?ContactData $contactPresence = null,
        public ?ContactData $contactRegistrant = null,
        public ?ContactData $contactTech = null,
        public ?array $domains = null,
        public ?array $tlds = null,
        public ?string $entityType = null,
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
        
        if ($this->contactPresence !== null) {
            $data['contactPresence'] = $this->contactPresence->toArray();
        }
        
        if ($this->contactRegistrant !== null) {
            $data['contactRegistrant'] = $this->contactRegistrant->toArray();
        }
        
        if ($this->contactTech !== null) {
            $data['contactTech'] = $this->contactTech->toArray();
        }
        
        if ($this->domains !== null) {
            $data['domains'] = $this->domains;
        }
        
        if ($this->tlds !== null) {
            $data['tlds'] = $this->tlds;
        }
        
        if ($this->entityType !== null) {
            $data['entityType'] = $this->entityType;
        }
        
        return $data;
    }
} 