<?php

namespace Playhub\Api;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Playhub\Exception\InvalidSearchEventRequestException;
use Playhub\Request\SearchEventRequest;
use Playhub\Service\ValidatorService;

class PlayhubEvent extends AbstractPlayhubApi
{
    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws InvalidSearchEventRequestException
     */
    public static function search(SearchEventRequest $searchEventRequest): array
    {
        $errors = ValidatorService::validateSearchRequest($searchEventRequest);
        if (sizeof($errors) > 0) {
            throw new InvalidSearchEventRequestException($errors);
        }

        return self::build()->getEvents($searchEventRequest);
    }

    /**
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public static function get(int $id): array
    {
        return self::build()->getEvent($id);
    }

    /**
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public static function getRegistrations(int $id): array
    {
        return self::build()->getEventRegistrations($id);
    }
}
