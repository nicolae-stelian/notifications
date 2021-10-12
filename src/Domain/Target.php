<?php

namespace Notification\Domain;

use Notification\Adapter\Out\SenderAdapter;

/**
 * Each target can be of two types: email or SMS.
 * Email Target contains the email address and SMS Target contains the Phone Number.
 */
abstract class Target
{
    protected $destination;
    /**
     * @var SenderAdapter
     */
    protected $adapter;

    public function __construct($destination, $adapter)
    {
        if ($this->isValid($destination)) {
            $this->destination = $destination;
            $this->adapter = $adapter;
        } else {
            throw new \Exception("Invalid $destination in " . self::class);
        }
    }

    abstract protected function isValid($value): bool;

    public function getDestination()
    {
        return $this->destination;
    }

    public function send($message)
    {
        $this->adapter->send($this->getDestination(), $message);
    }
}
