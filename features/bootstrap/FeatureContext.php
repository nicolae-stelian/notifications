<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

$loader = require __DIR__.'/../../vendor/autoload.php';

use Notification\Adapter\Out\SenderAdapter;
use Notification\Application\AlertingService;
use Notification\Application\EscalationPolicyService;
use Notification\Application\PagerService;
use Notification\Domain\MonitoredService;
use PHPUnit\Framework\Assert;
use Tests\Application\TimerServiceTesting;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /**
     * @var MonitoredService
     */
    private $monitoredService;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {

    }

    /**
     * @Given a Monitored Service in a Healthy State,
     */
    public function aMonitoredServiceInAHealthyState()
    {
        $pager = new PagerService(
            new EscalationPolicyService(),
            new TimerServiceTesting()
        );
        $alertingAdapter = new AlertingService($pager);
        $this->monitoredService = new MonitoredService("apache", $alertingAdapter);
    }

    /**
     * @When the Pager receives an Alert related to this Monitored Service,
     */
    public function thePagerReceivesAnAlertRelatedToThisMonitoredService()
    {
        $this->monitoredService->crash();
    }

    /**
     * @Then the Monitored Service becomes Unhealthy
     */
    public function theMonitoredServiceBecomesUnhealthy()
    {
        Assert::assertFalse($this->monitoredService->isHealthy());
    }

    /**
     * @Then the Pager notifies all targets of the first level of the escalation policy,
     */
    public function thePagerNotifiesAllTargetsOfTheFirstLevelOfTheEscalationPolicy()
    {
        Assert::assertFalse(true);
    }

    /**
     * @Then sets a :arg1-minutes acknowledgement delay
     */
    public function setsAMinutesAcknowledgementDelay($arg1)
    {
        Assert::assertFalse(true);
    }

}
