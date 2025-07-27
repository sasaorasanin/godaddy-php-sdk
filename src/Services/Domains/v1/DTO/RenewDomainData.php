<?php

namespace GoDaddy\Services\Domains\v1\DTO;

class RenewDomainData
{
    public function __construct(
        public ?int $period = null,
    ) {}

    public function toArray(): array
    {
        $data = [];
        
        if ($this->period !== null) {
            $data['period'] = $this->period;
        }
        
        return $data;
    }
} 