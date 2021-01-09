<?php


namespace OTP\Addons\WcSMSNotification\Helper;

use ReflectionClass;
final class WcOrderStatus
{
    const PROCESSING = "\160\x72\157\143\x65\x73\x73\x69\x6e\x67";
    const ON_HOLD = "\157\x6e\x2d\150\157\154\x64";
    const CANCELLED = "\143\x61\x6e\143\145\x6c\x6c\x65\x64";
    const PENDING = "\160\145\156\x64\x69\x6e\147";
    const FAILED = "\146\x61\151\x6c\145\x64";
    const COMPLETED = "\143\157\x6d\160\154\x65\164\145\x64";
    const REFUNDED = "\162\145\x66\165\x6e\x64\145\144";
    public static function getAllStatus()
    {
        $Ea = new ReflectionClass(self::class);
        return array_values($Ea->getConstants());
    }
}
