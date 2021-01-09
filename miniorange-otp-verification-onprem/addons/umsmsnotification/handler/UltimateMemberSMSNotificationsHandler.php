<?php


namespace OTP\Addons\UmSMSNotification\Handler;

use OTP\Addons\UmSMSNotification\Helper\UltimateMemberNotificationsList;
use OTP\Objects\BaseAddOnHandler;
use OTP\Traits\Instance;
class UltimateMemberSMSNotificationsHandler extends BaseAddOnHandler
{
    use Instance;
    private $notificationSettings;
    function __construct()
    {
        parent::__construct();
        if ($this->moAddOnV()) {
            goto AE;
        }
        return;
        AE:
        $this->notificationSettings = get_umsn_option("\x6e\x6f\164\151\146\151\143\141\x74\x69\157\x6e\x5f\x73\x65\x74\164\151\x6e\x67\x73") ? get_umsn_option("\156\x6f\x74\151\146\151\x63\x61\x74\x69\157\156\137\x73\145\164\164\151\x6e\x67\163") : UltimateMemberNotificationsList::instance();
        add_action("\165\155\x5f\162\145\x67\x69\x73\x74\x72\x61\x74\x69\157\156\137\143\157\x6d\x70\x6c\145\164\x65", array($this, "\155\157\137\163\x65\156\x64\137\156\x65\x77\137\x63\x75\163\x74\157\155\x65\x72\x5f\x73\x6d\163\x5f\x6e\x6f\164\x69\x66"), 1, 2);
    }
    function mo_send_new_customer_sms_notif($wc, array $Kc)
    {
        $this->notificationSettings->getUmNewCustomerNotif()->sendSMS(array_merge(array("\143\165\163\164\x6f\155\145\162\137\151\x64" => $wc), $Kc));
        $this->notificationSettings->getUmNewUserAdminNotif()->sendSMS(array_merge(array("\x63\165\163\x74\x6f\155\x65\162\x5f\x69\x64" => $wc), $Kc));
    }
    function unhook()
    {
        remove_action("\165\x6d\x5f\x72\x65\x67\x69\x73\x74\162\141\164\151\x6f\x6e\x5f\x63\x6f\155\x70\154\x65\164\145", "\165\155\x5f\163\145\156\x64\137\x72\145\147\151\163\x74\162\x61\164\151\157\x6e\137\156\x6f\x74\x69\146\151\x63\141\164\151\157\156");
    }
    function setAddonKey()
    {
        $this->_addOnKey = "\165\x6d\x5f\x73\155\x73\137\x6e\157\164\x69\x66\x69\x63\x61\164\151\x6f\156\137\x61\144\x64\x6f\156";
    }
    function setAddOnDesc()
    {
        $this->_addOnDesc = mo_("\101\x6c\x6c\157\x77\x73\40\171\157\165\x72\x20\x73\151\164\x65\40\x74\x6f\x20\163\145\x6e\144\40\x63\x75\163\164\x6f\155\x20\x53\x4d\x53\40\x6e\157\164\x69\146\151\143\141\164\151\157\156\163\40\x74\157\x20\x79\157\x75\x72\40\143\165\x73\x74\157\155\x65\162\x73\56" . "\x43\x6c\151\x63\153\40\x6f\x6e\40\164\150\145\x20\163\145\x74\164\x69\156\147\163\x20\x62\x75\164\x74\157\x6e\40\x74\157\x20\x74\150\x65\x20\162\x69\x67\150\x74\x20\x74\x6f\40\x73\x65\145\40\164\150\145\40\x6c\151\163\x74\40\x6f\x66\x20\156\x6f\164\x69\146\151\x63\x61\164\151\x6f\x6e\163\x20\x74\x68\x61\164\40\x67\157\40\x6f\x75\x74\56");
    }
    function setAddOnName()
    {
        $this->_addOnName = mo_("\x55\154\x74\151\155\141\x74\x65\x20\115\145\155\142\145\x72\40\x53\x4d\x53\40\x4e\x6f\164\x69\146\151\143\141\164\x69\x6f\156");
    }
    function setSettingsUrl()
    {
        $this->_settingsUrl = add_query_arg(array("\x61\144\x64\157\156" => "\x75\155\137\x6e\157\164\x69\x66"), $_SERVER["\122\105\121\x55\105\x53\124\x5f\x55\x52\111"]);
    }
}
