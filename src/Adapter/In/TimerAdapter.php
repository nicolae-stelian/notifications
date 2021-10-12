<?php

namespace Notification\Adapter\In;
interface TimerAdapter
{
    // check if acknowledge timestamp is valid for execution < Datetime.now
    public function canSendNotifications($timestamp): bool;

    public function getTimestamp($delay): int;
}
