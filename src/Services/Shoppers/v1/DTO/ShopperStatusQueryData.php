<?php

namespace GoDaddy\Services\Shoppers\v1\DTO;

class ShopperStatusQueryData
{
    public function __construct(
        public string $auditClientIp
    ) {}

    public function toArray(): array
    {
        return ['auditClientIp' => $this->auditClientIp];
    }
}
