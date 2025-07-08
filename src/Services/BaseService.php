<?php

namespace GoDaddy\Services;

use GuzzleHttp\Client;
use GoDaddy\Support\ErrorCode;
use GoDaddy\Exceptions\{
    UnauthorizedException,
    ForbiddenException,
    ValidationException,
    NotFoundException,
    RateLimitExceededException,
    InternalServerErrorException
};
use Psr\Http\Message\ResponseInterface;

abstract class BaseService
{
    protected Client $client;

    public function __construct(
        protected string $apiKey,
        protected string $apiSecret,
        protected string $baseUrl
    ) {
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'Authorization' => "sso-key {$this->apiKey}:{$this->apiSecret}",
                'Accept'        => 'application/json',
                'Content-Type'  => 'application/json',
            ],
        ]);
    }

    protected function handleHttpException(\GuzzleHttp\Exception\ClientException $e, string $customExceptionClass, ErrorCode $code): never
    {
        $status = $e->getResponse()?->getStatusCode();
        $bodyRaw = (string)$e->getResponse()?->getBody();
        $body = json_decode($bodyRaw, true) ?? [];

        match ($status) {
            401 => throw new UnauthorizedException('Unauthorized', 401, $e),
            403 => throw new ForbiddenException('Forbidden', 403, $e),
            404 => throw new NotFoundException('Not Found', 404, $e),
            422 => throw new ValidationException(
                $body['message'] ?? 'Validation failed.',
                422,
                $e,
                $body['fields'] ?? []
            ),
            429 => throw new RateLimitExceededException('Rate limit exceeded', 429, $e),
            500 => throw new InternalServerErrorException('Internal server error', 500, $e),
            default => throw new $customExceptionClass(
                $body['message'] ?? 'API error',
                $code->value,
                $e
            ),
        };
    }

    protected function decodeResponse(ResponseInterface $response): array
    {
        try {
            return json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new \RuntimeException('Failed to decode JSON response: ' . $e->getMessage());
        }
    }
} 