<?php

use App\Response\JsonResponse;
use PHPUnit\Framework\TestCase;

class JsonResponseTest extends TestCase
{
    public function testShouldSendJsonResponse()
    {
        $json = json_encode(['test' => 1]);
        $jsonResponse = new JsonResponse($json);

        $this->assertEquals('application/json', $jsonResponse->headers->get('content-type'));
    }
}
