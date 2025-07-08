<?php

namespace GoDaddy;

use GoDaddy\Services\{
    AbuseService,
    AftermarketService,
    AgreementsService,
    AuctionsService,
    CertificatesService,
    CountriesService,
    DomainsService,
    OrdersService,
    ParkingService,
    ShoppersService,
    SubscriptionsService
};

class GoDaddy
{
    public function __construct(
        protected string $apiKey,
        protected string $apiSecret,
        protected string $baseUrl = 'https://api.godaddy.com/v1'
    ) {}

    public function abuse(): AbuseService
    {
        return new AbuseService($this->apiKey, $this->apiSecret, $this->baseUrl);
    }

    public function aftermarket(): AftermarketService
    {
        return new AftermarketService($this->apiKey, $this->apiSecret, $this->baseUrl);
    }

    public function agreements(): AgreementsService
    {
        return new AgreementsService($this->apiKey, $this->apiSecret, $this->baseUrl);
    }

    public function auctions(): AuctionsService
    {
        return new AuctionsService($this->apiKey, $this->apiSecret, $this->baseUrl);
    }

    public function certificates(): CertificatesService
    {
        return new CertificatesService($this->apiKey, $this->apiSecret, $this->baseUrl);
    }

    public function countries(): CountriesService
    {
        return new CountriesService($this->apiKey, $this->apiSecret, $this->baseUrl);
    }

    public function domains(): DomainsService
    {
        return new DomainsService($this->apiKey, $this->apiSecret, $this->baseUrl);
    }

    public function orders(): OrdersService
    {
        return new OrdersService($this->apiKey, $this->apiSecret, $this->baseUrl);
    }

    public function parking(): ParkingService
    {
        return new ParkingService($this->apiKey, $this->apiSecret, $this->baseUrl);
    }

    public function shoppers(): ShoppersService
    {
        return new ShoppersService($this->apiKey, $this->apiSecret, $this->baseUrl);
    }

    public function subscriptions(): SubscriptionsService
    {
        return new SubscriptionsService($this->apiKey, $this->apiSecret, $this->baseUrl);
    }
}
