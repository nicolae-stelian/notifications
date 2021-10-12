<?php
namespace Notification\Application;

use Notification\Adapter\In\TimerAdapter;
use Notification\Adapter\Out\EscalationPolicyAdapter;
use Notification\Adapter\Out\MailAdapter;
use Notification\Adapter\Out\SmsAdapter;
use Notification\Domain\MailTarget;
use Notification\Domain\MonitoredService;
use Notification\Domain\SmsTarget;
use Notification\Domain\Target;

class PagerService
{
    /**
     * @var array
     */
    protected $monitoredServices;
    /**
     * @var array
     * This array have this form:
     *  [
     *      "serviceId" => ["level" => 1, "timestamp" => 0],
     *      "apache" => ["level" => 0, "timestamp" => 0],
     *      "mysql" => ["level" => 1, "timestamp" => 1633760198],
     *  ]
     * @var array
     */
    protected $levels;
    /**
     * @var int
     */
    protected $delay;
    /**
     * @var EscalationPolicyAdapter
     */
    protected $epService;
    /**
     * @var TimerAdapter
     */
    protected $timerAdapter;


    public function __construct(EscalationPolicyAdapter $epService, TimerAdapter $timerAdapter)
    {
        $this->monitoredServices = [];
        $this->levels = [];
        $this->delay = 15;
        $this->epService = $epService;
        $this->timerAdapter = $timerAdapter;
    }

    public function addMonitoredService(MonitoredService $service)
    {
        $this->monitoredServices[$service->getServiceId()] = $service;
    }

    public function markHealthy($serviceId)
    {
        /** @var MonitoredService $service */
        $service = $this->monitoredServices[$serviceId];
        $service->markHealthy();
        // reset level when is healthy.
        echo "The level is reset to 0 for $serviceId \n";
        $this->levels[$serviceId] = [
            'level' => 0,
            'timestamp' => 0,
        ];
    }

    public function notify($message, $serviceId)
    {
        // then this service based on the Escalation Policy of the Monitored Service (available from the EP Service (4)),
        $policy = $this->epService->getEscalationPolicy($serviceId);
        // sends the notifications to all the Targets of the first Policy Level, by mail (5) or SMS (6)
        // After that the service set an external timer for the Acknowledgement Timeout (7).
        // A target must acknowledge the alert within 15-minutes (8).
        $currentLevel = (int)@$this->levels[$serviceId]['level'];
        $currentTimestamp = (int)@$this->levels[$serviceId]['timestamp'];

        if ($this->timerAdapter->canSendNotifications($currentTimestamp)) {
            echo "Service: $serviceId; Level: $currentLevel \n";
            $targets = $policy->getTargets($currentLevel);
            // increase levels for this service and set a timeout (Acknowledgement Timeout)
            $newLevel = [
                "level" => $currentLevel + 1,
                "timestamp" => $this->timerAdapter->getTimestamp($this->delay),
            ];
            $this->levels[$serviceId] = $newLevel;

            echo "New level saved: " . print_r($newLevel, true) . "\n";

            if (empty($targets)) {
                echo "No targets to notify.\n";
                return;
            }
            /** @var Target $target */
            foreach ($targets as $target) {
                $target->send($message);
            }
        } else {
            echo "Notifications not send.\n";
        }
    }
}
