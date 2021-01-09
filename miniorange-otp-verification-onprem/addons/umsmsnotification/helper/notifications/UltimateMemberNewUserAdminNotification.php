<?php


namespace OTP\Addons\UmSMSNotification\Helper\Notifications;

use OTP\Addons\UmSMSNotification\Helper\UltimateMemberSMSNotificationMessages;
use OTP\Addons\UmSMSNotification\Helper\UltimateMemberSMSNotificationUtility;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class UltimateMemberNewUserAdminNotification extends SMSNotification
{
    public static $instance;
    function __construct()
    {
        parent::__construct();
        $this->title = "\x4e\x65\167\x20\101\x63\143\157\x75\x6e\x74";
        $this->page = "\x75\155\137\x6e\145\x77\137\143\165\x73\x74\157\155\145\162\137\141\x64\155\151\156\137\156\157\164\x69\x66";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\116\x45\127\x5f\125\115\x5f\x43\125\123\124\117\x4d\x45\122\x5f\116\x4f\x54\x49\x46\137\110\x45\x41\x44\105\122";
        $this->tooltipBody = "\116\105\x57\137\x55\x4d\x5f\103\125\x53\124\117\x4d\x45\x52\x5f\x41\104\x4d\111\116\x5f\116\117\x54\111\x46\x5f\102\x4f\x44\131";
        $this->recipient = UltimateMemberSMSNotificationUtility::getAdminPhoneNumber();
        $this->smsBody = UltimateMemberSMSNotificationMessages::showMessage(UltimateMemberSMSNotificationMessages::NEW_UM_CUSTOMER_ADMIN_SMS);
        $this->defaultSmsBody = UltimateMemberSMSNotificationMessages::showMessage(UltimateMemberSMSNotificationMessages::NEW_UM_CUSTOMER_ADMIN_SMS);
        $this->availableTags = "\173\x73\151\x74\145\x2d\156\141\x6d\145\175\x2c\173\165\163\145\x72\x6e\x61\x6d\145\x7d\54\173\x61\143\143\x6f\x75\156\164\x70\x61\x67\x65\x2d\165\162\154\x7d\x2c\173\145\x6d\141\x69\x6c\175\x2c\173\x66\x69\162\x74\156\141\x6d\145\175\x2c\x7b\x6c\141\163\164\156\x61\155\x65\175";
        $this->pageHeader = mo_("\116\x45\127\40\x41\x43\x43\x4f\125\x4e\x54\40\x41\104\x4d\x49\x4e\40\116\117\124\x49\x46\x49\x43\x41\124\111\x4f\116\x20\123\105\124\124\x49\116\107\123");
        $this->pageDescription = mo_("\x53\115\123\40\156\157\x74\151\x66\x69\x63\141\x74\x69\x6f\156\x73\x20\x73\145\x74\x74\x69\x6e\147\x73\40\x66\x6f\x72\40\x4e\145\x77\x20\x41\143\143\x6f\165\x6e\164\40\x63\162\x65\141\164\151\157\156\40\x53\x4d\x53\x20\163\145\156\x74\40\164\x6f\x20\164\x68\x65\x20\141\x64\x6d\151\x6e\x73");
        $this->notificationType = mo_("\101\144\155\151\156\151\x73\x74\x72\141\164\157\162");
        self::$instance = $this;
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $Kc)
    {
        if ($this->isEnabled) {
            goto Bp;
        }
        return;
        Bp:
        $q8 = maybe_unserialize($this->recipient);
        $EN = um_user("\165\x73\145\x72\137\154\x6f\147\x69\156");
        $Kd = um_user_profile_url();
        $tA = um_user("\x66\x69\x72\163\x74\x5f\x6e\x61\155\145");
        $Mr = um_user("\154\141\x73\x74\137\x6e\x61\x6d\145");
        $Vy = um_user("\165\163\145\x72\137\x65\x6d\x61\151\x6c");
        $ou = array("\163\151\164\x65\55\x6e\141\x6d\x65" => get_bloginfo(), "\x75\163\145\x72\x6e\x61\155\x65" => $EN, "\x61\x63\143\x6f\165\x6e\x74\x70\141\x67\x65\x2d\x75\x72\x6c" => $Kd, "\146\x69\162\x73\x74\x6e\x61\x6d\x65" => $tA, "\x6c\x61\x73\x74\156\x61\x6d\x65" => $Mr, "\145\155\141\151\154" => $Vy);
        $ou = apply_filters("\155\157\137\x75\155\x5f\x6e\x65\167\x5f\143\x75\163\164\x6f\155\145\x72\x5f\x61\x64\x6d\x69\x6e\x5f\x6e\157\x74\x69\146\137\x73\164\x72\151\156\147\x5f\x72\x65\x70\154\141\143\145", $ou);
        $O8 = MoUtility::replaceString($ou, $this->smsBody);
        if (!MoUtility::isBlank($q8)) {
            goto vV;
        }
        return;
        vV:
        foreach ($q8 as $ZI) {
            MoUtility::send_phone_notif($ZI, $O8);
            Qg:
        }
        cO:
    }
}
