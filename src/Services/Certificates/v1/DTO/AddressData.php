<?php

namespace GoDaddy\Services\Certificates\v1\DTO;

class AddressData
{
    public function __construct(
        public string $address1,
        public string $address2,
        public string $city,
        public string $country,
        public string $postalCode,
        public string $state,
    ) {}

    public function toArray(): array
    {
        return [
            'address1' => $this->address1,
            'address2' => $this->address2,
            'city' => $this->city,
            'country' => $this->country,
            'postalCode' => $this->postalCode,
            'state' => $this->state,
        ];
    }
}
