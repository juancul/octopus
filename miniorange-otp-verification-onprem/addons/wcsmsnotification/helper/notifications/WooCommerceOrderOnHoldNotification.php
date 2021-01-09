<?php


namespace OTP\Addons\WcSMSNotification\Helper\Notifications;

use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnUtility;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class WooCommerceOrderOnHoldNotification extends SMSNotification
{
    public static $instance;
    function __construct()
    {
        parent::__construct();
        $this->title = "\117\x72\x64\x65\162\40\x6f\156\55\x68\157\154\x64";
        $this->page = "\x77\143\x5f\x6f\162\144\x65\x72\x5f\157\x6e\x5f\150\x6f\154\144\x5f\156\157\x74\151\x66";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\117\122\x44\105\x52\x5f\117\x4e\x5f\x48\117\114\104\x5f\x4e\117\124\111\x46\137\110\105\101\x44\x45\x52";
        $this->tooltipBody = "\x4f\122\x44\105\122\x5f\117\x4e\137\x48\117\x4c\104\137\x4e\x4f\x54\111\x46\137\102\117\x44\131";
        $this->recipient = "\x63\x75\163\x74\x6f\155\x65\x72";
        $this->smsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_ON_HOLD_SMS);
        $this->defaultSmsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_ON_HOLD_SMS);
        $this->availableTags = "\x7b\x73\151\164\x65\55\156\141\x6d\x65\x7d\54\173\x6f\x72\x64\x65\x72\55\156\x75\x6d\x62\145\x72\175\54\x7b\x75\163\145\x72\156\141\155\x65\175\x7b\157\162\x64\x65\162\55\x64\141\164\x65\x7d";
        $this->pageHeader = mo_("\117\122\104\x45\122\x20\117\116\x2d\x48\x4f\114\104\x20\116\x4f\x54\x49\106\x49\103\x41\124\111\x4f\116\40\x53\105\124\x54\111\x4e\x47\123");
        $this->pageDescription = mo_("\123\115\x53\x20\156\x6f\164\x69\x66\151\143\x61\164\151\x6f\x6e\163\40\163\145\x74\x74\x69\x6e\x67\x73\x20\x66\x6f\162\x20\x4f\162\144\145\x72\x20\157\x6e\55\150\x6f\x6c\x64\x20\x53\x4d\x53\40\x73\x65\x6e\x74\40\x74\157\40\x74\150\x65\40\165\163\145\162\163");
        $this->notificationType = mo_("\x43\x75\x73\164\157\x6d\x65\x72");
        self::$instance = $this;
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $Kc)
    {
        if ($this->isEnabled) {
            goto jf;
        }
        return;
        jf:
        $Je = $Kc["\x6f\x72\144\x65\x72\104\145\x74\141\x69\154\163"];
        if (!MoUtility::isBlank($Je)) {
            goto Eo;
        }
        return;
        Eo:
        $H9 = get_userdata($Je->get_customer_id());
        $HE = get_bloginfo();
        $EN = MoUtility::isBlank($H9) ? '' : $H9->user_login;
        $ZI = MoWcAddOnUtility::getCustomerNumberFromOrder($Je);
        $Pg = $Je->get_date_created()->date_i18n();
        $Qq = $Je->get_order_number();
        $ou = array("\x73\151\164\145\55\x6e\x61\155\145" => $HE, "\x75\x73\x65\162\x6e\141\x6d\x65" => $EN, "\157\162\x64\x65\162\55\144\x61\164\145" => $Pg, "\x6f\x72\x64\x65\x72\55\156\x75\155\x62\x65\162" => $Qq);
        $ou = apply_filters("\155\x6f\137\x77\x63\137\143\x75\163\x74\157\x6d\145\162\137\157\x72\x64\145\162\x5f\x6f\x6e\150\x6f\154\x64\137\156\x6f\x74\x69\146\137\x73\164\162\151\156\x67\137\x72\x65\160\x6c\141\x63\145", $ou);
        $O8 = MoUtility::replaceString($ou, $this->smsBody);
        if (!MoUtility::isBlank($ZI)) {
            goto jg;
        }
        return;
        jg:
        MoUtility::send_phone_notif($ZI, $O8);
    }
}
