<?php


namespace OTP\Objects;

interface IGatewayFunctions
{
    public function registerAddOns();
    public function showAddOnList();
    public function flush_cache();
    public function _vlk($post);
    public function hourlySync();
    public function mclv();
    public function isMG();
    public function getApplicationName();
    public function custom_wp_mail_from_name($rS);
    public function _mo_configure_sms_template($T3);
    public function _mo_configure_email_template($T3);
    public function showConfigurationPage($i4);
    public function mo_send_otp_token($s7, $Vy, $l1);
    public function mo_send_notif(NotificationSettings $Sc);
    public function mo_validate_otp_token($Cz, $NH);
    public function getConfigPagePointers();
}
