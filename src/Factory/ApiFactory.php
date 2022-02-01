<?php

namespace App\Factory;

use App\Api\Api;
use App\Config\Config;

final class ApiFactory
{
    public static function getInstance(Config $config): Api
    {
        $httpClient = HttpClientFactory::getInstance($config->get(Config::HTTP_ENDPOINT));
        $logger = LoggerFactory::getInstance($config->get(Config::LOG_DIR));

        return new Api($httpClient, $logger);
    }
}
