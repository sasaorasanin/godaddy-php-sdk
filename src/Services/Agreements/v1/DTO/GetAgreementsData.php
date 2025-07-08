<?php

namespace GoDaddy\Services\Agreements\v1\DTO;

class GetAgreementsData
{
    public function __construct(
        public array $keys,
        public ?int $privateLabelId = null,
        public ?string $marketId = 'en-US',
    ) {}

    public function toQuery(): array
    {
        return [
            'keys' => $this->keys,
        ];
    }

    public function toHeaders(): array
    {
        $headers = [];
        if ($this->privateLabelId !== null) {
            $headers['X-Private-Label-Id'] = $this->privateLabelId;
        }
        if ($this->marketId !== null) {
            $headers['X-Market-Id'] = $this->marketId;
        }
        return $headers;
    }
} 