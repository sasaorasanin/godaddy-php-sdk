<?php

namespace GoDaddy\Services\Domains\v1\DTO;

class DomainDetailsData
{
    public function __construct(
        public string $domain,
        public int $domainId,
        public bool $expirationProtected,
        public bool $exposeRegistrantOrganization,
        public bool $exposeWhois,
        public bool $holdRegistrar,
        public bool $locked,
        public bool $privacy,
        public bool $renewAuto,
        public string $status,
        public bool $transferProtected,
        public ?string $authCode = null,
        public ?ContactData $contactAdmin = null,
        public ?ContactData $contactBilling = null,
        public ?ContactData $contactRegistrant = null,
        public ?ContactData $contactTech = null,
        public ?string $createdAt = null,
        public ?string $deletedAt = null,
        public ?string $transferAwayEligibleAt = null,
        public ?string $expires = null,
        public ?array $nameServers = null,
        public ?string $registrarCreatedAt = null,
        public ?string $renewDeadline = null,
        public ?string $subaccountId = null,
        public ?array $verifications = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            authCode: $data['authCode'] ?? null,
            contactAdmin: isset($data['contactAdmin']) ? ContactData::fromArray($data['contactAdmin']) : null,
            contactBilling: isset($data['contactBilling']) ? ContactData::fromArray($data['contactBilling']) : null,
            contactRegistrant: isset($data['contactRegistrant']) ? ContactData::fromArray($data['contactRegistrant']) : null,
            contactTech: isset($data['contactTech']) ? ContactData::fromArray($data['contactTech']) : null,
            createdAt: $data['createdAt'] ?? null,
            deletedAt: $data['deletedAt'] ?? null,
            transferAwayEligibleAt: $data['transferAwayEligibleAt'] ?? null,
            domain: $data['domain'],
            domainId: $data['domainId'],
            expirationProtected: $data['expirationProtected'],
            expires: $data['expires'] ?? null,
            exposeRegistrantOrganization: $data['exposeRegistrantOrganization'],
            exposeWhois: $data['exposeWhois'],
            holdRegistrar: $data['holdRegistrar'],
            locked: $data['locked'],
            nameServers: $data['nameServers'] ?? null,
            privacy: $data['privacy'],
            registrarCreatedAt: $data['registrarCreatedAt'] ?? null,
            renewAuto: $data['renewAuto'],
            renewDeadline: $data['renewDeadline'] ?? null,
            status: $data['status'],
            subaccountId: $data['subaccountId'] ?? null,
            transferProtected: $data['transferProtected'],
            verifications: $data['verifications'] ?? null,
        );
    }

    public function toArray(): array
    {
        $data = [
            'domain' => $this->domain,
            'domainId' => $this->domainId,
            'expirationProtected' => $this->expirationProtected,
            'exposeRegistrantOrganization' => $this->exposeRegistrantOrganization,
            'exposeWhois' => $this->exposeWhois,
            'holdRegistrar' => $this->holdRegistrar,
            'locked' => $this->locked,
            'privacy' => $this->privacy,
            'renewAuto' => $this->renewAuto,
            'status' => $this->status,
            'transferProtected' => $this->transferProtected,
        ];
        
        if ($this->authCode !== null) {
            $data['authCode'] = $this->authCode;
        }
        
        if ($this->contactAdmin !== null) {
            $data['contactAdmin'] = $this->contactAdmin->toArray();
        }
        
        if ($this->contactBilling !== null) {
            $data['contactBilling'] = $this->contactBilling->toArray();
        }
        
        if ($this->contactRegistrant !== null) {
            $data['contactRegistrant'] = $this->contactRegistrant->toArray();
        }
        
        if ($this->contactTech !== null) {
            $data['contactTech'] = $this->contactTech->toArray();
        }
        
        if ($this->createdAt !== null) {
            $data['createdAt'] = $this->createdAt;
        }
        
        if ($this->deletedAt !== null) {
            $data['deletedAt'] = $this->deletedAt;
        }
        
        if ($this->transferAwayEligibleAt !== null) {
            $data['transferAwayEligibleAt'] = $this->transferAwayEligibleAt;
        }
        
        if ($this->expires !== null) {
            $data['expires'] = $this->expires;
        }
        
        if ($this->nameServers !== null) {
            $data['nameServers'] = $this->nameServers;
        }
        
        if ($this->registrarCreatedAt !== null) {
            $data['registrarCreatedAt'] = $this->registrarCreatedAt;
        }
        
        if ($this->renewDeadline !== null) {
            $data['renewDeadline'] = $this->renewDeadline;
        }
        
        if ($this->subaccountId !== null) {
            $data['subaccountId'] = $this->subaccountId;
        }
        
        if ($this->verifications !== null) {
            $data['verifications'] = $this->verifications;
        }
        
        return $data;
    }
} 