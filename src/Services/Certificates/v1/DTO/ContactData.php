<?php

namespace GoDaddy\Services\Certificates\v1\DTO;

class ContactData
{
    public function __construct(
        public string $email,
        public string $jobTitle,
        public string $nameFirst,
        public string $nameLast,
        public string $nameMiddle,
        public string $phone,
        public string $suffix,
    ) {}

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'jobTitle' => $this->jobTitle,
            'nameFirst' => $this->nameFirst,
            'nameLast' => $this->nameLast,
            'nameMiddle' => $this->nameMiddle,
            'phone' => $this->phone,
            'suffix' => $this->suffix,
        ];
    }
}
