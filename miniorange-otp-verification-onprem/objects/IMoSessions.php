<?php


namespace OTP\Objects;

interface IMoSessions
{
    static function addSessionVar($O5, $k8);
    static function getSessionVar($O5);
    static function unsetSession($O5);
    static function checkSession();
}
