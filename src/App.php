<?php

namespace App;

use App\Api\Api;
use App\Config\Config;
use App\Controller\Controller;
use App\Response\JsonResponse;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class App
{
    public function execute(Config $config, Api $api): Response
    {
        $config->load();

        $request = Request::createFromGlobals();
        $controller = new Controller($api);

        try {
            return $controller->execute($request);
        } catch (Exception $exception) {
            $jsonResponse = new JsonResponse();
            $jsonResponse->setJson([
                'error' => $exception->getCode(),
                'message' => $exception->getMessage()
            ]);

            return $jsonResponse;
        }
    }
}
