<?php

namespace GoDaddy\Services\Domains\v2;

use GoDaddy\Services\BaseService;
use GoDaddy\Services\Domains\v2\DTO\GetDomainDetailsQueryData;
use GoDaddy\Services\Domains\v2\DTO\DomainDetailsV2Data;
use GoDaddy\Services\Domains\v2\DTO\DnssecRecordData;
use GoDaddy\Services\Domains\v2\DTO\NameServerUpdateData;
use GoDaddy\Services\Domains\v2\DTO\PrivacyForwardingData;
use GoDaddy\Services\Domains\v2\DTO\DomainRedeemData;
use GoDaddy\Services\Domains\v2\DTO\DomainRenewData;
use GoDaddy\Services\Domains\v2\DTO\DomainTransferData;
use GoDaddy\Services\Domains\v2\DTO\DomainForwardData;
use GoDaddy\Services\Domains\v2\DTO\NotificationOptInData;
use GoDaddy\Services\Domains\v2\DTO\DomainRegisterData;
use GoDaddy\Services\Domains\v2\Enums\ActionType;
use GoDaddy\Services\Domains\v2\Exceptions\DomainsDetailsV2Exception;
use GoDaddy\Services\Domains\v2\Exceptions\DomainsChangeOfRegistrantCancelException;
use GoDaddy\Services\Domains\v2\Exceptions\DnssecException;
use GoDaddy\Services\Domains\v2\Exceptions\NameServerException;
use GoDaddy\Services\Domains\v2\Exceptions\PrivacyForwardingException;
use GoDaddy\Services\Domains\v2\Exceptions\DomainRedeemException;
use GoDaddy\Services\Domains\v2\Exceptions\DomainRenewException;
use GoDaddy\Services\Domains\v2\Exceptions\DomainTransferException;
use GoDaddy\Services\Domains\v2\Exceptions\DomainForwardException;
use GoDaddy\Services\Domains\v2\Exceptions\DomainActionException;
use GoDaddy\Services\Domains\v2\Exceptions\NotificationException;
use GoDaddy\Services\Domains\v2\Exceptions\DomainRegisterException;
use GoDaddy\Services\Domains\v2\Exceptions\MaintenanceException;
use GoDaddy\Services\Domains\v2\Exceptions\UsageException;
use GoDaddy\Services\Domains\v2\Exceptions\DomainContactsException;
use GuzzleHttp\Exception\GuzzleException;

