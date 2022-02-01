<?php

use App\Api\Api;
use App\Api\Response;
use App\Controller\ControllerException;
use App\Response\JsonResponse;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ControllerTest extends TestCase
{
    public function testShouldExecuteController()
    {
        $apiMock = Mockery::mock(Api::class)
            ->shouldReceive('get')
            ->andReturn(new Response('{}'))
            ->getMock();

        $controller = new App\Controller\Controller($apiMock);
        $requestMock = Mockery::mock(Request::class)
            ->shouldReceive('getRequestUri')
            ->andReturn('/comments')
            ->getMock();

        $response = $controller->execute($requestMock);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals('{}', $response->getContent());
    }

    public function testShouldMatchRequestUri()
    {
        $apiMock = Mockery::mock(Api::class);

        $controller = Mockery::mock(App\Controller\Controller::class, [
            $apiMock,
        ])
            ->makePartial();

        $matchRequestUri = new ReflectionMethod($controller, 'matchRequestUri');
        $matchRequestUri->setAccessible(true);

        $this->assertEquals('/comments', $matchRequestUri->invokeArgs($controller, ['/comments']));
        $this->assertEquals('/comments/1', $matchRequestUri->invokeArgs($controller, ['/comments/1']));

        $this->expectException(ControllerException::class);

        $this->assertEquals('/comments/1', $matchRequestUri->invokeArgs($controller, ['/test/1']));
    }
}
