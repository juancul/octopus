<?php


namespace OTP\Objects;

abstract class SMSNotification
{
    public $page;
    public $isEnabled;
    public $tooltipHeader;
    public $tooltipBody;
    public $recipient;
    public $smsBody;
    public $defaultSmsBody;
    public $title;
    public $availableTags;
    public $pageHeader;
    public $pageDescription;
    public $notificationType;
    function __construct()
    {
    }
    public abstract function sendSMS(array $Kc);
    public function setIsEnabled($gu)
    {
        $this->isEnabled = $gu;
        return $this;
    }
    public function setRecipient($kV)
    {
        $this->recipient = $kV;
        return $this;
    }
    public function setSmsBody($O8)
    {
        $this->smsBody = $O8;
        return $this;
    }
}
