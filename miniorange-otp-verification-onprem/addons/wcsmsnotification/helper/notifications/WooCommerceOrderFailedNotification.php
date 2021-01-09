<?php


namespace OTP\Addons\WcSMSNotification\Helper\Notifications;

use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnUtility;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class WooCommerceOrderFailedNotification extends SMSNotification
{
    public static $instance;
    function __construct()
    {
        parent::__construct();
        $this->title = "\x4f\x72\x64\145\162\40\106\141\x69\x6c\145\x64";
        $this->page = "\x77\x63\137\x6f\162\144\145\162\137\x66\141\151\154\x65\x64\137\156\157\164\x69\146";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\117\122\104\x45\x52\137\x46\x41\x49\x4c\x45\104\137\x4e\x4f\124\x49\x46\137\x48\105\x41\x44\x45\122";
        $this->tooltipBody = "\x4f\x52\x44\105\122\137\x46\x41\111\x4c\105\x44\x5f\116\117\124\x49\106\137\x42\117\104\131";
        $this->recipient = "\143\165\x73\164\157\155\145\x72";
        $this->smsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_FAILED_SMS);
        $this->defaultSmsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_FAILED_SMS);
        $this->availableTags = "\x7b\x73\151\164\x65\x2d\156\x61\155\x65\x7d\54\x7b\x6f\x72\x64\145\162\x2d\156\165\155\x62\145\162\175\54\x7b\x75\163\x65\162\x6e\x61\x6d\145\175\173\157\x72\144\x65\x72\x2d\x64\x61\x74\145\x7d";
        $this->pageHeader = mo_("\x4f\122\104\x45\122\x20\x46\101\x49\x4c\105\x44\40\x4e\117\124\x49\106\111\x43\101\124\x49\117\x4e\x20\123\x45\x54\x54\111\116\x47\x53");
        $this->pageDescription = mo_("\x53\115\123\40\156\x6f\164\151\146\x69\x63\141\164\151\x6f\x6e\x73\40\163\145\164\164\x69\x6e\147\x73\x20\x66\157\162\40\x4f\x72\144\145\x72\40\146\x61\151\154\x75\162\145\40\123\x4d\x53\x20\x73\x65\156\x74\40\164\x6f\40\164\150\145\x20\x75\x73\145\x72\163");
        $this->notificationType = mo_("\103\165\163\x74\157\155\145\x72");
        self::$instance = $this;
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $Kc)
    {
        if ($this->isEnabled) {
            goto Rf;
        }
        return;
        Rf:
        $Je = $Kc["\x6f\x72\144\145\162\x44\145\x74\x61\x69\x6c\x73"];
        if (!MoUtility::isBlank($Je)) {
            goto LZ;
        }
        return;
        LZ:
        $H9 = get_userdata($Je->get_customer_id());
        $HE = get_bloginfo();
        $EN = MoUtility::isBlank($H9) ? '' : $H9->user_login;
        $ZI = MoWcAddOnUtility::getCustomerNumberFromOrder($Je);
        $Pg = $Je->get_date_created()->date_i18n();
        $Qq = $Je->get_order_number();
        $ou = array("\163\151\x74\145\x2d\156\141\x6d\x65" => $HE, "\165\x73\145\x72\x6e\x61\155\x65" => $EN, "\x6f\162\144\145\162\x2d\144\x61\164\145" => $Pg, "\x6f\162\144\145\162\55\156\165\x6d\x62\145\162" => $Qq);
        $ou = apply_filters("\x6d\x6f\137\x77\143\137\143\165\163\x74\157\155\x65\x72\x5f\x6f\162\144\x65\162\137\x66\x61\x69\x6c\145\x64\137\x6e\x6f\x74\x69\x66\x5f\163\x74\162\x69\x6e\x67\x5f\162\x65\160\x6c\x61\x63\x65", $ou);
        $O8 = MoUtility::replaceString($ou, $this->smsBody);
        if (!MoUtility::isBlank($ZI)) {
            goto OS;
        }
        return;
        OS:
        MoUtility::send_phone_notif($ZI, $O8);
    }
}
