<?php

namespace Notification\Application;

use Notification\Adapter\In\TimerAdapter;

class TimerService implements TimerAdapter
{

    public function canSendNotifications($timestamp): bool
    {
        $now = $this->getCurrentTimestamp();
        return $timestamp == 0 || $timestamp < $now;

    }
    public function getTimestamp($delay): int
    {
        return $this->getCurrentTimestamp() + $delay;
    }

    protected function getCurrentTimestamp(): int
    {
        $now = new \DateTime("now");
        return $now->getTimestamp();
    }
}