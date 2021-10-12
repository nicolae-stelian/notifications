<?php

namespace Tests\Application;

use Notification\Application\TimerService;

class TimerServiceTesting extends TimerService
{
    public $timestamp = 1;

    protected function getCurrentTimestamp(): int
    {
        return $this->timestamp;
    }
}