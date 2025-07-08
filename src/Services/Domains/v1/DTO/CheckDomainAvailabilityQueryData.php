<?php

namespace GoDaddy\Services\Domains\v1\DTO;

use GoDaddy\Services\Domains\v1\Enums\CheckType;

class CheckDomainAvailabilityQueryData
{
    public function __construct(
        public string $domain,
        public ?CheckType $checkType = null,
        public ?bool $forTransfer = null,
    ) {}

    public function toArray(): array
    {
        $data = [
            'domain' => $this->domain,
        ];
        
        if ($this->checkType !== null) {
            $data['checkType'] = $this->checkType->value;
        }
        
        if ($this->forTransfer !== null) {
            $data['forTransfer'] = $this->forTransfer;
        }
        
        return $data;
    }
} 