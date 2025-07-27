<?php

namespace GoDaddy\Services\Domains\v2\DTO;

use GoDaddy\Services\Domains\v2\Enums\DomainInclude;

class GetDomainDetailsQueryData
{
    public function __construct(
        public ?array $includes = null,
    ) {}

    public function toArray(): array
    {
        $data = [];
        if ($this->includes !== null) {
            $data['includes'] = array_map(fn($include) => $include instanceof DomainInclude ? $include->value : $include, $this->includes);
        }
        return $data;
    }
} 