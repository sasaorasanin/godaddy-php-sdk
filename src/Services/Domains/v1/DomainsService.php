<?php

namespace GoDaddy\Services\Domains\v1;

use GoDaddy\Services\BaseService;
use GoDaddy\Services\Domains\v1\DTO\ListDomainsQueryData;
use GoDaddy\Services\Domains\v1\DTO\GetAgreementsQueryData;
use GoDaddy\Services\Domains\v1\DTO\CheckDomainAvailabilityQueryData;
use GoDaddy\Services\Domains\v1\DTO\CheckDomainsAvailabilityData;
use GoDaddy\Services\Domains\v1\DTO\ValidateContactsData;
use GoDaddy\Services\Domains\v1\DTO\PurchaseDomainData;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsListException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsAgreementsException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsAvailabilityException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsContactValidationException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsPurchaseException;
use GuzzleHttp\Exception\GuzzleException;

class DomainsService extends BaseService
{
    /**
     * Retrieve a list of domains for the specified shopper
     *
     * @param string $shopperId Shopper ID whose domains are to be retrieved
     * @param ListDomainsQueryData|null $queryData Optional query parameters
     * @return array List of domains
     * @throws DomainsListException
     */
    public function listDomains(string $shopperId, ?ListDomainsQueryData $queryData = null): array
    {
        try {
            $headers = ['X-Shopper-Id' => $shopperId];
            $queryParams = $queryData ? $queryData->toArray() : [];
            
            $response = $this->client->get('/v1/domains', [
                'headers' => $headers,
                'query' => $queryParams
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new DomainsListException(
                'Failed to list domains: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Retrieve the legal agreement(s) required to purchase the specified TLD and add-ons
     *
     * @param string $marketId Unique identifier of the Market used to retrieve/translate Legal Agreements
     * @param GetAgreementsQueryData $queryData Query parameters
     * @return array Legal agreements
     * @throws DomainsAgreementsException
     */
    public function getAgreements(string $marketId, GetAgreementsQueryData $queryData): array
    {
        try {
            $headers = ['X-Market-Id' => $marketId];
            $queryParams = $queryData->toArray();
            
            $response = $this->client->get('/v1/domains/agreements', [
                'headers' => $headers,
                'query' => $queryParams
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new DomainsAgreementsException(
                'Failed to get domain agreements: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Determine whether or not the specified domain is available for purchase
     *
     * @param CheckDomainAvailabilityQueryData $queryData Query parameters
     * @return array Domain availability information
     * @throws DomainsAvailabilityException
     */
    public function checkDomainAvailability(CheckDomainAvailabilityQueryData $queryData): array
    {
        try {
            $queryParams = $queryData->toArray();
            
            $response = $this->client->get('/v1/domains/available', [
                'query' => $queryParams
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new DomainsAvailabilityException(
                'Failed to check domain availability: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Determine whether or not the specified domains are available for purchase
     *
     * @param CheckDomainsAvailabilityData $data Domain names and check type
     * @return array Domain availability information for multiple domains
     * @throws DomainsAvailabilityException
     */
    public function checkDomainsAvailability(CheckDomainsAvailabilityData $data): array
    {
        try {
            $body = $data->toArray();
            $queryParams = [];
            
            if (isset($body['checkType'])) {
                $queryParams['checkType'] = $body['checkType'];
                unset($body['checkType']);
            }
            
            $response = $this->client->post('/v1/domains/available', [
                'json' => $body,
                'query' => $queryParams
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new DomainsAvailabilityException(
                'Failed to check domains availability: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Validate the request body using the Domain Contact Validation Schema for specified domains
     *
     * @param ValidateContactsData $data Contact validation data
     * @param string|null $marketId MarketId in which the request is being made
     * @param int|null $privateLabelId PrivateLabelId to operate as, if different from JWT
     * @return array Validation results
     * @throws DomainsContactValidationException
     */
    public function validateContacts(ValidateContactsData $data, ?string $marketId = null, ?int $privateLabelId = null): array
    {
        try {
            $headers = [];
            $queryParams = [];
            
            if ($privateLabelId !== null) {
                $headers['X-Private-Label-Id'] = $privateLabelId;
            }
            
            if ($marketId !== null) {
                $queryParams['marketId'] = $marketId;
            }
            
            $response = $this->client->post('/v1/domains/contacts/validate', [
                'headers' => $headers,
                'query' => $queryParams,
                'json' => $data->toArray()
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new DomainsContactValidationException(
                'Failed to validate domain contacts: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Purchase and register the specified Domain
     *
     * @param string $shopperId The Shopper for whom the domain should be purchased
     * @param PurchaseDomainData $data Domain purchase data
     * @return array Purchase result
     * @throws DomainsPurchaseException
     */
    public function purchaseDomain(string $shopperId, PurchaseDomainData $data): array
    {
        try {
            $headers = ['X-Shopper-Id' => $shopperId];
            
            $response = $this->client->post('/v1/domains/purchase', [
                'headers' => $headers,
                'json' => $data->toArray()
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new DomainsPurchaseException(
                'Failed to purchase domain: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }
}
