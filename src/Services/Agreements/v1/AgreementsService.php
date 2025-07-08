<?php

namespace GoDaddy\Services\Agreements\v1;

use GoDaddy\Services\BaseService;
use GoDaddy\Services\Agreements\v1\DTO\GetAgreementsData;
use GoDaddy\Services\Agreements\v1\Exceptions\GetAgreementsException;
use GoDaddy\Support\ErrorCode;

class AgreementsService extends BaseService
{
    /**
     * GET /v1/agreements
     * Retrieve Legal Agreements for provided agreement keys
     */
    public function getAgreements(GetAgreementsData $data): array
    {
        try {
            $response = $this->client->get('/v1/agreements', [
                'headers' => $data->toHeaders(),
                'query' => $data->toQuery(),
            ]);
            return $this->decodeResponse($response);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $this->handleHttpException($e, GetAgreementsException::class, ErrorCode::AGREEMENTS_GET_FAILED);
        }
    }
}
