<?php

namespace GoDaddy\Services\Subscriptions\v1\DTO;

class UpdateSubscriptionData
{
    public function __construct(
        public int $paymentProfileId,
        public bool $renewAuto,
    ) {}

    public function toArray(): array
    {
        return [
            'paymentProfileId' => $this->paymentProfileId,
            'renewAuto' => $this->renewAuto,
        ];
    }
}
