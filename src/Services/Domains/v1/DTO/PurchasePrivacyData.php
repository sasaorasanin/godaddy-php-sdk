<?php

namespace GoDaddy\Services\Domains\v1\DTO;

class PurchasePrivacyData
{
    public function __construct(
        public ?ConsentData $consent = null,
    ) {}

    public function toArray(): array
    {
        $data = [];
        
        if ($this->consent !== null) {
            $data['consent'] = $this->consent->toArray();
        }
        
        return $data;
    }
} 