<?php

namespace GoDaddy\Services\Certificates\v1\DTO;

class OrganizationData
{
    public function __construct(
        public AddressData $address,
        public string $assumedName,
        public string $name,
        public string $phone,
        public string $registrationAgent,
        public string $registrationNumber,
    ) {}

    public function toArray(): array
    {
        return [
            'address' => $this->address->toArray(),
            'assumedName' => $this->assumedName,
            'name' => $this->name,
            'phone' => $this->phone,
            'registrationAgent' => $this->registrationAgent,
            'registrationNumber' => $this->registrationNumber,
        ];
    }
}
