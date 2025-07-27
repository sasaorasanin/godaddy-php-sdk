<?php

namespace GoDaddy\Services\Domains\v1;

use GoDaddy\Services\BaseService;
use GoDaddy\Services\Domains\v1\DTO\ListDomainsQueryData;
use GoDaddy\Services\Domains\v1\DTO\GetAgreementsQueryData;
use GoDaddy\Services\Domains\v1\DTO\CheckDomainAvailabilityQueryData;
use GoDaddy\Services\Domains\v1\DTO\CheckDomainsAvailabilityData;
use GoDaddy\Services\Domains\v1\DTO\ValidateContactsData;
use GoDaddy\Services\Domains\v1\DTO\PurchaseDomainData;
use GoDaddy\Services\Domains\v1\DTO\PurchaseSchemaData;
use GoDaddy\Services\Domains\v1\DTO\ValidatePurchaseData;
use GoDaddy\Services\Domains\v1\DTO\SuggestDomainsQueryData;
use GoDaddy\Services\Domains\v1\DTO\SuggestedDomainData;
use GoDaddy\Services\Domains\v1\DTO\TldData;
use GoDaddy\Services\Domains\v1\DTO\DomainDetailsData;
use GoDaddy\Services\Domains\v1\DTO\UpdateDomainData;
use GoDaddy\Services\Domains\v1\DTO\UpdateDomainContactsData;
use GoDaddy\Services\Domains\v1\DTO\PurchasePrivacyData;
use GoDaddy\Services\Domains\v1\DTO\PurchasePrivacyResponseData;
use GoDaddy\Services\Domains\v1\DTO\DnsRecordData;
use GoDaddy\Services\Domains\v1\DTO\GetDnsRecordsQueryData;
use GoDaddy\Services\Domains\v1\DTO\DnsRecordUpdateData;
use GoDaddy\Services\Domains\v1\DTO\RenewDomainData;
use GoDaddy\Services\Domains\v1\DTO\TransferDomainData;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsListException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsAgreementsException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsAvailabilityException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsContactValidationException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsPurchaseException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsPurchaseSchemaException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsPurchaseValidationException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsSuggestException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsTldsException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsCancelException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsDetailsException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsUpdateException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsContactsUpdateException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsPrivacyCancelException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsPrivacyPurchaseException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsRecordsAddException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsRecordsReplaceException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsRecordsGetException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsRecordsUpdateException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsRecordsDeleteException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsRecordsReplaceByTypeException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsRenewException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsTransferException;
use GoDaddy\Services\Domains\v1\Exceptions\DomainsVerifyRegistrantEmailException;
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

    /**
     * Validate the request body using the Domain Purchase Schema for the specified TLD
     *
     * @param ValidatePurchaseData $data Purchase validation data
     * @return array Validation results
     * @throws DomainsPurchaseValidationException
     */
    public function validatePurchase(ValidatePurchaseData $data): array
    {
        try {
            $response = $this->client->post('/v1/domains/purchase/validate', [
                'json' => $data->toArray()
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new DomainsPurchaseValidationException(
                'Failed to validate purchase data: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Retrieve the schema to be submitted when registering a Domain for the specified TLD
     *
     * @param string $tld The Top-Level Domain whose schema should be retrieved
     * @return PurchaseSchemaData Purchase schema data
     * @throws DomainsPurchaseSchemaException
     */
    public function getPurchaseSchema(string $tld): PurchaseSchemaData
    {
        try {
            $response = $this->client->get("/v1/domains/purchase/schema/{$tld}");
            
            $data = json_decode($response->getBody()->getContents(), true);
            
            return PurchaseSchemaData::fromArray($data);
        } catch (GuzzleException $e) {
            throw new DomainsPurchaseSchemaException(
                'Failed to get purchase schema: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Suggest alternate Domain names based on a seed Domain, a set of keywords, or the shopper's purchase history
     *
     * @param string $shopperId Shopper ID for which the suggestions are being generated
     * @param SuggestDomainsQueryData $queryData Query parameters
     * @return SuggestedDomainData[] Array of suggested domains
     * @throws DomainsSuggestException
     */
    public function suggestDomains(string $shopperId, SuggestDomainsQueryData $queryData): array
    {
        try {
            $headers = ['X-Shopper-Id' => $shopperId];
            $queryParams = $queryData->toArray();
            
            $response = $this->client->get('/v1/domains/suggest', [
                'headers' => $headers,
                'query' => $queryParams
            ]);
            
            $data = json_decode($response->getBody()->getContents(), true);
            
            return array_map(fn($item) => SuggestedDomainData::fromArray($item), $data);
        } catch (GuzzleException $e) {
            throw new DomainsSuggestException(
                'Failed to suggest domains: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Retrieves a list of TLDs supported and enabled for sale
     *
     * @return TldData[] Array of TLD data
     * @throws DomainsTldsException
     */
    public function getTlds(): array
    {
        try {
            $response = $this->client->get('/v1/domains/tlds');
            
            $data = json_decode($response->getBody()->getContents(), true);
            
            return array_map(fn($item) => TldData::fromArray($item), $data);
        } catch (GuzzleException $e) {
            throw new DomainsTldsException(
                'Failed to get TLDs: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Cancel a purchased domain
     *
     * @param string $domain Domain to cancel
     * @return void
     * @throws DomainsCancelException
     */
    public function cancelDomain(string $domain): void
    {
        try {
            $this->client->delete("/v1/domains/{$domain}");
        } catch (GuzzleException $e) {
            throw new DomainsCancelException(
                'Failed to cancel domain: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Submit a privacy cancellation request for the given domain
     *
     * @param string $domain Domain whose privacy is to be cancelled
     * @param string|null $shopperId Shopper ID of the owner of the domain
     * @return void
     * @throws DomainsPrivacyCancelException
     */
    public function cancelDomainPrivacy(string $domain, ?string $shopperId = null): void
    {
        try {
            $headers = [];
            if ($shopperId !== null) {
                $headers['X-Shopper-Id'] = $shopperId;
            }
            
            $this->client->delete("/v1/domains/{$domain}/privacy", [
                'headers' => $headers
            ]);
        } catch (GuzzleException $e) {
            throw new DomainsPrivacyCancelException(
                'Failed to cancel domain privacy: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Purchase privacy for a specified domain
     *
     * @param string $domain Domain for which to purchase privacy
     * @param PurchasePrivacyData $data Options for purchasing privacy
     * @param string|null $shopperId Shopper ID of the owner of the domain
     * @return PurchasePrivacyResponseData Purchase result
     * @throws DomainsPrivacyPurchaseException
     */
    public function purchaseDomainPrivacy(string $domain, PurchasePrivacyData $data, ?string $shopperId = null): PurchasePrivacyResponseData
    {
        try {
            $headers = [];
            if ($shopperId !== null) {
                $headers['X-Shopper-Id'] = $shopperId;
            }
            
            $response = $this->client->post("/v1/domains/{$domain}/privacy/purchase", [
                'headers' => $headers,
                'json' => $data->toArray()
            ]);
            
            $responseData = json_decode($response->getBody()->getContents(), true);
            
            return PurchasePrivacyResponseData::fromArray($responseData);
        } catch (GuzzleException $e) {
            throw new DomainsPrivacyPurchaseException(
                'Failed to purchase domain privacy: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Retrieve details for the specified Domain
     *
     * @param string $shopperId Shopper ID expected to own the specified domain
     * @param string $domain Domain name whose details are to be retrieved
     * @return DomainDetailsData Domain details
     * @throws DomainsDetailsException
     */
    public function getDomainDetails(string $shopperId, string $domain): DomainDetailsData
    {
        try {
            $headers = ['X-Shopper-Id' => $shopperId];
            
            $response = $this->client->get("/v1/domains/{$domain}", [
                'headers' => $headers
            ]);
            
            $data = json_decode($response->getBody()->getContents(), true);
            
            return DomainDetailsData::fromArray($data);
        } catch (GuzzleException $e) {
            throw new DomainsDetailsException(
                'Failed to get domain details: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Update details for the specified Domain
     *
     * @param string $domain Domain whose details are to be updated
     * @param UpdateDomainData $data Changes to apply to existing Domain
     * @param string|null $shopperId Shopper for whom Domain is to be updated
     * @return void
     * @throws DomainsUpdateException
     */
    public function updateDomain(string $domain, UpdateDomainData $data, ?string $shopperId = null): void
    {
        try {
            $headers = [];
            if ($shopperId !== null) {
                $headers['X-Shopper-Id'] = $shopperId;
            }
            
            $this->client->patch("/v1/domains/{$domain}", [
                'headers' => $headers,
                'json' => $data->toArray()
            ]);
        } catch (GuzzleException $e) {
            throw new DomainsUpdateException(
                'Failed to update domain: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Update domain contacts
     *
     * @param string $domain Domain whose Contacts are to be updated
     * @param UpdateDomainContactsData $contacts Changes to apply to existing Contacts
     * @param string|null $shopperId Shopper for whom domain contacts are to be updated
     * @return void
     * @throws DomainsContactsUpdateException
     */
    public function updateDomainContacts(string $domain, UpdateDomainContactsData $contacts, ?string $shopperId = null): void
    {
        try {
            $headers = [];
            if ($shopperId !== null) {
                $headers['X-Shopper-Id'] = $shopperId;
            }
            
            $this->client->patch("/v1/domains/{$domain}/contacts", [
                'headers' => $headers,
                'json' => $contacts->toArray()
            ]);
        } catch (GuzzleException $e) {
            throw new DomainsContactsUpdateException(
                'Failed to update domain contacts: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Add the specified DNS Records to the specified Domain
     *
     * @param string $domain Domain whose DNS Records are to be augmented
     * @param DnsRecordData[] $records DNS Records to add to whatever currently exists
     * @param string|null $shopperId Shopper ID which owns the domain
     * @return void
     * @throws DomainsRecordsAddException
     */
    public function addDomainRecords(string $domain, array $records, ?string $shopperId = null): void
    {
        try {
            $headers = [];
            if ($shopperId !== null) {
                $headers['X-Shopper-Id'] = $shopperId;
            }
            
            $recordsArray = array_map(fn($record) => $record->toArray(), $records);
            
            $this->client->patch("/v1/domains/{$domain}/records", [
                'headers' => $headers,
                'json' => $recordsArray
            ]);
        } catch (GuzzleException $e) {
            throw new DomainsRecordsAddException(
                'Failed to add domain records: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Replace all DNS Records for the specified Domain
     *
     * @param string $domain Domain whose DNS Records are to be replaced
     * @param DnsRecordData[] $records DNS Records to replace whatever currently exists
     * @param string|null $shopperId Shopper ID which owns the domain
     * @return void
     * @throws DomainsRecordsReplaceException
     */
    public function replaceDomainRecords(string $domain, array $records, ?string $shopperId = null): void
    {
        try {
            $headers = [];
            if ($shopperId !== null) {
                $headers['X-Shopper-Id'] = $shopperId;
            }
            
            $recordsArray = array_map(fn($record) => $record->toArray(), $records);
            
            $this->client->put("/v1/domains/{$domain}/records", [
                'headers' => $headers,
                'json' => $recordsArray
            ]);
        } catch (GuzzleException $e) {
            throw new DomainsRecordsReplaceException(
                'Failed to replace domain records: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Replace all DNS Records for the specified Domain with the specified Type and Name
     *
     * @param string $domain Domain whose DNS Records are to be replaced
     * @param string $type DNS Record Type for which DNS Records are to be replaced
     * @param string $name DNS Record Name for which DNS Records are to be replaced
     * @param DnsRecordUpdateData[] $records DNS Records to replace whatever currently exists
     * @param string|null $shopperId Shopper ID which owns the domain
     * @return void
     * @throws DomainsRecordsUpdateException
     */
    public function updateDomainRecords(string $domain, string $type, string $name, array $records, ?string $shopperId = null): void
    {
        try {
            $headers = [];
            if ($shopperId !== null) {
                $headers['X-Shopper-Id'] = $shopperId;
            }
            
            $recordsArray = array_map(fn($record) => $record->toArray(), $records);
            
            $this->client->put("/v1/domains/{$domain}/records/{$type}/{$name}", [
                'headers' => $headers,
                'json' => $recordsArray
            ]);
        } catch (GuzzleException $e) {
            throw new DomainsRecordsUpdateException(
                'Failed to update domain records: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Retrieve DNS Records for the specified Domain, optionally with the specified Type and/or Name
     *
     * @param string $domain Domain whose DNS Records are to be retrieved
     * @param string $type DNS Record Type for which DNS Records are to be retrieved
     * @param string $name DNS Record Name for which DNS Records are to be retrieved
     * @param GetDnsRecordsQueryData|null $queryData Optional query parameters
     * @param string|null $shopperId Shopper ID which owns the domain
     * @return DnsRecordData[] Array of DNS records
     * @throws DomainsRecordsGetException
     */
    public function getDomainRecords(string $domain, string $type, string $name, ?GetDnsRecordsQueryData $queryData = null, ?string $shopperId = null): array
    {
        try {
            $headers = [];
            if ($shopperId !== null) {
                $headers['X-Shopper-Id'] = $shopperId;
            }
            
            $queryParams = $queryData ? $queryData->toArray() : [];
            
            $response = $this->client->get("/v1/domains/{$domain}/records/{$type}/{$name}", [
                'headers' => $headers,
                'query' => $queryParams
            ]);
            
            $data = json_decode($response->getBody()->getContents(), true);
            
            return array_map(fn($item) => DnsRecordData::fromArray($item), $data);
        } catch (GuzzleException $e) {
            throw new DomainsRecordsGetException(
                'Failed to get domain records: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Delete all DNS Records for the specified Domain with the specified Type and Name
     *
     * @param string $domain Domain whose DNS Records are to be deleted
     * @param string $type DNS Record Type for which DNS Records are to be deleted
     * @param string $name DNS Record Name for which DNS Records are to be deleted
     * @param string|null $shopperId Shopper ID which owns the domain
     * @return void
     * @throws DomainsRecordsDeleteException
     */
    public function deleteDomainRecords(string $domain, string $type, string $name, ?string $shopperId = null): void
    {
        try {
            $headers = [];
            if ($shopperId !== null) {
                $headers['X-Shopper-Id'] = $shopperId;
            }
            
            $this->client->delete("/v1/domains/{$domain}/records/{$type}/{$name}", [
                'headers' => $headers
            ]);
        } catch (GuzzleException $e) {
            throw new DomainsRecordsDeleteException(
                'Failed to delete domain records: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Replace all DNS Records for the specified Domain with the specified Type
     *
     * @param string $domain Domain whose DNS Records are to be replaced
     * @param string $type DNS Record Type for which DNS Records are to be replaced
     * @param DnsRecordData[] $records DNS Records to replace whatever currently exists
     * @param string|null $shopperId Shopper ID which owns the domain
     * @return void
     * @throws DomainsRecordsReplaceByTypeException
     */
    public function replaceDomainRecordsByType(string $domain, string $type, array $records, ?string $shopperId = null): void
    {
        try {
            $headers = [];
            if ($shopperId !== null) {
                $headers['X-Shopper-Id'] = $shopperId;
            }
            
            $recordsArray = array_map(fn($record) => $record->toArray(), $records);
            
            $this->client->put("/v1/domains/{$domain}/records/{$type}", [
                'headers' => $headers,
                'json' => $recordsArray
            ]);
        } catch (GuzzleException $e) {
            throw new DomainsRecordsReplaceByTypeException(
                'Failed to replace domain records by type: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Renew the specified Domain
     *
     * @param string $domain Domain to renew
     * @param RenewDomainData|null $data Options for renewing existing Domain
     * @param string|null $shopperId Shopper for whom Domain is to be renewed
     * @return array Renewal result
     * @throws DomainsRenewException
     */
    public function renewDomain(string $domain, ?RenewDomainData $data = null, ?string $shopperId = null): array
    {
        try {
            $headers = [];
            if ($shopperId !== null) {
                $headers['X-Shopper-Id'] = $shopperId;
            }
            
            $requestData = [];
            if ($data !== null) {
                $requestData = $data->toArray();
            }
            
            $response = $this->client->post("/v1/domains/{$domain}/renew", [
                'headers' => $headers,
                'json' => $requestData
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new DomainsRenewException(
                'Failed to renew domain: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Purchase and start or restart transfer process
     *
     * @param string $domain Domain to transfer in
     * @param TransferDomainData $data Details for domain transfer purchase
     * @param string|null $shopperId The Shopper to whom the domain should be transfered
     * @return array Transfer result
     * @throws DomainsTransferException
     */
    public function transferDomain(string $domain, TransferDomainData $data, ?string $shopperId = null): array
    {
        try {
            $headers = [];
            if ($shopperId !== null) {
                $headers['X-Shopper-Id'] = $shopperId;
            }
            
            $response = $this->client->post("/v1/domains/{$domain}/transfer", [
                'headers' => $headers,
                'json' => $data->toArray()
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new DomainsTransferException(
                'Failed to transfer domain: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Re-send Contact E-mail Verification for specified Domain
     *
     * @param string $domain Domain whose Contact E-mail should be verified
     * @param string|null $shopperId Shopper for whom domain contact e-mail should be verified
     * @return void
     * @throws DomainsVerifyRegistrantEmailException
     */
    public function verifyRegistrantEmail(string $domain, ?string $shopperId = null): void
    {
        try {
            $headers = [];
            if ($shopperId !== null) {
                $headers['X-Shopper-Id'] = $shopperId;
            }
            
            $this->client->post("/v1/domains/{$domain}/verifyRegistrantEmail", [
                'headers' => $headers
            ]);
        } catch (GuzzleException $e) {
            throw new DomainsVerifyRegistrantEmailException(
                'Failed to verify registrant email: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }
}
