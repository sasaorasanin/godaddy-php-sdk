<?php

namespace GoDaddy\Services\Abuse\v2;

use GoDaddy\Services\Abuse\v2\DTO\CreateAbuseTicketData;
use GoDaddy\Services\Abuse\v2\DTO\GetAbuseTicketData;
use GoDaddy\Services\Abuse\v2\DTO\ListAbuseTicketsFilter;
use GoDaddy\Services\BaseService;
use GoDaddy\Services\Abuse\v2\Exceptions\TicketListingException;
use GoDaddy\Services\Abuse\v2\Exceptions\TicketCreationException;
use GoDaddy\Services\Abuse\v2\Exceptions\TicketRetrievalException;
use GoDaddy\Support\ErrorCode;

class AbuseService extends BaseService
{
    /**
     * GET /v2/abuse/tickets
     * List all abuse tickets (filterable).
     */
    public function listTickets(ListAbuseTicketsFilter $filters): array
    {
        try {
            $response = $this->client->get('/v2/abuse/tickets', [
                'query' => $filters->toArray()
            ]);

            return $this->decodeResponse($response);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $this->handleHttpException($e, TicketListingException::class, ErrorCode::ABUSE_TICKET_LIST_FAILED);
        }
    }

    /**
     * POST /v2/abuse/tickets
     * Create a new abuse ticket.
     */
    public function createTicket(CreateAbuseTicketData $data): array
    {
        try {
            $response = $this->client->post('/v2/abuse/tickets', [
                'json' => $data->toArray()
            ]);

            return $this->decodeResponse($response);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $this->handleHttpException($e, TicketCreationException::class, ErrorCode::ABUSE_TICKET_CREATION_FAILED);
        }
    }

    /**
     * GET /v2/abuse/tickets/{ticketId}
     * Get a specific abuse ticket.
     */
    public function getTicket(GetAbuseTicketData|string $ticket): array
    {
        $ticketId = $ticket instanceof GetAbuseTicketData ? $ticket->ticketId : $ticket;

        try {
            $response = $this->client->get("/v2/abuse/tickets/{$ticketId}");

            return $this->decodeResponse($response);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $this->handleHttpException($e, TicketRetrievalException::class, ErrorCode::ABUSE_TICKET_RETRIEVE_FAILED);
        }
    }
}
