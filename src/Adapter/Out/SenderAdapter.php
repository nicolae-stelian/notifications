<?php

namespace Notification\Adapter\Out;

use Notification\Domain\Target;

interface SenderAdapter
{
    public function send($destination, $message);
}