class DomainsService extends BaseService
{
    /**
     * Retrieve details for the specified Domain
     *
     * @param string $customerId The Customer identifier
     * @param string $domain Domain name whose details are to be retrieved
     * @param GetDomainDetailsQueryData|null $queryData Optional query parameters
     * @param string|null $requestId A client provided identifier for tracking this request
     * @return DomainDetailsV2Data Domain details
     * @throws DomainsDetailsV2Exception
     */
    public function getDomainDetails(string $customerId, string $domain, ?GetDomainDetailsQueryData $queryData = null, ?string $requestId = null): DomainDetailsV2Data
    {
        try {
            $headers = [];
            if ($requestId !== null) {
                $headers['X-Request-Id'] = $requestId;
            }
            
            $queryParams = $queryData ? $queryData->toArray() : [];
            
            $response = $this->client->get("/v2/customers/{$customerId}/domains/{$domain}", [
                'headers' => $headers,
                'query' => $queryParams
            ]);
            
            $data = json_decode($response->getBody()->getContents(), true);
            
            return DomainDetailsV2Data::fromArray($data);
        } catch (GuzzleException $e) {
            throw new DomainsDetailsV2Exception(
                'Failed to get domain details: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Cancels a pending change of registrant request for a given domain
     *
     * @param string $customerId The Customer identifier
     * @param string $domain Domain whose change of registrant is to be cancelled
     * @param string|null $requestId A client provided identifier for tracking this request
     * @return void
     * @throws DomainsChangeOfRegistrantCancelException
     */
    public function cancelChangeOfRegistrant(string $customerId, string $domain, ?string $requestId = null): void
    {
        try {
            $headers = [];
            if ($requestId !== null) {
                $headers['X-Request-Id'] = $requestId;
            }
            
            $this->client->delete("/v2/customers/{$customerId}/domains/{$domain}/changeOfRegistrant", [
                'headers' => $headers
            ]);
        } catch (GuzzleException $e) {
            throw new DomainsChangeOfRegistrantCancelException(
                'Failed to cancel change of registrant: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Add DNSSEC records to the domain
     *
     * @param string $customerId The Customer identifier
     * @param string $domain Domain to add DNSSEC records for
     * @param array $records Array of DnssecRecordData objects
     * @param string|null $requestId A client provided identifier for tracking this request
     * @return void
     * @throws DnssecException
     */
    public function addDnssecRecords(string $customerId, string $domain, array $records, ?string $requestId = null): void
    {
        try {
            $headers = [];
            if ($requestId !== null) {
                $headers['X-Request-Id'] = $requestId;
            }
            
            $data = array_map(fn($record) => $record->toArray(), $records);
            
            $this->client->patch("/v2/customers/{$customerId}/domains/{$domain}/dnssecRecords", [
                'headers' => $headers,
                'json' => $data
            ]);
        } catch (GuzzleException $e) {
            throw new DnssecException(
                'Failed to add DNSSEC records: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Remove DNSSEC records from the domain
     *
     * @param string $customerId The Customer identifier
     * @param string $domain Domain to remove DNSSEC records from
     * @param array $records Array of DnssecRecordData objects
     * @param string|null $requestId A client provided identifier for tracking this request
     * @return void
     * @throws DnssecException
     */
    public function removeDnssecRecords(string $customerId, string $domain, array $records, ?string $requestId = null): void
    {
        try {
            $headers = [];
            if ($requestId !== null) {
                $headers['X-Request-Id'] = $requestId;
            }
            
            $data = array_map(fn($record) => $record->toArray(), $records);
            
            $this->client->delete("/v2/customers/{$customerId}/domains/{$domain}/dnssecRecords", [
                'headers' => $headers,
                'json' => $data
            ]);
        } catch (GuzzleException $e) {
            throw new DnssecException(
                'Failed to remove DNSSEC records: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Replace name servers on the domain
     *
     * @param string $customerId The Customer identifier
     * @param string $domain Domain whose name servers are to be replaced
     * @param NameServerUpdateData $data Name server update data
     * @param string|null $requestId A client provided identifier for tracking this request
     * @return void
     * @throws NameServerException
     */
    public function updateNameServers(string $customerId, string $domain, NameServerUpdateData $data, ?string $requestId = null): void
    {
        try {
            $headers = [];
            if ($requestId !== null) {
                $headers['X-Request-Id'] = $requestId;
            }
            
            $this->client->put("/v2/customers/{$customerId}/domains/{$domain}/nameServers", [
                'headers' => $headers,
                'json' => $data->toArray()
            ]);
        } catch (GuzzleException $e) {
            throw new NameServerException(
                'Failed to update name servers: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Get privacy email forwarding settings
     *
     * @param string $customerId The Customer identifier
     * @param string $domain Domain name
     * @param string|null $requestId A client provided identifier for tracking this request
     * @return PrivacyForwardingData
     * @throws PrivacyForwardingException
     */
    public function getPrivacyForwarding(string $customerId, string $domain, ?string $requestId = null): PrivacyForwardingData
    {
        try {
            $headers = [];
            if ($requestId !== null) {
                $headers['X-Request-Id'] = $requestId;
            }
            
            $response = $this->client->get("/v2/customers/{$customerId}/domains/{$domain}/privacy/forwarding", [
                'headers' => $headers
            ]);
            
            $data = json_decode($response->getBody()->getContents(), true);
            
            return PrivacyForwardingData::fromArray($data);
        } catch (GuzzleException $e) {
            throw new PrivacyForwardingException(
                'Failed to get privacy forwarding settings: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Update privacy email forwarding settings
     *
     * @param string $customerId The Customer identifier
     * @param string $domain Domain name
     * @param PrivacyForwardingData $data Privacy forwarding data
     * @param string|null $requestId A client provided identifier for tracking this request
     * @return void
     * @throws PrivacyForwardingException
     */
    public function updatePrivacyForwarding(string $customerId, string $domain, PrivacyForwardingData $data, ?string $requestId = null): void
    {
        try {
            $headers = [];
            if ($requestId !== null) {
                $headers['X-Request-Id'] = $requestId;
            }
            
            $this->client->patch("/v2/customers/{$customerId}/domains/{$domain}/privacy/forwarding", [
                'headers' => $headers,
                'json' => $data->toArray()
            ]);
        } catch (GuzzleException $e) {
            throw new PrivacyForwardingException(
                'Failed to update privacy forwarding settings: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Redeem an expired domain
     *
     * @param string $customerId The Customer identifier
     * @param string $domain Domain to redeem
     * @param DomainRedeemData $data Redemption data
     * @param string|null $requestId A client provided identifier for tracking this request
     * @return array
     * @throws DomainRedeemException
     */
    public function redeemDomain(string $customerId, string $domain, DomainRedeemData $data, ?string $requestId = null): array
    {
        try {
            $headers = [];
            if ($requestId !== null) {
                $headers['X-Request-Id'] = $requestId;
            }
            
            $response = $this->client->post("/v2/customers/{$customerId}/domains/{$domain}/redeem", [
                'headers' => $headers,
                'json' => $data->toArray()
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new DomainRedeemException(
                'Failed to redeem domain: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Renew a domain
     *
     * @param string $customerId The Customer identifier
     * @param string $domain Domain to renew
     * @param DomainRenewData $data Renewal data
     * @param string|null $requestId A client provided identifier for tracking this request
     * @return array
     * @throws DomainRenewException
     */
    public function renewDomain(string $customerId, string $domain, DomainRenewData $data, ?string $requestId = null): array
    {
        try {
            $headers = [];
            if ($requestId !== null) {
                $headers['X-Request-Id'] = $requestId;
            }
            
            $response = $this->client->post("/v2/customers/{$customerId}/domains/{$domain}/renew", [
                'headers' => $headers,
                'json' => $data->toArray()
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new DomainRenewException(
                'Failed to renew domain: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Transfer a domain
     *
     * @param string $customerId The Customer identifier
     * @param string $domain Domain to transfer
     * @param DomainTransferData $data Transfer data
     * @param string|null $requestId A client provided identifier for tracking this request
     * @return array
     * @throws DomainTransferException
     */
    public function transferDomain(string $customerId, string $domain, DomainTransferData $data, ?string $requestId = null): array
    {
        try {
            $headers = [];
            if ($requestId !== null) {
                $headers['X-Request-Id'] = $requestId;
            }
            
            $response = $this->client->post("/v2/customers/{$customerId}/domains/{$domain}/transfer", [
                'headers' => $headers,
                'json' => $data->toArray()
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new DomainTransferException(
                'Failed to transfer domain: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Validate domain transfer
     *
     * @param string $customerId The Customer identifier
     * @param string $domain Domain to validate transfer for
     * @param DomainTransferData $data Transfer data
     * @param string|null $requestId A client provided identifier for tracking this request
     * @return array
     * @throws DomainTransferException
     */
    public function validateTransfer(string $customerId, string $domain, DomainTransferData $data, ?string $requestId = null): array
    {
        try {
            $headers = [];
            if ($requestId !== null) {
                $headers['X-Request-Id'] = $requestId;
            }
            
            $response = $this->client->post("/v2/customers/{$customerId}/domains/{$domain}/transfer/validate", [
                'headers' => $headers,
                'json' => $data->toArray()
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new DomainTransferException(
                'Failed to validate transfer: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Accept transfer in
     *
     * @param string $customerId The Customer identifier
     * @param string $domain Domain to accept transfer for
     * @param string|null $requestId A client provided identifier for tracking this request
     * @return array
     * @throws DomainTransferException
     */
    public function acceptTransferIn(string $customerId, string $domain, ?string $requestId = null): array
    {
        try {
            $headers = [];
            if ($requestId !== null) {
                $headers['X-Request-Id'] = $requestId;
            }
            
            $response = $this->client->post("/v2/customers/{$customerId}/domains/{$domain}/transferInAccept", [
                'headers' => $headers
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new DomainTransferException(
                'Failed to accept transfer in: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Cancel transfer in
     *
     * @param string $customerId The Customer identifier
     * @param string $domain Domain to cancel transfer for
     * @param string|null $requestId A client provided identifier for tracking this request
     * @return array
     * @throws DomainTransferException
     */
    public function cancelTransferIn(string $customerId, string $domain, ?string $requestId = null): array
    {
        try {
            $headers = [];
            if ($requestId !== null) {
                $headers['X-Request-Id'] = $requestId;
            }
            
            $response = $this->client->post("/v2/customers/{$customerId}/domains/{$domain}/transferInCancel", [
                'headers' => $headers
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new DomainTransferException(
                'Failed to cancel transfer in: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Restart transfer in
     *
     * @param string $customerId The Customer identifier
     * @param string $domain Domain to restart transfer for
     * @param string|null $requestId A client provided identifier for tracking this request
     * @return array
     * @throws DomainTransferException
     */
    public function restartTransferIn(string $customerId, string $domain, ?string $requestId = null): array
    {
        try {
            $headers = [];
            if ($requestId !== null) {
                $headers['X-Request-Id'] = $requestId;
            }
            
            $response = $this->client->post("/v2/customers/{$customerId}/domains/{$domain}/transferInRestart", [
                'headers' => $headers
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new DomainTransferException(
                'Failed to restart transfer in: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Retry transfer in
     *
     * @param string $customerId The Customer identifier
     * @param string $domain Domain to retry transfer for
     * @param string|null $requestId A client provided identifier for tracking this request
     * @return array
     * @throws DomainTransferException
     */
    public function retryTransferIn(string $customerId, string $domain, ?string $requestId = null): array
    {
        try {
            $headers = [];
            if ($requestId !== null) {
                $headers['X-Request-Id'] = $requestId;
            }
            
            $response = $this->client->post("/v2/customers/{$customerId}/domains/{$domain}/transferInRetry", [
                'headers' => $headers
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new DomainTransferException(
                'Failed to retry transfer in: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Initiate transfer out
     *
     * @param string $customerId The Customer identifier
     * @param string $domain Domain to transfer out
     * @param string|null $requestId A client provided identifier for tracking this request
     * @return array
     * @throws DomainTransferException
     */
    public function transferOut(string $customerId, string $domain, ?string $requestId = null): array
    {
        try {
            $headers = [];
            if ($requestId !== null) {
                $headers['X-Request-Id'] = $requestId;
            }
            
            $response = $this->client->post("/v2/customers/{$customerId}/domains/{$domain}/transferOut", [
                'headers' => $headers
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new DomainTransferException(
                'Failed to transfer out: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Accept transfer out
     *
     * @param string $customerId The Customer identifier
     * @param string $domain Domain to accept transfer out for
     * @param string|null $requestId A client provided identifier for tracking this request
     * @return array
     * @throws DomainTransferException
     */
    public function acceptTransferOut(string $customerId, string $domain, ?string $requestId = null): array
    {
        try {
            $headers = [];
            if ($requestId !== null) {
                $headers['X-Request-Id'] = $requestId;
            }
            
            $response = $this->client->post("/v2/customers/{$customerId}/domains/{$domain}/transferOutAccept", [
                'headers' => $headers
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new DomainTransferException(
                'Failed to accept transfer out: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Reject transfer out
     *
     * @param string $customerId The Customer identifier
     * @param string $domain Domain to reject transfer out for
     * @param string|null $requestId A client provided identifier for tracking this request
     * @return array
     * @throws DomainTransferException
     */
    public function rejectTransferOut(string $customerId, string $domain, ?string $requestId = null): array
    {
        try {
            $headers = [];
            if ($requestId !== null) {
                $headers['X-Request-Id'] = $requestId;
            }
            
            $response = $this->client->post("/v2/customers/{$customerId}/domains/{$domain}/transferOutReject", [
                'headers' => $headers
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new DomainTransferException(
                'Failed to reject transfer out: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Get domain forwards
     *
     * @param string $customerId The Customer identifier
     * @param string $fqdn Fully qualified domain name
     * @param string|null $requestId A client provided identifier for tracking this request
     * @return DomainForwardData
     * @throws DomainForwardException
     */
    public function getDomainForward(string $customerId, string $fqdn, ?string $requestId = null): DomainForwardData
    {
        try {
            $headers = [];
            if ($requestId !== null) {
                $headers['X-Request-Id'] = $requestId;
            }
            
            $response = $this->client->get("/v2/customers/{$customerId}/domains/forwards/{$fqdn}", [
                'headers' => $headers
            ]);
            
            $data = json_decode($response->getBody()->getContents(), true);
            
            return DomainForwardData::fromArray($data);
        } catch (GuzzleException $e) {
            throw new DomainForwardException(
                'Failed to get domain forward: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Create domain forward
     *
     * @param string $customerId The Customer identifier
     * @param string $fqdn Fully qualified domain name
     * @param DomainForwardData $data Forward data
     * @param string|null $requestId A client provided identifier for tracking this request
     * @return array
     * @throws DomainForwardException
     */
    public function createDomainForward(string $customerId, string $fqdn, DomainForwardData $data, ?string $requestId = null): array
    {
        try {
            $headers = [];
            if ($requestId !== null) {
                $headers['X-Request-Id'] = $requestId;
            }
            
            $response = $this->client->post("/v2/customers/{$customerId}/domains/forwards/{$fqdn}", [
                'headers' => $headers,
                'json' => $data->toArray()
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new DomainForwardException(
                'Failed to create domain forward: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Update domain forward
     *
     * @param string $customerId The Customer identifier
     * @param string $fqdn Fully qualified domain name
     * @param DomainForwardData $data Forward data
     * @param string|null $requestId A client provided identifier for tracking this request
     * @return array
     * @throws DomainForwardException
     */
    public function updateDomainForward(string $customerId, string $fqdn, DomainForwardData $data, ?string $requestId = null): array
    {
        try {
            $headers = [];
            if ($requestId !== null) {
                $headers['X-Request-Id'] = $requestId;
            }
            
            $response = $this->client->put("/v2/customers/{$customerId}/domains/forwards/{$fqdn}", [
                'headers' => $headers,
                'json' => $data->toArray()
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new DomainForwardException(
                'Failed to update domain forward: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Delete domain forward
     *
     * @param string $customerId The Customer identifier
     * @param string $fqdn Fully qualified domain name
     * @param string|null $requestId A client provided identifier for tracking this request
     * @return void
     * @throws DomainForwardException
     */
    public function deleteDomainForward(string $customerId, string $fqdn, ?string $requestId = null): void
    {
        try {
            $headers = [];
            if ($requestId !== null) {
                $headers['X-Request-Id'] = $requestId;
            }
            
            $this->client->delete("/v2/customers/{$customerId}/domains/forwards/{$fqdn}", [
                'headers' => $headers
            ]);
        } catch (GuzzleException $e) {
            throw new DomainForwardException(
                'Failed to delete domain forward: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Get domain actions
     *
     * @param string $customerId The Customer identifier
     * @param string $domain Domain name
     * @param string|null $requestId A client provided identifier for tracking this request
     * @return array
     * @throws DomainActionException
     */
    public function getDomainActions(string $customerId, string $domain, ?string $requestId = null): array
    {
        try {
            $headers = [];
            if ($requestId !== null) {
                $headers['X-Request-Id'] = $requestId;
            }
            
            $response = $this->client->get("/v2/customers/{$customerId}/domains/{$domain}/actions", [
                'headers' => $headers
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new DomainActionException(
                'Failed to get domain actions: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Get specific domain action
     *
     * @param string $customerId The Customer identifier
     * @param string $domain Domain name
     * @param ActionType $type Action type
     * @param string|null $requestId A client provided identifier for tracking this request
     * @return array
     * @throws DomainActionException
     */
    public function getDomainAction(string $customerId, string $domain, ActionType $type, ?string $requestId = null): array
    {
        try {
            $headers = [];
            if ($requestId !== null) {
                $headers['X-Request-Id'] = $requestId;
            }
            
            $response = $this->client->get("/v2/customers/{$customerId}/domains/{$domain}/actions/{$type->value}", [
                'headers' => $headers
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new DomainActionException(
                'Failed to get domain action: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Get notifications
     *
     * @param string $customerId The Customer identifier
     * @param string|null $requestId A client provided identifier for tracking this request
     * @return array
     * @throws NotificationException
     */
    public function getNotifications(string $customerId, ?string $requestId = null): array
    {
        try {
            $headers = [];
            if ($requestId !== null) {
                $headers['X-Request-Id'] = $requestId;
            }
            
            $response = $this->client->get("/v2/customers/{$customerId}/domains/notifications", [
                'headers' => $headers
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new NotificationException(
                'Failed to get notifications: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Opt in to notifications
     *
     * @param string $customerId The Customer identifier
     * @param NotificationOptInData $data Opt-in data
     * @param string|null $requestId A client provided identifier for tracking this request
     * @return array
     * @throws NotificationException
     */
    public function optInNotifications(string $customerId, NotificationOptInData $data, ?string $requestId = null): array
    {
        try {
            $headers = [];
            if ($requestId !== null) {
                $headers['X-Request-Id'] = $requestId;
            }
            
            $response = $this->client->post("/v2/customers/{$customerId}/domains/notifications/optIn", [
                'headers' => $headers,
                'json' => $data->toArray()
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new NotificationException(
                'Failed to opt in to notifications: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Get notification schema
     *
     * @param string $customerId The Customer identifier
     * @param string $type Notification type
     * @param string|null $requestId A client provided identifier for tracking this request
     * @return array
     * @throws NotificationException
     */
    public function getNotificationSchema(string $customerId, string $type, ?string $requestId = null): array
    {
        try {
            $headers = [];
            if ($requestId !== null) {
                $headers['X-Request-Id'] = $requestId;
            }
            
            $response = $this->client->get("/v2/customers/{$customerId}/domains/notifications/schemas/{$type}", [
                'headers' => $headers
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new NotificationException(
                'Failed to get notification schema: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Acknowledge notification
     *
     * @param string $customerId The Customer identifier
     * @param string $notificationId Notification ID
     * @param string|null $requestId A client provided identifier for tracking this request
     * @return array
     * @throws NotificationException
     */
    public function acknowledgeNotification(string $customerId, string $notificationId, ?string $requestId = null): array
    {
        try {
            $headers = [];
            if ($requestId !== null) {
                $headers['X-Request-Id'] = $requestId;
            }
            
            $response = $this->client->post("/v2/customers/{$customerId}/domains/notifications/{$notificationId}/acknowledge", [
                'headers' => $headers
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new NotificationException(
                'Failed to acknowledge notification: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Register a domain
     *
     * @param string $customerId The Customer identifier
     * @param DomainRegisterData $data Registration data
     * @param string|null $requestId A client provided identifier for tracking this request
     * @return array
     * @throws DomainRegisterException
     */
    public function registerDomain(string $customerId, DomainRegisterData $data, ?string $requestId = null): array
    {
        try {
            $headers = [];
            if ($requestId !== null) {
                $headers['X-Request-Id'] = $requestId;
            }
            
            $response = $this->client->post("/v2/customers/{$customerId}/domains/register", [
                'headers' => $headers,
                'json' => $data->toArray()
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new DomainRegisterException(
                'Failed to register domain: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Get registration schema
     *
     * @param string $customerId The Customer identifier
     * @param string $tld Top-level domain
     * @param string|null $requestId A client provided identifier for tracking this request
     * @return array
     * @throws DomainRegisterException
     */
    public function getRegistrationSchema(string $customerId, string $tld, ?string $requestId = null): array
    {
        try {
            $headers = [];
            if ($requestId !== null) {
                $headers['X-Request-Id'] = $requestId;
            }
            
            $response = $this->client->get("/v2/customers/{$customerId}/domains/register/schema/{$tld}", [
                'headers' => $headers
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new DomainRegisterException(
                'Failed to get registration schema: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Validate domain registration
     *
     * @param string $customerId The Customer identifier
     * @param DomainRegisterData $data Registration data
     * @param string|null $requestId A client provided identifier for tracking this request
     * @return array
     * @throws DomainRegisterException
     */
    public function validateRegistration(string $customerId, DomainRegisterData $data, ?string $requestId = null): array
    {
        try {
            $headers = [];
            if ($requestId !== null) {
                $headers['X-Request-Id'] = $requestId;
            }
            
            $response = $this->client->post("/v2/customers/{$customerId}/domains/register/validate", [
                'headers' => $headers,
                'json' => $data->toArray()
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new DomainRegisterException(
                'Failed to validate registration: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Get maintenances
     *
     * @param string|null $requestId A client provided identifier for tracking this request
     * @return array
     * @throws MaintenanceException
     */
    public function getMaintenances(?string $requestId = null): array
    {
        try {
            $headers = [];
            if ($requestId !== null) {
                $headers['X-Request-Id'] = $requestId;
            }
            
            $response = $this->client->get("/v2/domains/maintenances", [
                'headers' => $headers
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new MaintenanceException(
                'Failed to get maintenances: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Get specific maintenance
     *
     * @param string $maintenanceId Maintenance ID
     * @param string|null $requestId A client provided identifier for tracking this request
     * @return array
     * @throws MaintenanceException
     */
    public function getMaintenance(string $maintenanceId, ?string $requestId = null): array
    {
        try {
            $headers = [];
            if ($requestId !== null) {
                $headers['X-Request-Id'] = $requestId;
            }
            
            $response = $this->client->get("/v2/domains/maintenances/{$maintenanceId}", [
                'headers' => $headers
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new MaintenanceException(
                'Failed to get maintenance: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Get domain usage
     *
     * @param string $yyyymm Year and month (YYYYMM format)
     * @param string|null $requestId A client provided identifier for tracking this request
     * @return array
     * @throws UsageException
     */
    public function getUsage(string $yyyymm, ?string $requestId = null): array
    {
        try {
            $headers = [];
            if ($requestId !== null) {
                $headers['X-Request-Id'] = $requestId;
            }
            
            $response = $this->client->get("/v2/domains/usage/{$yyyymm}", [
                'headers' => $headers
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new UsageException(
                'Failed to get usage: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Get domain contacts
     *
     * @param string $customerId The Customer identifier
     * @param string $domain Domain name
     * @param string|null $requestId A client provided identifier for tracking this request
     * @return array
     * @throws DomainContactsException
     */
    public function getDomainContacts(string $customerId, string $domain, ?string $requestId = null): array
    {
        try {
            $headers = [];
            if ($requestId !== null) {
                $headers['X-Request-Id'] = $requestId;
            }
            
            $response = $this->client->get("/v2/customers/{$customerId}/domains/{$domain}/contacts", [
                'headers' => $headers
            ]);
            
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new DomainContactsException(
                'Failed to get domain contacts: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Update domain contacts
     *
     * @param string $customerId The Customer identifier
     * @param string $domain Domain name
     * @param array $contacts Contacts data
     * @param string|null $requestId A client provided identifier for tracking this request
     * @return void
     * @throws DomainContactsException
     */
    public function updateDomainContacts(string $customerId, string $domain, array $contacts, ?string $requestId = null): void
    {
        try {
            $headers = [];
            if ($requestId !== null) {
                $headers['X-Request-Id'] = $requestId;
            }
            
            $this->client->put("/v2/customers/{$customerId}/domains/{$domain}/contacts", [
                'headers' => $headers,
                'json' => $contacts
            ]);
        } catch (GuzzleException $e) {
            throw new DomainContactsException(
                'Failed to update domain contacts: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }
}
