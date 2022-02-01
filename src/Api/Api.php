<?php

namespace App\Api;

use App\Api\Response as ApiResponse;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpClient\Response\CurlResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Api
{
    const VALID_CODES = [
        Response::HTTP_OK,
    ];

    private LoggerInterface $logger;
    private HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient, LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->httpClient = $httpClient;
    }

    /**
     * @param string $type
     * @param string $endpoint
     * @param array $options
     * @return ApiResponse
     * @throws ApiException
     */
    protected function fetch(string $type, string $endpoint, array $options = []): ApiResponse
    {
        try {
            $curlResponse = $this->httpClient->request($type, $endpoint, $options);
            $statusCode = $curlResponse->getStatusCode();

            if (in_array($curlResponse->getStatusCode(), self::VALID_CODES)) {
                $this->logger->info(sprintf('Endpoint fetched HTTP/%s %s: %s', $statusCode, $type, $endpoint));

                return new ApiResponse($curlResponse->getContent());
            } else {
                $this->logger->error(sprintf('Error not fetched HTTP/%s %s: %s', $statusCode, $type, $endpoint));

                throw new ApiException('Error fetching api %s', $curlResponse->getContent());
            }
        } catch (TransportExceptionInterface|ServerExceptionInterface|ClientExceptionInterface $exception) {
            $response = method_exists($exception, 'getResponse') ? $exception->getResponse()->getContent() : '';

            $this->logger->error(sprintf('ERROR: %s:%s %s %s', $type, $endpoint, PHP_EOL, $response));

            throw new ApiException('Unable to fetch api', 1, $exception);
        } catch (RedirectionExceptionInterface $exception) {
            throw new ApiException('', 1, $exception);
        }
    }

    /**
     * @param string $endpoint
     * @param array $query
     * @return ApiResponse
     * @throws ApiException
     */
    public function get(string $endpoint): ApiResponse
    {
        return $this->fetch(Request::METHOD_GET, $endpoint);
    }
}
