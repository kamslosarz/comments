<?php

namespace App\Response;

use Symfony\Component\HttpFoundation\Response;

class JsonResponse extends Response
{

    public function __construct(?string $content = '', int $status = 200, array $headers = [])
    {
        parent::__construct($content, $status, $headers);

        $this->headers->add([
            'Content-Type' => 'application/json',
        ]);
    }

    public function setJson(array $results)
    {
        $this->content = json_encode($results, JSON_PRETTY_PRINT);
    }

    public function setJsonSting(string $results)
    {
        $this->content = $results;
    }
}
