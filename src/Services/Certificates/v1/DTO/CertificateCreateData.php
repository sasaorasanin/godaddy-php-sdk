<?php

namespace GoDaddy\Services\Certificates\v1\DTO;

class CertificateCreateData
{
    public function __construct(
        public string $callbackUrl,
        public string $commonName,
        public ContactData $contact,
        public string $csr,
        public bool $intelVPro,
        public OrganizationData $organization,
        public int $period,
        public string $productType,
        public string $rootType,
        public string $slotSize,
        public array $subjectAlternativeNames = [],
    ) {}

    public function toArray(): array
    {
        return [
            'callbackUrl' => $this->callbackUrl,
            'commonName' => $this->commonName,
            'contact' => $this->contact->toArray(),
            'csr' => $this->csr,
            'intelVPro' => $this->intelVPro,
            'organization' => $this->organization->toArray(),
            'period' => $this->period,
            'productType' => $this->productType,
            'rootType' => $this->rootType,
            'slotSize' => $this->slotSize,
            'subjectAlternativeNames' => $this->subjectAlternativeNames,
        ];
    }
}
