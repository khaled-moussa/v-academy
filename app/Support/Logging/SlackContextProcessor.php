<?php

namespace App\Support\Logging;

use Monolog\Processor\ProcessorInterface;
use Monolog\LogRecord;

class SlackContextProcessor implements ProcessorInterface
{
    public function __invoke(LogRecord $record): LogRecord
    {
        $context = $record->context;

        $e = $context['exception'] ?? null;

        $context['user_id'] = request()?->user()?->id;
        $context['url'] = request()?->fullUrl();

        if ($e) {
            $context['exception'] = class_basename($e);
            $context['file'] = $e->getFile();
            $context['line'] = $e->getLine();
        }

        return $record->with(context: $context);
    }
}