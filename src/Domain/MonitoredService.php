<?php

namespace Notification\Domain;

use Notification\Adapter\In\AlertingAdapter;

class MonitoredService
{
    protected $serviceId;
    protected $healthy;
    protected $alertingService;

    public function __construct($serviceId, AlertingAdapter $alertingService)
    {
        $this->serviceId = $serviceId;
        $this->alertingService = $alertingService;
        $this->healthy = true;
    }

    public function getServiceId()
    {
        return $this->serviceId;
    }

    public function markHealthy()
    {
        $this->healthy = true;
    }

    public function isHealthy(): bool
    {
        return $this->healthy;
    }

    public function crash()
    {
        $this->healthy = false;
        $message = "The service " . $this->serviceId . " is fail.";
        // The Monitored Service in case of dysfunction sends an Alert
        // (composed of the Alert Message and the Identifier of the Service)
        // to the Alerting Service (the alerts central place)
        $this->alertingService->notify($message, $this->serviceId);
    }
}