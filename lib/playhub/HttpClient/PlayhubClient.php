<?php

namespace Playhub\HttpClient;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class PlayhubClient
{
    private HttpClientInterface $client;
    private string $baseUrl;

    public function __construct(bool $useProxy = true)
    {
        $this->client = HttpClient::create();
        
        if ($useProxy) {
            $this->baseUrl = 'https://api.cloudflare.ravensburgerplay.com/hydraproxy/api/v2';
        } else {
            $this->baseUrl = 'https://api.ravensburgerplay.com/api/v2';
        }
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function request(string $method, string $url, array $options = []): ResponseInterface
    {
        $fullUrl = $this->baseUrl . $url;
        return $this->client->request($method, $fullUrl, $options);
    }
}
