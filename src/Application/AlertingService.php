<?php
namespace Notification\Application;

use Notification\Adapter\In\AlertingAdapter;

class AlertingService implements AlertingAdapter
{
    protected $pager;

    public function __construct(PagerService $pager)
    {
        $this->pager = $pager;
    }

    public function notify($message, $serviceId)
    {
        // Those alerts are forwarded to the Pager Service (3)
        $this->pager->notify($message, $serviceId);
    }
}
