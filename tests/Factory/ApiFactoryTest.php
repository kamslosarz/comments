<?php

namespace App\Factory;

use App\Api\Api;
use App\Config\Config;
use PHPUnit\Framework\TestCase;

class ApiFactoryTest extends TestCase
{
    public function testShouldConstructApi()
    {
        $config = new Config();
        $api = ApiFactory::getInstance($config);

        $this->assertInstanceOf(Api::class, $api);
    }
}
