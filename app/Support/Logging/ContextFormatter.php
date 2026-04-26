<?php

namespace App\Support\Logging;

use Illuminate\Log\Logger;
use Monolog\Formatter\LineFormatter;

class ContextFormatter
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
            "",
            "┌─────────────────────────────────────────────────────────────────────────────┐",
            "│  %level_name%  •  %datetime%",
            "└─────────────────────────────────────────────────────────────────────────────┘",
            "",
            "  📢  %message%",
            "",
            "  ┌─ REQUEST ──────────────────────────────────",
            "  │  👤  User      : %context.user_id%",
            "  │  🌐  IP        : %context.ip%",
            "  │  📡  Method    : %context.method%",
            "  │  🔗  URL       : %context.url%",
            "  │",
            "  ├─ EXCEPTION ─────────────────────────────────",
            "  │  💥  Type      : %context.exception%",
            "  │  📝  Message   : %context.message%",
            "  │  📄  File      : %context.file%",
            "  │  📍  Line      : %context.line%",
            "  └─────────────────────────────────────────────",
            "",
        ]);
    }
}
