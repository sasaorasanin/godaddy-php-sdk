<?php

namespace GoDaddy\Services\Domains\v1\DTO;

class GetDnsRecordsQueryData
{
    public function __construct(
        public ?int $offset = null,
        public ?int $limit = null,
    ) {}

    public function toArray(): array
    {
        $data = [];
        
        if ($this->offset !== null) {
            $data['offset'] = $this->offset;
        }
        
        if ($this->limit !== null) {
            $data['limit'] = $this->limit;
        }
        
        return $data;
    }
} 