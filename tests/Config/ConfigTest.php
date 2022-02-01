<?php

use App\Config\Config;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    public function testShouldLoadConfig()
    {
        $config = new App\Config\Config();

        $this->assertEquals('https://jsonplaceholder.typicode.com/', $config->get(Config::HTTP_ENDPOINT));
        $this->assertEquals('log', $config->get(Config::LOG_DIR));
    }
}
