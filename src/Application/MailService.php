<?php

namespace Notification\Application;

use Notification\Adapter\Out\SenderAdapter;
use Notification\Domain\SmsTarget;
use Notification\Domain\Target;

class MailService implements SenderAdapter
{
    /**
     * @throws \Exception
     */
    public function send($destination, $message)
    {
        echo "some logic to send mail - Destination: $destination\n" ;
    }
}