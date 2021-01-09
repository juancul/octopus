<?php


namespace OTP\Addons\WcSMSNotification\Helper\Notifications;

use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class WooCommerceNewCustomerNotification extends SMSNotification
{
    public static $instance;
    function __construct()
    {
        parent::__construct();
        $this->title = "\116\145\x77\40\101\143\143\157\x75\x6e\x74";
        $this->page = "\167\143\x5f\x6e\x65\167\x5f\143\165\163\164\157\x6d\x65\x72\x5f\156\x6f\x74\151\146";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\x4e\105\x57\x5f\103\x55\123\x54\x4f\115\105\122\137\116\117\124\111\x46\x5f\110\x45\x41\104\105\122";
        $this->tooltipBody = "\x4e\x45\127\x5f\103\125\123\x54\117\x4d\105\x52\x5f\x4e\x4f\x54\x49\106\137\102\x4f\104\x59";
        $this->recipient = "\x63\165\x73\x74\157\155\x65\162";
        $this->smsBody = get_wc_option("\x77\157\157\143\x6f\x6d\x6d\x65\x72\x63\145\137\162\x65\147\x69\x73\x74\162\141\x74\151\157\156\x5f\147\145\156\x65\162\x61\164\x65\x5f\x70\141\x73\x73\167\157\x72\x64", '') === "\171\x65\x73" ? MoWcAddOnMessages::showMessage(MoWcAddOnMessages::NEW_CUSTOMER_SMS_WITH_PASS) : MoWcAddOnMessages::showMessage(MoWcAddOnMessages::NEW_CUSTOMER_SMS);
        $this->defaultSmsBody = get_wc_option("\167\157\157\143\157\155\155\x65\x72\143\145\x5f\x72\x65\x67\x69\x73\x74\162\x61\x74\151\157\156\137\147\x65\156\145\162\141\x74\145\137\x70\x61\x73\163\167\157\x72\144", '') === "\x79\x65\x73" ? MoWcAddOnMessages::showMessage(MoWcAddOnMessages::NEW_CUSTOMER_SMS_WITH_PASS) : MoWcAddOnMessages::showMessage(MoWcAddOnMessages::NEW_CUSTOMER_SMS);
        $this->availableTags = "\x7b\x73\x69\x74\145\x2d\156\141\155\145\x7d\x2c\173\x75\163\x65\x72\x6e\x61\155\145\x7d\x2c\173\160\141\163\163\167\157\162\144\175\x2c\x7b\141\143\143\x6f\x75\156\x74\x70\x61\x67\x65\x2d\165\x72\154\x7d";
        $this->pageHeader = mo_("\x4e\105\127\x20\x41\103\x43\117\x55\x4e\124\x20\x4e\117\124\x49\x46\x49\103\101\124\x49\117\x4e\40\123\105\x54\x54\111\x4e\x47\123");
        $this->pageDescription = mo_("\123\x4d\123\40\156\157\164\151\146\x69\x63\x61\x74\151\x6f\156\x73\x20\x73\145\164\164\151\x6e\147\x73\x20\146\157\162\40\x4e\x65\x77\x20\101\143\143\x6f\165\156\x74\x20\143\x72\x65\x61\x74\x69\157\156\40\123\x4d\123\40\x73\145\156\164\x20\164\x6f\40\x74\x68\x65\40\165\x73\x65\162\163");
        $this->notificationType = mo_("\x43\x75\163\164\x6f\x6d\145\162");
        self::$instance = $this;
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $Kc)
    {
        if ($this->isEnabled) {
            goto a2;
        }
        return;
        a2:
        $Op = $Kc["\143\x75\163\x74\157\x6d\x65\162\x5f\151\x64"];
        $Jd = $Kc["\156\145\167\137\x63\x75\163\164\157\x6d\x65\x72\x5f\144\141\164\141"];
        $HE = get_bloginfo();
        $EN = get_userdata($Op)->user_login;
        $ZI = get_user_meta($Op, "\142\x69\154\154\151\156\147\137\160\x68\157\156\145", TRUE);
        $yM = MoUtility::sanitizeCheck("\x62\x69\154\154\x69\156\x67\x5f\x70\x68\157\x6e\x65", $_POST);
        $ZI = MoUtility::isBlank($ZI) && $yM ? $yM : $ZI;
        $eW = !empty($Jd["\x75\163\x65\x72\x5f\x70\x61\163\163"]) ? $Jd["\x75\x73\145\x72\137\160\141\163\163"] : '';
        $pZ = wc_get_page_permalink("\x6d\x79\x61\143\x63\x6f\x75\x6e\164");
        $ou = array("\163\x69\164\145\x2d\156\141\155\x65" => get_bloginfo(), "\x75\x73\145\162\156\141\155\145" => $EN, "\x70\x61\x73\x73\167\157\162\144" => $eW, "\x61\x63\x63\157\165\156\x74\160\141\147\145\55\x75\162\154" => $pZ);
        $ou = apply_filters("\x6d\x6f\137\167\143\137\x6e\x65\167\x5f\x63\x75\163\x74\x6f\155\145\162\x5f\x6e\x6f\x74\x69\x66\x5f\x73\164\162\151\156\x67\137\162\145\x70\154\x61\x63\145", $ou);
        $O8 = MoUtility::replaceString($ou, $this->smsBody);
        if (!MoUtility::isBlank($ZI)) {
            goto iK;
        }
        return;
        iK:
        MoUtility::send_phone_notif($ZI, $O8);
    }
}
