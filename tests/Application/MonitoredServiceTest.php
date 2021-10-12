<?php

namespace Tests\Application;

use Notification\Adapter\In\AlertingAdapter;
use Notification\Domain\MonitoredService;
use PHPUnit\Framework\TestCase;

class MonitoredServiceTest extends TestCase
{
    public function testCrash()
    {
        $serviceId = "apache";
        $alertingAdapter = $this->getMockBuilder(AlertingAdapter::class)
            ->setMockClassName("AlertingAdapter")
            ->getMock()
        ;
        $alertingAdapter->expects($this->once())
            ->method("notify")
            ->with(
                $this->equalTo("The service $serviceId is fail."),
                $this->equalTo($serviceId)
            )
        ;
        $monitoredService = new MonitoredService($serviceId, $alertingAdapter);

        $monitoredService->crash();
    }
}
