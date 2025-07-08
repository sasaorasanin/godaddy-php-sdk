<?php

namespace GoDaddy\Services\Abuse\v2\DTO;

class CreateAbuseTicketData
{
    public function __construct(
        public string $info,
        public string $infoUrl,
        public string $source,
        public string $target,
        public string $type,
        public string $proxy,
        public string $useragent
    ) {}

    public function toArray(): array
    {
        return [
            'info' => $this->info,
            'infoUrl' => $this->infoUrl,
            'source' => $this->source,
            'target' => $this->target,
            'type' => $this->type,
            'proxy' => $this->proxy,
            'useragent' => $this->useragent,
        ];
    }
}
