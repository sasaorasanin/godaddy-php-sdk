<?php

namespace GoDaddy\Services\Shoppers\v1\DTO;

class CreateSubaccountData
{
    public function __construct(
        public string $email,
        public int $externalId,
        public string $marketId,
        public string $nameFirst,
        public string $nameLast,
        public string $password,
    ) {}

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'externalId' => $this->externalId,
            'marketId' => $this->marketId,
            'nameFirst' => $this->nameFirst,
            'nameLast' => $this->nameLast,
            'password' => $this->password,
        ];
    }
}
