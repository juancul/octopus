<?php


namespace OTP\Addons\WcSMSNotification\Helper\Notifications;

use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnUtility;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class WooCommerceOrderCancelledNotification extends SMSNotification
{
    public static $instance;
    function __construct()
    {
        parent::__construct();
        $this->title = "\117\x72\x64\145\162\40\x43\141\156\x63\145\x6c\x6c\145\x64";
        $this->page = "\167\x63\137\157\x72\x64\145\x72\x5f\x63\141\x6e\143\x65\154\x6c\145\144\137\156\x6f\x74\151\x66";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\x4f\x52\x44\x45\122\x5f\x43\x41\116\x43\x45\x4c\x4c\105\x44\x5f\116\x4f\124\111\106\x5f\110\105\101\104\105\122";
        $this->tooltipBody = "\x4f\122\104\105\x52\137\103\x41\x4e\103\105\x4c\x4c\x45\x44\137\x4e\x4f\124\111\106\x5f\x42\x4f\104\x59";
        $this->recipient = "\143\165\x73\x74\157\155\x65\x72";
        $this->smsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_CANCELLED_SMS);
        $this->defaultSmsBodsy = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_CANCELLED_SMS);
        $this->availableTags = "\x7b\163\x69\x74\x65\x2d\x6e\141\x6d\145\x7d\x2c\173\157\x72\x64\145\x72\x2d\x6e\x75\x6d\142\x65\x72\x7d\54\173\x75\x73\145\x72\156\141\x6d\145\175\x7b\157\162\x64\x65\x72\55\x64\x61\x74\x65\x7d";
        $this->pageHeader = mo_("\117\122\x44\105\122\40\103\101\x4e\103\105\114\x4c\105\x44\40\x4e\117\124\x49\x46\x49\x43\101\x54\111\117\x4e\x20\123\x45\x54\124\111\x4e\107\x53");
        $this->pageDescription = mo_("\x53\115\123\x20\x6e\157\164\151\146\x69\x63\141\x74\x69\x6f\x6e\x73\40\x73\x65\164\164\151\x6e\147\163\x20\x66\x6f\x72\x20\x4f\162\x64\145\162\40\x43\x61\x6e\x63\145\x6c\x6c\141\164\x69\x6f\x6e\x20\x53\115\123\40\x73\x65\156\x74\40\164\157\40\x74\x68\145\40\165\x73\145\162\163");
        $this->notificationType = mo_("\x43\165\163\164\x6f\155\145\x72");
        self::$instance = $this;
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $Kc)
    {
        if ($this->isEnabled) {
            goto WO;
        }
        return;
        WO:
        $Je = $Kc["\157\162\144\145\162\104\145\164\141\151\x6c\x73"];
        if (!MoUtility::isBlank($Je)) {
            goto CR;
        }
        return;
        CR:
        $H9 = get_userdata($Je->get_customer_id());
        $HE = get_bloginfo();
        $EN = MoUtility::isBlank($H9) ? '' : $H9->user_login;
        $ZI = MoWcAddOnUtility::getCustomerNumberFromOrder($Je);
        $Pg = $Je->get_date_created()->date_i18n();
        $Qq = $Je->get_order_number();
        $ou = array("\163\151\164\x65\x2d\x6e\141\x6d\145" => $HE, "\x75\x73\145\162\156\x61\155\145" => $EN, "\157\x72\x64\x65\162\55\x64\141\x74\145" => $Pg, "\157\162\144\145\x72\x2d\x6e\x75\155\x62\145\x72" => $Qq);
        $ou = apply_filters("\155\157\x5f\167\143\x5f\x63\165\x73\x74\x6f\x6d\145\162\137\157\162\x64\x65\162\x5f\x63\x61\156\143\x65\x6c\x6c\145\x64\x5f\156\x6f\164\151\146\137\x73\x74\162\x69\156\147\x5f\x72\x65\x70\154\x61\x63\145", $ou);
        $O8 = MoUtility::replaceString($ou, $this->smsBody);
        if (!MoUtility::isBlank($ZI)) {
            goto Ss;
        }
        return;
        Ss:
        MoUtility::send_phone_notif($ZI, $O8);
    }
}
