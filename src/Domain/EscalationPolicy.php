<?php
namespace Notification\Domain;

/**
 * An Escalation Policy references a Monitored Service by its identifier.
 * It contains an ordered list of levels. Each level contains a set of targets.
 * Each target can be of two types: email or SMS.
 * Email Target contains the email address and SMS Target contains the Phone Number.
 * This console also allows the engineer, when the incident is closed,
 * to inform the Pager Service that the Monitored Service is now Healthy (2).
 */
class EscalationPolicy
{
    protected $serviceId;
    protected $alertTargets = [];

    public function __construct($serviceId)
    {
        $this->serviceId = $serviceId;
    }

    public function addTarget(int $level, Target $target)
    {
        $this->alertTargets[$level][] = $target;
    }

    public function getTargets($level)
    {
        if (array_key_exists($level, $this->alertTargets)) {
            return $this->alertTargets[$level];
        }
        return [];
    }
}