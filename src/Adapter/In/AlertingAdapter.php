<?php

namespace Notification\Adapter\In;
interface AlertingAdapter
{
    public function notify($message, $serviceId);
}
