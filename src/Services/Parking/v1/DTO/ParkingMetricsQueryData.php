<?php

namespace GoDaddy\Services\Parking\v1\DTO;

class ParkingMetricsQueryData
{
    public function __construct(
        public ?string $periodStartPtz = null,
        public ?string $periodEndPtz = null,
        public int $limit = 20,
        public int $offset = 0,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'periodStartPtz' => $this->periodStartPtz,
            'periodEndPtz' => $this->periodEndPtz,
            'limit' => $this->limit,
            'offset' => $this->offset,
        ], function ($v) { return $v !== null; });
    }
}
