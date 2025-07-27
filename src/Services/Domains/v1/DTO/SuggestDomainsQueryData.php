<?php

namespace GoDaddy\Services\Domains\v1\DTO;

class SuggestDomainsQueryData
{
    public function __construct(
        public string $query,
        public ?string $country = null,
        public ?string $city = null,
        public ?array $sources = null,
        public ?array $tlds = null,
        public ?int $lengthMax = null,
        public ?int $lengthMin = null,
        public ?int $limit = null,
        public ?int $waitMs = null,
    ) {}

    public function toArray(): array
    {
        $data = [
            'query' => $this->query,
        ];
        
        if ($this->country !== null) {
            $data['country'] = $this->country;
        }
        
        if ($this->city !== null) {
            $data['city'] = $this->city;
        }
        
        if ($this->sources !== null) {
            $data['sources'] = $this->sources;
        }
        
        if ($this->tlds !== null) {
            $data['tlds'] = $this->tlds;
        }
        
        if ($this->lengthMax !== null) {
            $data['lengthMax'] = $this->lengthMax;
        }
        
        if ($this->lengthMin !== null) {
            $data['lengthMin'] = $this->lengthMin;
        }
        
        if ($this->limit !== null) {
            $data['limit'] = $this->limit;
        }
        
        if ($this->waitMs !== null) {
            $data['waitMs'] = $this->waitMs;
        }
        
        return $data;
    }
} 