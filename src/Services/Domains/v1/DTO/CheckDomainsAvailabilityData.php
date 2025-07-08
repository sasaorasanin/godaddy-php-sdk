<?php

namespace GoDaddy\Services\Domains\v1\DTO;

use GoDaddy\Services\Domains\v1\Enums\CheckType;

class CheckDomainsAvailabilityData
{
    public function __construct(
        public array $domains,
        public ?CheckType $checkType = null,
    ) {}

    public function toArray(): array
    {
        $data = [
            'domains' => $this->domains,
        ];
        
        if ($this->checkType !== null) {
            $data['checkType'] = $this->checkType->value;
        }
        
        return $data;
    }
} 