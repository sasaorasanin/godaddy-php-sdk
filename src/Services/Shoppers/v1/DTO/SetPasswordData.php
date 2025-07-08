<?php

namespace GoDaddy\Services\Shoppers\v1\DTO;

class SetPasswordData
{
    public function __construct(
        public string $secret
    ) {}

    public function toArray(): array
    {
        return ['secret' => $this->secret];
    }
}
