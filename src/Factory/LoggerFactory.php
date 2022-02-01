<?php

namespace App\Factory;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

final class LoggerFactory
{
    public final static function getInstance(string $logDir): LoggerInterface
    {
        if (strstr($logDir, 'php://') !== false) {
            $handler = new StreamHandler($logDir);
        } else {
            $handler = new StreamHandler($logDir.'/app-log.log');
        }

        return new Logger('appLogger', [$handler], []);
    }
}
