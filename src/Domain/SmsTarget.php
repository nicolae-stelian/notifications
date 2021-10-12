<?php
namespace Notification\Domain;
/**
 * Each target can be of two types: email or SMS.
 * Email Target contains the email address and SMS Target contains the Phone Number.
 */
class SmsTarget extends Target
{
    protected function isValid($value): bool
    {
        return is_numeric($value) && strlen($value) == 9;
    }
}
