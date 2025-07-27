<?php

namespace GoDaddy\Services\Domains\v2\DTO;

class DomainDetailsV2Data
{
    public function __construct(
        public string $domainId,
        public string $domain,
        public ?string $subaccountId = null,
        public ?string $status = null,
        public ?string $expiresAt = null,
        public ?bool $expirationProtected = null,
        public ?bool $holdRegistrar = null,
        public ?bool $locked = null,
        public ?bool $privacy = null,
        public ?string $registrarCreatedAt = null,
        public ?bool $renewAuto = null,
        public ?string $renewDeadline = null,
        public ?bool $transferProtected = null,
        public ?string $createdAt = null,
        public ?string $deletedAt = null,
        public ?string $modifiedAt = null,
        public ?string $transferAwayEligibleAt = null,
        public ?string $authCode = null,
        public ?array $nameServers = null,
        public ?array $hostnames = null,
        public ?array $renewal = null,
        public ?array $verifications = null,
        public ?array $contacts = null,
        public ?array $actions = null,
        public ?array $dnssecRecords = null,
        public ?array $registryStatusCodes = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            domainId: $data['domainId'],
            domain: $data['domain'],
            subaccountId: $data['subaccountId'] ?? null,
            status: $data['status'] ?? null,
            expiresAt: $data['expiresAt'] ?? null,
            expirationProtected: $data['expirationProtected'] ?? null,
            holdRegistrar: $data['holdRegistrar'] ?? null,
            locked: $data['locked'] ?? null,
            privacy: $data['privacy'] ?? null,
            registrarCreatedAt: $data['registrarCreatedAt'] ?? null,
            renewAuto: $data['renewAuto'] ?? null,
            renewDeadline: $data['renewDeadline'] ?? null,
            transferProtected: $data['transferProtected'] ?? null,
            createdAt: $data['createdAt'] ?? null,
            deletedAt: $data['deletedAt'] ?? null,
            modifiedAt: $data['modifiedAt'] ?? null,
            transferAwayEligibleAt: $data['transferAwayEligibleAt'] ?? null,
            authCode: $data['authCode'] ?? null,
            nameServers: $data['nameServers'] ?? null,
            hostnames: $data['hostnames'] ?? null,
            renewal: $data['renewal'] ?? null,
            verifications: $data['verifications'] ?? null,
            contacts: $data['contacts'] ?? null,
            actions: $data['actions'] ?? null,
            dnssecRecords: $data['dnssecRecords'] ?? null,
            registryStatusCodes: $data['registryStatusCodes'] ?? null,
        );
    }

    public function toArray(): array
    {
        $data = [
            'domainId' => $this->domainId,
            'domain' => $this->domain,
        ];
        
        if ($this->subaccountId !== null) {
            $data['subaccountId'] = $this->subaccountId;
        }
        if ($this->status !== null) {
            $data['status'] = $this->status;
        }
        if ($this->expiresAt !== null) {
            $data['expiresAt'] = $this->expiresAt;
        }
        if ($this->expirationProtected !== null) {
            $data['expirationProtected'] = $this->expirationProtected;
        }
        if ($this->holdRegistrar !== null) {
            $data['holdRegistrar'] = $this->holdRegistrar;
        }
        if ($this->locked !== null) {
            $data['locked'] = $this->locked;
        }
        if ($this->privacy !== null) {
            $data['privacy'] = $this->privacy;
        }
        if ($this->registrarCreatedAt !== null) {
            $data['registrarCreatedAt'] = $this->registrarCreatedAt;
        }
        if ($this->renewAuto !== null) {
            $data['renewAuto'] = $this->renewAuto;
        }
        if ($this->renewDeadline !== null) {
            $data['renewDeadline'] = $this->renewDeadline;
        }
        if ($this->transferProtected !== null) {
            $data['transferProtected'] = $this->transferProtected;
        }
        if ($this->createdAt !== null) {
            $data['createdAt'] = $this->createdAt;
        }
        if ($this->deletedAt !== null) {
            $data['deletedAt'] = $this->deletedAt;
        }
        if ($this->modifiedAt !== null) {
            $data['modifiedAt'] = $this->modifiedAt;
        }
        if ($this->transferAwayEligibleAt !== null) {
            $data['transferAwayEligibleAt'] = $this->transferAwayEligibleAt;
        }
        if ($this->authCode !== null) {
            $data['authCode'] = $this->authCode;
        }
        if ($this->nameServers !== null) {
            $data['nameServers'] = $this->nameServers;
        }
        if ($this->hostnames !== null) {
            $data['hostnames'] = $this->hostnames;
        }
        if ($this->renewal !== null) {
            $data['renewal'] = $this->renewal;
        }
        if ($this->verifications !== null) {
            $data['verifications'] = $this->verifications;
        }
        if ($this->contacts !== null) {
            $data['contacts'] = $this->contacts;
        }
        if ($this->actions !== null) {
            $data['actions'] = $this->actions;
        }
        if ($this->dnssecRecords !== null) {
            $data['dnssecRecords'] = $this->dnssecRecords;
        }
        if ($this->registryStatusCodes !== null) {
            $data['registryStatusCodes'] = $this->registryStatusCodes;
        }
        
        return $data;
    }
} 