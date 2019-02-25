<?php

namespace LiYiBin\LineNotify;

use LineNotify;
use Monolog\Handler\AbstractProcessingHandler;

class LineNotifyHandler extends AbstractProcessingHandler
{
    protected function write(array $record): void
    {
        LineNotify::send($record['formatted']);
    }
}
