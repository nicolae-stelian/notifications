<?php

namespace Notification\Adapter\In;
interface ConsoleAdapter
{
    // Through the web console, the Aircall engineer is able
    // to read
    public function readEscalationPolicy($serviceId);
    // and edit the Escalation Policy (1)
    public function writeEscalationPolicy($serviceId);

    // This console also allows the engineer, when the incident is closed,
    // to inform the Pager Service that the Monitored Service is now Healthy (2).
    public function markHealthy($serviceId);
}
