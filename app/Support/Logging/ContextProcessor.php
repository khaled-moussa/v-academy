<?php

namespace App\Support\Logging;

use Monolog\LogRecord;
use Monolog\Processor\ProcessorInterface;

class ContextProcessor implements ProcessorInterface
{
    public function __invoke(LogRecord $record): LogRecord
    {
        $context = $record->context;

        $exception = $context['exception'] ?? null;

        $context['user_id'] = auth()->id();
        $context['url']     = request()?->fullUrl();
        $context['ip']      = request()?->ip();
        $context['method']  = request()?->method();

        if ($exception instanceof \Throwable) {
            $context['exception'] = class_basename($exception);
            $context['file']      = $exception->getFile();
            $context['line']      = $exception->getLine();
            $context['message']   = $exception->getMessage();
        }

        return $record->with(
            context: $context
        );
    }
}
