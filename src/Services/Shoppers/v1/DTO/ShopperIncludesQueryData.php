<?php

namespace GoDaddy\Services\Shoppers\v1\DTO;

class ShopperIncludesQueryData
{
    public function __construct(
        public array $includes = []
    ) {}

    public function toArray(): array
    {
        return ['includes' => $this->includes];
    }
}
