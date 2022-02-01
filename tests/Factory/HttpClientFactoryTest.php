<?php

namespace App\Factory;

use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HttpClientFactoryTest extends TestCase
{
    public function testShouldConstructHttpClient()
    {
        $httpClient = HttpClientFactory::getInstance('https://test.pl/');

        $this->assertInstanceOf(HttpClientInterface::class, $httpClient);
    }
}
