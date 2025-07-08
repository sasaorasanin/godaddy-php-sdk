<?php

namespace GoDaddy\Services\Domains\v1\DTO;

use GoDaddy\Services\Domains\v1\Enums\DomainStatus;
use GoDaddy\Services\Domains\v1\Enums\DomainStatusGroup;
use GoDaddy\Services\Domains\v1\Enums\DomainInclude;

class ListDomainsQueryData
{
    public function __construct(
        public ?array $statuses = null,
        public ?array $statusGroups = null,
        public ?int $limit = null,
        public ?string $marker = null,
        public ?array $includes = null,
        public ?string $modifiedDate = null,
    ) {}

    public function toArray(): array
    {
        $data = [];
        
        if ($this->statuses !== null) {
            $data['statuses'] = array_map(fn(DomainStatus $status) => $status->value, $this->statuses);
        }
        
        if ($this->statusGroups !== null) {
            $data['statusGroups'] = array_map(fn(DomainStatusGroup $group) => $group->value, $this->statusGroups);
        }
        
        if ($this->limit !== null) {
            $data['limit'] = $this->limit;
        }
        
        if ($this->marker !== null) {
            $data['marker'] = $this->marker;
        }
        
        if ($this->includes !== null) {
            $data['includes'] = array_map(fn(DomainInclude $include) => $include->value, $this->includes);
        }
        
        if ($this->modifiedDate !== null) {
            $data['modifiedDate'] = $this->modifiedDate;
        }
        
        return $data;
    }
} 