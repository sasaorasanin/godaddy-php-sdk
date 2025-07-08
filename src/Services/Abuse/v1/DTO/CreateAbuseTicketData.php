<?php

namespace GoDaddy\Services\Abuse\v1\DTO;

class CreateAbuseTicketData
{
    public function __construct(
        public string $info,
        public string $infoUrl,
        public string $source,
        public string $target,
        public bool $intentional,
        public string $proxy,
        public string $type,
    ) {}

    public function toArray(): array
    {
        return [
            'info' => $this->info,
            'infoUrl' => $this->infoUrl,
            'source' => $this->source,
            'target' => $this->target,
            'intentional' => $this->intentional,
            'proxy' => $this->proxy,
            'type' => $this->type,
        ];
    }
} 