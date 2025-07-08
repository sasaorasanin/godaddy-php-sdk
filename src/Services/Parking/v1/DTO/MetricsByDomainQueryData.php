<?php

namespace GoDaddy\Services\Parking\v1\DTO;

class MetricsByDomainQueryData
{
    public function __construct(
        public string $startDate,
        public string $endDate,
        public ?string $domains = null,
        public ?string $domainLike = null,
        public ?string $portfolioId = null,
        public int $limit = 20,
        public int $offset = 0,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'domains' => $this->domains,
            'domainLike' => $this->domainLike,
            'portfolioId' => $this->portfolioId,
            'limit' => $this->limit,
            'offset' => $this->offset,
        ], function ($v) { return $v !== null; });
    }
}
