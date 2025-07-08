<?php

namespace GoDaddy\Services\Certificates\v1\DTO;

class CertificateReissueData
{
    public function __construct(
        public string $callbackUrl,
        public string $commonName,
        public string $csr,
        public int $delayExistingRevoke,
        public string $rootType,
        public array $subjectAlternativeNames = [],
        public array $forceDomainRevetting = [],
    ) {}

    public function toArray(): array
    {
        return [
            'callbackUrl' => $this->callbackUrl,
            'commonName' => $this->commonName,
            'csr' => $this->csr,
            'delayExistingRevoke' => $this->delayExistingRevoke,
            'rootType' => $this->rootType,
            'subjectAlternativeNames' => $this->subjectAlternativeNames,
            'forceDomainRevetting' => $this->forceDomainRevetting,
        ];
    }
}
