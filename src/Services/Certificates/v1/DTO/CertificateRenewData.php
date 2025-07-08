<?php

namespace GoDaddy\Services\Certificates\v1\DTO;

class CertificateRenewData
{
    public function __construct(
        public string $callbackUrl,
        public string $commonName,
        public string $csr,
        public int $period,
        public string $rootType,
        public array $subjectAlternativeNames = [],
    ) {}

    public function toArray(): array
    {
        return [
            'callbackUrl' => $this->callbackUrl,
            'commonName' => $this->commonName,
            'csr' => $this->csr,
            'period' => $this->period,
            'rootType' => $this->rootType,
            'subjectAlternativeNames' => $this->subjectAlternativeNames,
        ];
    }
}