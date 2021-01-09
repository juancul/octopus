<?php


namespace OTP\Addons\UmSMSNotification\Helper\Notifications;

use OTP\Addons\UmSMSNotification\Helper\UltimateMemberSMSNotificationMessages;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class UltimateMemberNewCustomerNotification extends SMSNotification
{
    public static $instance;
    function __construct()
    {
        parent::__construct();
        $this->title = "\116\145\167\x20\x41\x63\x63\x6f\165\156\x74";
        $this->page = "\165\x6d\x5f\x6e\145\167\x5f\x63\x75\x73\x74\157\x6d\145\162\137\156\157\x74\151\x66";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\116\105\x57\x5f\125\115\137\103\125\123\x54\x4f\115\105\x52\137\x4e\117\124\x49\x46\x5f\110\x45\x41\x44\105\x52";
        $this->tooltipBody = "\x4e\x45\127\137\x55\x4d\x5f\x43\x55\x53\x54\117\x4d\105\x52\x5f\116\117\124\x49\x46\x5f\102\x4f\x44\x59";
        $this->recipient = "\155\x6f\x62\x69\154\145\137\156\165\x6d\x62\x65\x72";
        $this->smsBody = UltimateMemberSMSNotificationMessages::showMessage(UltimateMemberSMSNotificationMessages::NEW_UM_CUSTOMER_SMS);
        $this->defaultSmsBody = UltimateMemberSMSNotificationMessages::showMessage(UltimateMemberSMSNotificationMessages::NEW_UM_CUSTOMER_SMS);
        $this->availableTags = "\x7b\163\x69\164\x65\x2d\156\141\x6d\x65\x7d\x2c\173\165\163\x65\162\156\141\155\145\175\x2c\173\x61\143\143\157\165\156\x74\x70\141\147\x65\x2d\165\162\154\x7d\54\173\x70\141\163\x73\167\x6f\x72\144\x7d\54\173\154\157\x67\x69\x6e\55\x75\x72\154\175\x2c\173\x65\x6d\x61\151\x6c\x7d\54\173\x66\151\x72\164\156\141\155\145\x7d\x2c\x7b\154\141\x73\x74\x6e\x61\x6d\145\175";
        $this->pageHeader = mo_("\x4e\105\127\x20\101\103\103\117\125\x4e\124\x20\x4e\x4f\x54\111\106\111\x43\x41\124\111\117\x4e\x20\123\x45\x54\124\x49\116\x47\123");
        $this->pageDescription = mo_("\x53\x4d\x53\40\156\157\164\151\x66\151\x63\x61\x74\151\157\156\163\40\163\145\164\164\x69\156\x67\x73\40\146\x6f\162\40\116\145\167\x20\101\x63\x63\x6f\x75\156\164\x20\143\x72\145\x61\164\151\x6f\156\40\x53\115\x53\40\x73\x65\x6e\x74\40\164\157\40\x74\x68\x65\x20\x75\163\145\162\x73");
        $this->notificationType = mo_("\103\165\163\x74\157\x6d\145\162");
        self::$instance = $this;
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $Kc)
    {
        if ($this->isEnabled) {
            goto hk;
        }
        return;
        hk:
        $EN = um_user("\165\163\145\x72\137\154\x6f\x67\x69\x6e");
        $ZI = $Kc[$this->recipient];
        $Kd = um_user_profile_url();
        $eW = um_user("\137\x75\x6d\x5f\x63\157\157\154\137\x62\x75\164\137\x68\141\162\x64\137\164\157\x5f\147\x75\x65\x73\x73\x5f\x70\154\141\151\x6e\x5f\160\167");
        $i9 = um_get_core_page("\x6c\157\x67\x69\x6e");
        $tA = um_user("\x66\x69\162\x73\x74\x5f\156\141\155\145");
        $Mr = um_user("\x6c\141\163\164\x5f\x6e\x61\155\145");
        $Vy = um_user("\165\163\145\162\137\x65\155\x61\151\154");
        $ou = array("\x73\151\x74\145\x2d\x6e\x61\x6d\x65" => get_bloginfo(), "\x75\163\145\x72\156\141\155\x65" => $EN, "\141\143\x63\x6f\165\x6e\x74\x70\x61\147\x65\55\165\162\154" => $Kd, "\x70\x61\x73\163\167\x6f\162\144" => $eW, "\x6c\157\147\151\x6e\55\165\x72\x6c" => $i9, "\x66\x69\x72\163\x74\156\x61\155\145" => $tA, "\x6c\x61\163\164\x6e\141\x6d\145" => $Mr, "\145\155\x61\151\x6c" => $Vy);
        $ou = apply_filters("\x6d\x6f\x5f\165\x6d\137\x6e\x65\167\x5f\143\165\163\x74\x6f\155\145\162\137\x6e\x6f\164\151\146\x5f\163\x74\162\x69\x6e\147\137\x72\x65\x70\154\141\143\145", $ou);
        $O8 = MoUtility::replaceString($ou, $this->smsBody);
        if (!MoUtility::isBlank($ZI)) {
            goto sN;
        }
        return;
        sN:
        MoUtility::send_phone_notif($ZI, $O8);
    }
}
