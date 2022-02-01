<?php

use App\Api\Api;
use App\Api\ApiException;
use App\Api\Response;
use App\App;
use App\Config\Config;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
{
    public function testShouldExecuteApp()
    {
        $app = new App();

        $configMock = Mockery::mock(Config::class)
            ->shouldReceive('load')
            ->getMock()
            ->shouldReceive('get')
            ->with(Config::HTTP_ENDPOINT)
            ->andReturn('https://test-endpoint')
            ->getMock()
            ->shouldReceive('get')
            ->with(Config::LOG_DIR)
            ->andReturn('php://memory')
            ->getMock();

        $apiResponse = Mockery::mock(Response::class)
            ->shouldReceive('getContent')
            ->andReturn('{}')
            ->getMock();

        $apiMock = Mockery::mock(Api::class)
            ->shouldReceive('get')
            ->andReturn($apiResponse)
            ->getMock();

        $_SERVER['REQUEST_URI'] = '/comments';

        /** @var Config $configMock */
        $response = $app->execute($configMock, $apiMock);
        $configMock->shouldHaveReceived('load')->once();

        $this->assertEquals('{}', $response->getContent());
    }

    public function testShouldExecuteAppWithException()
    {
        $app = new App();
        $api = Mockery::mock(Api::class)
            ->shouldReceive('get')
            ->once()
            ->andThrow(new ApiException('Unable to fetch api'))
            ->getMock();

        $configMock = Mockery::mock(Config::class)
            ->shouldReceive('load')
            ->getMock()
            ->shouldReceive('get')
            ->with(Config::HTTP_ENDPOINT)
            ->andReturn('https://test-endpoint')
            ->getMock()
            ->shouldReceive('get')
            ->with(Config::LOG_DIR)
            ->andReturn('php://memory')
            ->getMock();

        $_SERVER['REQUEST_URI'] = '/comments';

        /** @var Config $configMock */
        $response = $app->execute($configMock, $api);
        $configMock->shouldHaveReceived('load')->once();

        $this->assertStringContainsString('Unable to fetch api', $response->getContent());
    }
}
