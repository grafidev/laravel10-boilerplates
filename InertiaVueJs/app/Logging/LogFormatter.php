<?php

namespace App\Logging;

use Monolog\Formatter\LineFormatter;

class LogFormatter
{
    public function __invoke($logger)
    {
        foreach ($logger->getHandlers() as $handler) {
            $handler->setFormatter(
                new LineFormatter(
                    '['.timezone_format()."]: %message% %context%\n"
                )
            );
        }
    }
}
