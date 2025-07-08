<?php

namespace GoDaddy\Services\Certificates\v1\DTO;

class CertificateRevokeData
{
    public function __construct(public string $reason) {}

    public function toArray(): array
    {
        return [
            'reason' => $this->reason,
        ];
    }
}