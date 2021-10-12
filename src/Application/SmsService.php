<?php

namespace Notification\Application;

use Notification\Adapter\Out\SenderAdapter;
use Notification\Domain\MailTarget;
use Notification\Domain\Target;

class SmsService implements SenderAdapter
{
    /**
     * @throws \Exception
     */
    public function send($destination, $message)
    {
        echo "some logic to send SMS service: Destination $destination \n";
    }
}