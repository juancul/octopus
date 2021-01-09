<?php


namespace OTP\Addons\WcSMSNotification\Helper\Notifications;

use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnUtility;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class WooCommerceOrderRefundedNotification extends SMSNotification
{
    public static $instance;
    function __construct()
    {
        parent::__construct();
        $this->title = "\x4f\162\144\x65\162\40\x52\145\146\165\156\144\145\144";
        $this->page = "\167\x63\x5f\x6f\x72\x64\x65\162\137\162\145\x66\165\156\144\145\x64\x5f\156\x6f\x74\151\146";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\x4f\x52\104\x45\x52\137\x52\x45\x46\125\x4e\104\x45\x44\x5f\x4e\x4f\x54\111\106\137\x48\x45\101\104\x45\122";
        $this->tooltipBody = "\x4f\x52\104\x45\122\137\x52\105\125\x4e\104\x45\104\137\116\117\x54\111\106\x5f\102\x4f\x44\x59";
        $this->recipient = "\x63\x75\163\164\157\155\x65\x72";
        $this->smsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_REFUNDED_SMS);
        $this->defaultSmsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_REFUNDED_SMS);
        $this->availableTags = "\x7b\x73\151\164\145\55\156\x61\155\x65\175\54\173\157\162\144\145\162\55\156\165\x6d\142\145\162\175\54\173\165\163\145\162\x6e\141\x6d\145\175\x7b\157\162\144\x65\x72\55\x64\x61\164\x65\x7d";
        $this->pageHeader = mo_("\x4f\122\104\105\122\40\x52\x45\x46\125\x4e\104\x45\104\x20\x4e\x4f\x54\111\x46\111\103\101\x54\111\117\x4e\x20\123\x45\124\124\x49\x4e\x47\123");
        $this->pageDescription = mo_("\123\x4d\x53\x20\156\157\x74\151\x66\151\143\141\x74\x69\157\x6e\x73\40\163\x65\x74\x74\x69\x6e\147\x73\x20\146\157\x72\x20\x4f\x72\144\145\162\40\x52\x65\x66\x75\x6e\x64\x65\144\x20\123\x4d\x53\x20\163\145\x6e\164\40\164\157\x20\164\x68\x65\x20\x75\x73\x65\162\163");
        $this->notificationType = mo_("\x43\165\x73\164\x6f\x6d\145\x72");
        self::$instance = $this;
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $Kc)
    {
        if ($this->isEnabled) {
            goto CM;
        }
        return;
        CM:
        $Je = $Kc["\x6f\x72\x64\x65\x72\104\x65\x74\x61\x69\154\163"];
        if (!MoUtility::isBlank($Je)) {
            goto Bz;
        }
        return;
        Bz:
        $H9 = get_userdata($Je->get_customer_id());
        $HE = get_bloginfo();
        $EN = MoUtility::isBlank($H9) ? '' : $H9->user_login;
        $ZI = MoWcAddOnUtility::getCustomerNumberFromOrder($Je);
        $Pg = $Je->get_date_created()->date_i18n();
        $Qq = $Je->get_order_number();
        $ou = array("\163\151\x74\145\x2d\x6e\x61\x6d\x65" => $HE, "\165\x73\145\x72\x6e\141\155\145" => $EN, "\157\162\144\x65\162\x2d\144\x61\164\145" => $Pg, "\157\x72\144\x65\162\55\x6e\165\155\x62\x65\162" => $Qq);
        $ou = apply_filters("\155\157\x5f\x77\143\x5f\143\165\x73\x74\x6f\x6d\145\x72\137\x6f\162\x64\x65\162\x5f\x72\145\146\x75\156\144\x65\144\137\156\157\164\151\146\x5f\x73\164\162\151\156\147\137\x72\x65\160\x6c\x61\143\x65", $ou);
        $O8 = MoUtility::replaceString($ou, $this->smsBody);
        if (!MoUtility::isBlank($ZI)) {
            goto Ab;
        }
        return;
        Ab:
        MoUtility::send_phone_notif($ZI, $O8);
    }
}
