<?php


namespace OTP\Objects;

if (defined("\101\102\123\120\x41\124\110")) {
    goto m7;
}
die;
m7:
class NotificationSettings
{
    public $sendSMS;
    public $sendEmail;
    public $phoneNumber;
    public $fromEmail;
    public $fromName;
    public $toEmail;
    public $toName;
    public $subject;
    public $bccEmail;
    public $message;
    public function __construct()
    {
        if (func_num_args() < 4) {
            goto BN;
        }
        $this->createEmailNotificationSettings(func_get_arg(0), func_get_arg(1), func_get_arg(2), func_get_arg(3), func_get_arg(4));
        goto VF;
        BN:
        $this->createSMSNotificationSettings(func_get_arg(0), func_get_arg(1));
        VF:
    }
    public function createSMSNotificationSettings($ZI, $Tg)
    {
        $this->sendSMS = TRUE;
        $this->phoneNumber = $ZI;
        $this->message = $Tg;
    }
    public function createEmailNotificationSettings($wk, $Y6, $yw, $Zo, $Tg)
    {
        $this->sendEmail = TRUE;
        $this->fromEmail = $wk;
        $this->fromName = $Y6;
        $this->toEmail = $yw;
        $this->toName = $yw;
        $this->subject = $Zo;
        $this->bccEmail = '';
        $this->message = $Tg;
    }
}
