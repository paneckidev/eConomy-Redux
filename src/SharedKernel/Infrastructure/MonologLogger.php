<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Log\LoggerInterface;

abstract class MonologLogger
{
    public static function create(): LoggerInterface
    {
        $logger = new Logger($_ENV['LOGGER_NAME']);

        $processor = new UidProcessor();
        $logger->pushProcessor($processor);

        $handler = new StreamHandler($_ENV['LOGGER_PATH'], $_ENV['LOGGER_LEVEL']);
        $logger->pushHandler($handler);

        return $logger;
    }
}
