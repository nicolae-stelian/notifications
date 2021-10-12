<?php
namespace Notification\Application;

use Notification\Adapter\Out\EscalationPolicyAdapter;
use Notification\Domain\EscalationPolicy;
use Notification\Domain\MailTarget;
use Notification\Domain\SmsTarget;

class EscalationPolicyService implements EscalationPolicyAdapter
{
    /**
     * @throws \Exception
     */
    public function getEscalationPolicy($serviceId): EscalationPolicy
    {
        $escalationPolicy = new EscalationPolicy($serviceId);

        $escalationPolicy->addTarget(0, new MailTarget('level_0@gmail.com', new MailService()));
        $escalationPolicy->addTarget(1, new SmsTarget('111222333', new SmsService()));
        $escalationPolicy->addTarget(2, new MailTarget('level_2@gmail.com', new MailService()));

        return $escalationPolicy;
    }
}
