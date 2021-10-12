<?php

namespace Tests\Application;

use Notification\Adapter\In\AlertingAdapter;
use Notification\Adapter\Out\SenderAdapter;
use Notification\Application\PagerService;
use Notification\Domain\EscalationPolicy;
use Notification\Domain\MailTarget;
use Notification\Domain\MonitoredService;
use Notification\Domain\SmsTarget;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;


class PagerServiceTest extends TestCase
{
    protected $serviceId;
    /**
     * @var PagerService
     */
    private $pager;
    /**
     * @var AlertingAdapter|MockObject
     */
    private $alertingAdapter;
    /**
     * @var TimerServiceTesting
     */
    private $timerService;
    /**
     * @var EscalationPolicyTesting
     */
    private $epAdapter;
    /**
     * @var EscalationPolicy
     */
    private $escalationPolicy;
    /**
     * @var SenderAdapter|MockObject
     */
    private $mailService;
    /**
     * @var SenderAdapter|MockObject
     */
    private $smsService;

    /**
     * @throws \Exception
     */
    public function setUp()
    {
        $this->serviceId = "apache";
        $this->timerService = new TimerServiceTesting();

        $this->createEscalationPolicy();

        $this->epAdapter = new EscalationPolicyTesting();
        $this->epAdapter->setEscalationPolicy($this->escalationPolicy);

        $this->pager = new PagerService($this->epAdapter, $this->timerService);
        $this->alertingAdapter = $this->getMockBuilder(AlertingAdapter::class)->getMock();
        $monitoredService = new MonitoredService($this->serviceId, $this->alertingAdapter);
        $this->pager->addMonitoredService($monitoredService);
    }

    /**
     * @throws \Exception
     */
    public function testPagerNotifyLevel0()
    {
        $this->mailService->expects($this->once())
            ->method('send')
            ->with("level0@aircall.com", "message")
        ;
        $this->smsService->expects($this->once())
            ->method('send')
            ->with("000111222", "message")
        ;

        $this->pager->notify("message", $this->serviceId);
    }

    /**
     * @throws \Exception
     */
    public function testPagerNotifyLevel1()
    {
        $this->pager->notify("message", $this->serviceId); // notify level
        $this->timerService->timestamp = 30; // increase timer

        $this->mailService->expects($this->once())
            ->method('send')
            ->with("level1@aircall.com", "message")
        ;
        $this->smsService->expects($this->once())
            ->method('send')
            ->with("111222333", "message")
        ;

        $this->pager->notify("message", $this->serviceId);
    }

    /**
     * @throws \Exception
     */
    public function testPagerNotNotifyLevel1IfAcknowledgementIsBelowTo15min()
    {
        $this->pager->notify("message", $this->serviceId); // notify level 0
        $this->timerService->timestamp = 14; // increase timer but is bellow to 15

        $this->mailService->expects($this->never())
            ->method('send')
        ;
        $this->smsService->expects($this->never())
            ->method('send')
        ;

        $this->pager->notify("message", $this->serviceId);
    }

    /**
     * @throws \Exception
     */
    protected function createEscalationPolicy(): void
    {
        $this->escalationPolicy = new EscalationPolicy($this->serviceId);
        $this->mailService = $this->getMockBuilder(SenderAdapter::class)->getMock();
        $this->smsService = $this->getMockBuilder(SenderAdapter::class)->getMock();
        $this->escalationPolicy->addTarget(0, new MailTarget("level0@aircall.com", $this->mailService));
        $this->escalationPolicy->addTarget(0, new SmsTarget("000111222", $this->smsService));
        $this->escalationPolicy->addTarget(1, new MailTarget("level1@aircall.com", $this->mailService));
        $this->escalationPolicy->addTarget(1, new SmsTarget("111222333", $this->smsService));
    }
}
