<?php

namespace Notification\Adapter\Out;

use Notification\Domain\EscalationPolicy;

interface EscalationPolicyAdapter
{
    public function getEscalationPolicy($serviceId): EscalationPolicy;
}
