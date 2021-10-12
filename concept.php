<?php

use Notification\Application\AlertingService;
use Notification\Application\EscalationPolicyService;
use Notification\Application\PagerService;
use Notification\Application\TimerService;
use Notification\Domain\MonitoredService;

$loader = require __DIR__.'/vendor/autoload.php';

$pagerService = new PagerService(new EscalationPolicyService(), new TimerService());
$alertingService = new AlertingService($pagerService);
$apacheService = new MonitoredService("apache", $alertingService);
$mysqlService = new MonitoredService("mysql", $alertingService);
$pagerService->addMonitoredService($apacheService);

$execCount = 0;
while ($execCount++ < 100) {
    echo "Execution $execCount \n";
    sleep(1);
    if ($execCount == 3) {
        echo "Apache crash \n";
        $apacheService->crash();
    }
    if (in_array($execCount, [20, 35, 55, 80, 90]) ) {
        echo "Mysql crash \n";
        $mysqlService->crash();
    }

    if (in_array($execCount, [17, 20])) {
        $pagerService->markHealthy('apache');
        echo "Apache is healthy \n";
    }
    if (in_array($execCount, [18, 95]) ) {
        echo "Apache crash \n";
        $apacheService->crash();
    }
}