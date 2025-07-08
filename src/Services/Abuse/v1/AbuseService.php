<?php

namespace GoDaddy\Services\Abuse\v1;

use GoDaddy\Services\BaseService;
use GoDaddy\Services\Abuse\v1\DTO\ListAbuseTicketsFilter;
use GoDaddy\Services\Abuse\v1\DTO\CreateAbuseTicketData;
use GoDaddy\Services\Abuse\v1\DTO\GetAbuseTicketData;
use GoDaddy\Services\Abuse\v1\Exceptions\TicketListingException;
use GoDaddy\Services\Abuse\v1\Exceptions\TicketCreationException;
use GoDaddy\Services\Abuse\v1\Exceptions\TicketRetrievalException;
use GoDaddy\Support\ErrorCode;

class AbuseService extends BaseService
{
    /**
     * GET /v1/abuse/tickets
     * List all abuse ticket ids (filterable).
     */
    public function listTickets(ListAbuseTicketsFilter $filters): array
    {
        try {
            $response = $this->client->get('/v1/abuse/tickets', [
                'query' => $filters->toArray()
            ]);
            return $this->decodeResponse($response);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $this->handleHttpException($e, TicketListingException::class, ErrorCode::ABUSE_TICKET_LIST_FAILED);
        }
    }

    /**
     * POST /v1/abuse/tickets
     * Create a new abuse ticket.
     */
    public function createTicket(CreateAbuseTicketData $data): array
    {
        try {
            $response = $this->client->post('/v1/abuse/tickets', [
                'json' => $data->toArray()
            ]);
            return $this->decodeResponse($response);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $this->handleHttpException($e, TicketCreationException::class, ErrorCode::ABUSE_TICKET_CREATION_FAILED);
        }
    }

    /**
     * GET /v1/abuse/tickets/{ticketId}
     * Get a specific abuse ticket.
     */
    public function getTicket(GetAbuseTicketData|string $ticket): array
    {
        $ticketId = $ticket instanceof GetAbuseTicketData ? $ticket->ticketId : $ticket;
        try {
            $response = $this->client->get("/v1/abuse/tickets/{$ticketId}");
            return $this->decodeResponse($response);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $this->handleHttpException($e, TicketRetrievalException::class, ErrorCode::ABUSE_TICKET_RETRIEVE_FAILED);
        }
    }
}
