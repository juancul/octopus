<?php


namespace OTP\Traits;

trait Instance
{
    private static $_instance = null;
    public static function instance()
    {
        if (!is_null(self::$_instance)) {
            goto DH;
        }
        self::$_instance = new self();
        DH:
        return self::$_instance;
    }
}
