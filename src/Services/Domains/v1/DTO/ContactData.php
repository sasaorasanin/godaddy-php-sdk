<?php

namespace GoDaddy\Services\Domains\v1\DTO;

class ContactData
{
    public function __construct(
        public ContactAddressData $addressMailing,
        public string $email,
        public string $nameFirst,
        public string $nameLast,
        public ?string $fax = null,
        public ?string $jobTitle = null,
        public ?string $nameMiddle = null,
        public ?string $organization = null,
        public ?string $phone = null,
    ) {}

    public function toArray(): array
    {
        $data = [
            'addressMailing' => $this->addressMailing->toArray(),
            'email' => $this->email,
            'nameFirst' => $this->nameFirst,
            'nameLast' => $this->nameLast,
        ];
        
        if ($this->fax !== null) {
            $data['fax'] = $this->fax;
        }
        
        if ($this->jobTitle !== null) {
            $data['jobTitle'] = $this->jobTitle;
        }
        
        if ($this->nameMiddle !== null) {
            $data['nameMiddle'] = $this->nameMiddle;
        }
        
        if ($this->organization !== null) {
            $data['organization'] = $this->organization;
        }
        
        if ($this->phone !== null) {
            $data['phone'] = $this->phone;
        }
        
        return $data;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            addressMailing: ContactAddressData::fromArray($data['addressMailing']),
            email: $data['email'],
            nameFirst: $data['nameFirst'],
            nameLast: $data['nameLast'],
            fax: $data['fax'] ?? null,
            jobTitle: $data['jobTitle'] ?? null,
            nameMiddle: $data['nameMiddle'] ?? null,
            organization: $data['organization'] ?? null,
            phone: $data['phone'] ?? null,
        );
    }
} 