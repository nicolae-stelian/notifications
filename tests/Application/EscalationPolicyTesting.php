<?php
namespace Tests\Application;

use Notification\Adapter\Out\EscalationPolicyAdapter;
use Notification\Domain\EscalationPolicy;

class EscalationPolicyTesting implements EscalationPolicyAdapter
{
    protected $escalationPolicy;

    public function setEscalationPolicy(EscalationPolicy $escalationPolicy)
    {
        $this->escalationPolicy = $escalationPolicy;
    }

    public function getEscalationPolicy($serviceId): EscalationPolicy
    {
        return $this->escalationPolicy;
    }
}