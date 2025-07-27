<?php

namespace GoDaddy\Services\Domains\v2\DTO;

class DnssecRecordData
{
    public function __construct(
        public string $algorithm,
        public string $digest,
        public string $digestType,
        public string $keyTag
    ) {}

    public function toArray(): array
    {
        return [
            'algorithm' => $this->algorithm,
            'digest' => $this->digest,
            'digestType' => $this->digestType,
            'keyTag' => $this->keyTag
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            algorithm: $data['algorithm'],
            digest: $data['digest'],
            digestType: $data['digestType'],
            keyTag: $data['keyTag']
        );
    }
} 