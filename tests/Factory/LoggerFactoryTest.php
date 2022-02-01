<?php

namespace App\Factory;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class LoggerFactoryTest extends TestCase
{
    public function testShouldConstructLogger()
    {
        $logger = LoggerFactory::getInstance('logs');

        $this->assertInstanceOf(LoggerInterface::class, $logger);
    }
}
