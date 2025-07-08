<?php

namespace GoDaddy\Services\Domains\v1\DTO;

class GetAgreementsQueryData
{
    public function __construct(
        public array $tlds,
        public bool $privacy,
        public ?bool $forTransfer = null,
    ) {}

    public function toArray(): array
    {
        $data = [
            'tlds' => $this->tlds,
            'privacy' => $this->privacy,
        ];
        
        if ($this->forTransfer !== null) {
            $data['forTransfer'] = $this->forTransfer;
        }
        
        return $data;
    }
} 