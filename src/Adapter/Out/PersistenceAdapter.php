<?php

namespace Notification\Adapter\Out;

use Notification\Domain\EscalationPolicy;

interface PersistenceAdapter
{
    public function save(EscalationPolicy $policy);
}
