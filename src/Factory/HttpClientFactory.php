<?php

namespace App\Factory;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class HttpClientFactory
{
    public final static function getInstance(string $endpoint): HttpClientInterface
    {
        return HttpClient::createForBaseUri($endpoint);
    }
}
