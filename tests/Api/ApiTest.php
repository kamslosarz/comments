<?php

use App\Api\Api;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ApiTest extends TestCase
{
    public function testShouldFetchApi()
    {
        $curlResponseMock = Mockery::mock(ResponseInterface::class)
            ->shouldReceive('getStatusCode')
            ->andReturn(200)
            ->getMock()
            ->shouldReceive('getContent')
            ->andReturn('content')
            ->once()
            ->getMock();

        $httpClientMock = Mockery::mock(HttpClientInterface::class)
            ->shouldReceive('request')
            ->withArgs([
                'GET',
                '/test',
                [],
            ])
            ->andReturn($curlResponseMock)
            ->getMock();

        $loggerMocker = Mockery::mock(LoggerInterface::class)
            ->shouldReceive('info')
            ->with('Endpoint fetched HTTP/200 GET: /test')
            ->getMock();

        /** @var HttpClientInterface $httpClientMock */
        $api = new Api($httpClientMock, $loggerMocker);

        $results = $api->get('/test');

        $httpClientMock->shouldHaveReceived('request')->once();
        $curlResponseMock->shouldHaveReceived('getStatusCode')->times(2);
        $loggerMocker->shouldHaveReceived('info')->once();

        $this->assertEquals('content', $results->getContent());
    }
}
