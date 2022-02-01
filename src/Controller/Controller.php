<?php

namespace App\Controller;

use App\Api\Api;
use App\Api\ApiException;
use App\Response\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Controller
{
    private Api $api;

    public function __construct(Api $api)
    {
        $this->api = $api;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws ApiException
     */
    public function execute(Request $request): Response
    {
        $requestUri = $this->matchRequestUri($request->getRequestUri());
        $apiResponse = $this->api->get($requestUri);

        $response = new JsonResponse();
        $response->setJsonSting($apiResponse->getContent());

        return $response;
    }

    /**
     * @param string $requestUri
     * @return string
     */
    protected function matchRequestUri(string $requestUri): string
    {
        if ($requestUri === '/comments') {
            return '/comments';
        }
        if (preg_match('/^\/comments\/[0-9]+$/m', $requestUri)) {
            return $requestUri;
        }

        throw new ControllerException(sprintf('Invalid route %s', htmlspecialchars($requestUri)));
    }
}
