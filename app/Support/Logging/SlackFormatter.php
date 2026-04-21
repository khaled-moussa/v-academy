<?php

namespace App\Support\Logging;

use Illuminate\Log\Logger;
use Monolog\Formatter\LineFormatter;

class SlackFormatter
{
    public function __invoke(Logger $logger): void
    {
        foreach ($logger->getHandlers() as $handler) {

            $handler->setFormatter(
                new LineFormatter(
                    $this->format(),
                    'D, d-m-y | h:i:s A',
                    true,
                    true
                )
            );
        }
    }

    private function format(): string
    {
        return implode("\n", [
            "🚨 MESSAGE: %message%",
            "",
            "",
            "🔴 LEVEL: %level_name%",
            "👤 USER: %context.user_id%",
            "💥 EXCEPTION: %context.exception%",
            "📄 FILE: %context.file%",
            "📍 LINE: %context.line%",
            "🔗 URL: %context.url%",
            "🕒 TIME: %datetime%",
            "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━",
        ]);
    }
}
