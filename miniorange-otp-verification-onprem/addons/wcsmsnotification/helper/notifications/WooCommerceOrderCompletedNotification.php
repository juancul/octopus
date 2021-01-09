<?php


namespace OTP\Addons\WcSMSNotification\Helper\Notifications;

use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnUtility;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class WooCommerceOrderCompletedNotification extends SMSNotification
{
    public static $instance;
    function __construct()
    {
        parent::__construct();
        $this->title = "\117\x72\x64\x65\x72\40\x43\157\x6d\160\154\x65\x74\x65\144";
        $this->page = "\167\143\137\x6f\x72\x64\x65\x72\137\x63\157\155\x70\x6c\x65\164\x65\x64\x5f\156\157\x74\151\x66";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\117\x52\104\105\122\x5f\x43\x41\x4e\103\x45\114\114\105\x44\137\x4e\117\x54\111\x46\137\x48\105\101\x44\105\x52";
        $this->tooltipBody = "\x4f\122\x44\105\122\137\x43\x41\x4e\x43\x45\x4c\x4c\105\x44\137\x4e\x4f\x54\x49\106\x5f\102\117\x44\131";
        $this->recipient = "\x63\x75\x73\x74\x6f\x6d\x65\162";
        $this->smsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_COMPLETED_SMS);
        $this->defaultSmsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_COMPLETED_SMS);
        $this->availableTags = "\x7b\163\151\x74\x65\55\x6e\x61\x6d\x65\x7d\x2c\173\157\x72\x64\x65\162\55\x6e\x75\155\x62\145\162\175\x2c\173\165\163\x65\x72\x6e\x61\155\145\x7d\x7b\x6f\162\144\145\x72\55\x64\141\164\x65\x7d";
        $this->pageHeader = mo_("\117\122\x44\x45\122\40\x43\x4f\115\120\x4c\105\x54\105\x44\40\116\117\x54\111\x46\x49\103\x41\124\x49\117\x4e\40\x53\105\x54\x54\111\x4e\107\123");
        $this->pageDescription = mo_("\x53\x4d\123\x20\x6e\x6f\164\x69\x66\x69\143\141\x74\151\157\156\163\40\x73\145\164\x74\x69\x6e\147\x73\40\x66\x6f\162\x20\x4f\x72\144\145\162\x20\103\x6f\x6d\160\154\145\164\x69\x6f\156\40\x53\x4d\x53\40\163\x65\156\x74\x20\x74\157\40\x74\150\x65\40\165\x73\x65\x72\x73");
        $this->notificationType = mo_("\103\x75\163\164\x6f\155\145\162");
        self::$instance = $this;
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $Kc)
    {
        if ($this->isEnabled) {
            goto Mu;
        }
        return;
        Mu:
        $Je = $Kc["\x6f\x72\x64\145\x72\x44\145\x74\x61\151\x6c\163"];
        if (!MoUtility::isBlank($Je)) {
            goto bI;
        }
        return;
        bI:
        $H9 = get_userdata($Je->get_customer_id());
        $HE = get_bloginfo();
        $EN = MoUtility::isBlank($H9) ? '' : $H9->user_login;
        $ZI = MoWcAddOnUtility::getCustomerNumberFromOrder($Je);
        $Pg = $Je->get_date_created()->date_i18n();
        $Qq = $Je->get_order_number();
        $ou = array("\x73\x69\164\x65\x2d\x6e\x61\x6d\145" => $HE, "\165\163\145\x72\x6e\141\x6d\145" => $EN, "\157\x72\x64\145\x72\x2d\x64\x61\164\x65" => $Pg, "\157\162\x64\145\x72\x2d\156\165\x6d\x62\145\x72" => $Qq);
        $ou = apply_filters("\155\x6f\137\x77\143\x5f\143\x75\163\164\157\155\145\162\137\157\162\144\145\162\x5f\143\157\x6d\160\154\x65\164\x65\x64\x5f\x6e\x6f\164\151\146\x5f\163\164\x72\151\156\147\x5f\162\x65\160\154\141\143\x65", $ou);
        $O8 = MoUtility::replaceString($ou, $this->smsBody);
        if (!MoUtility::isBlank($ZI)) {
            goto Bi;
        }
        return;
        Bi:
        MoUtility::send_phone_notif($ZI, $O8);
    }
}
