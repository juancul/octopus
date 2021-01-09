<?php


namespace OTP\Objects;

abstract class VerificationLogic
{
    public abstract function _handle_logic($wE, $MQ, $TB, $Rn, $P8);
    public abstract function _handle_otp_sent($wE, $MQ, $TB, $Rn, $P8, $H1);
    public abstract function _handle_otp_sent_failed($wE, $MQ, $TB, $Rn, $P8, $H1);
    public abstract function _get_otp_sent_message();
    public abstract function _get_otp_sent_failed_message();
    public abstract function _get_otp_invalid_format_message();
    public abstract function _get_is_blocked_message();
    public abstract function _handle_matched($wE, $MQ, $TB, $Rn, $P8);
    public abstract function _handle_not_matched($TB, $Rn, $P8);
    public abstract function _start_otp_verification($wE, $MQ, $TB, $Rn, $P8);
    public abstract function _is_blocked($MQ, $TB);
    public static function _is_ajax_form()
    {
        return (bool) apply_filters("\x69\x73\137\x61\152\x61\x78\x5f\146\x6f\162\155", FALSE);
    }
}
