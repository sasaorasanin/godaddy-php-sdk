<?php

namespace GoDaddy\Services\Domains\v1\DTO;

class ContactAddressData
{
    public function __construct(
        public string $address1,
        public ?string $address2 = null,
        public string $city,
        public string $country,
        public string $postalCode,
        public ?string $state = null,
    ) {}

    public function toArray(): array
    {
        $data = [
            'address1' => $this->address1,
            'city' => $this->city,
            'country' => $this->country,
            'postalCode' => $this->postalCode,
        ];
        
        if ($this->address2 !== null) {
            $data['address2'] = $this->address2;
        }
        
        if ($this->state !== null) {
            $data['state'] = $this->state;
        }
        
        return $data;
    }
} 