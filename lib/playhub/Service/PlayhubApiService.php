<?php

namespace Playhub\Service;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Playhub\HttpClient\PlayhubClient;
use Playhub\Request\SearchEventRequest;

readonly class PlayhubApiService
{
    public function __construct(private PlayhubClient $playHubClient)
    {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getEvents(SearchEventRequest $searchEventRequest): array
    {
        $page = 1;
        $events = [];

        while ($page !== null) {
            $response = $this->playHubClient->request('GET', '/events?' . $searchEventRequest->getUrlParameters() . '&page=' . $page);
            $content = $response->toArray();

            $page = $content['next'];

            if (count($content['results']) > 0) {
                $events = array_merge($events, $content['results']);
            }
        }

        return $events;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getEvent(int $id): array
    {
        $response = $this->playHubClient->request('GET', '/events/' . $id);
        return $response->toArray();
    }

    /**
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getEventRegistrations(int $id)
    {
        $page = 1;
        $events = [];

        while ($page !== null) {
            $response = $this->playHubClient->request('GET', '/events/'.$id . '/registrations?include_deaths=true&page=' . $page);
            $content = $response->toArray();

            $page = $content['next'];

            if (count($content['results']) > 0) {
                $events = array_merge($events, $content['results']);
            }
        }

        return $events;
    }

    /**
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getEventRound(int $id)
    {
        $response = $this->playHubClient->request('GET', '/tournament-rounds/' . $id . '/matches' );
        return $response->toArray();
    }
}
