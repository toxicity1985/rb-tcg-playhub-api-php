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
    public function getEventRegistrations(int $id): array
    {
        $page = 1;
        $events = [];

        while ($page !== null) {
            $response = $this->playHubClient->request('GET', '/events/'.$id . '/registrations?page_size=500&include_deaths=true&page=' . $page);
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
    public function getEventRound(int $id): array
    {
        $page = 1;
        $matches = [];

        while ($page !== null) {
            $response = $this->playHubClient->request('GET', '/tournament-rounds/' . $id . '/matches/paginated?page_size=500&page=' . $page);
            $content = $response->toArray();

            $page = $content['next'];

            if (count($content['results']) > 0) {
                $matches = array_merge($matches, $content['results']);
            }
        }

        return ['matches' => $matches];
    }


    /**
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getStandings(int $id): array
    {
        $page = 1;
        $standings = [];

        while ($page !== null) {
            $response = $this->playHubClient->request('GET', '/tournament-rounds/' . $id . '/standings/paginated?page_size=250&page=' . $page);
            $content = $response->toArray();

            $page = $content['next'];

            if (count($content['results']) > 0) {
                $standings = array_merge($standings, $content['results']);
            }
        }

        return ['standings' => $standings];
    }

    /**
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     *
     * For the old event, for the moment, we have to use that function because we got empty results from the paginated route
     */
    public function getOldStandings(int $id): array
    {
        $response = $this->playHubClient->request('GET', '/tournament-rounds/' . $id . '/standings');
        $content = $response->toArray();

        return $content;
    }
}
