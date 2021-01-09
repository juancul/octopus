<?php


namespace OTP\Addons\WcSMSNotification\Helper\Notifications;

use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnUtility;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class WooCommerceOrderPendingNotification extends SMSNotification
{
    public static $instance;
    function __construct()
    {
        parent::__construct();
        $this->title = "\x4f\x72\x64\x65\x72\40\120\x65\156\x64\x69\156\x67\40\120\x61\171\155\x65\x6e\x74";
        $this->page = "\167\143\137\157\x72\x64\x65\162\x5f\160\x65\156\144\151\x6e\147\x5f\x6e\157\x74\x69\146";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\117\122\104\105\x52\x5f\x50\105\x4e\x44\111\x4e\107\137\x4e\x4f\x54\x49\x46\137\x48\x45\x41\104\105\122";
        $this->tooltipBody = "\117\x52\104\x45\x52\x5f\120\105\116\x44\111\116\107\137\116\x4f\x54\111\106\137\x42\x4f\x44\131";
        $this->recipient = "\143\165\x73\x74\x6f\x6d\145\x72";
        $this->smsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_PENDING_SMS);
        $this->defaultSmsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ORDER_PENDING_SMS);
        $this->availableTags = "\x7b\163\151\164\x65\x2d\x6e\141\x6d\145\x7d\54\173\x6f\162\144\145\x72\55\x6e\x75\155\142\x65\x72\175\x2c\173\x75\163\145\162\x6e\141\155\145\x7d\173\x6f\x72\144\145\162\55\x64\141\164\145\175";
        $this->pageHeader = mo_("\117\122\x44\105\122\x20\x50\105\x4e\104\111\116\x47\x20\x50\101\x59\115\105\x4e\124\40\116\x4f\124\x49\106\x49\103\x41\124\x49\117\116\x20\123\105\124\x54\111\116\x47\x53");
        $this->pageDescription = mo_("\x53\x4d\123\x20\x6e\157\x74\x69\146\x69\143\141\164\x69\x6f\x6e\x73\x20\163\x65\x74\164\x69\156\147\x73\40\x66\x6f\x72\40\117\x72\x64\x65\162\40\x50\x65\x6e\144\x69\156\x67\40\120\141\x79\x6d\x65\156\x74\40\x53\115\x53\40\x73\145\156\x74\40\164\x6f\40\164\150\145\x20\x75\x73\x65\162\x73");
        $this->notificationType = mo_("\x43\x75\x73\x74\x6f\155\145\162");
        self::$instance = $this;
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $Kc)
    {
        if ($this->isEnabled) {
            goto cK;
        }
        return;
        cK:
        $Je = $Kc["\157\162\144\x65\x72\104\x65\x74\141\151\x6c\163"];
        if (!MoUtility::isBlank($Je)) {
            goto di;
        }
        return;
        di:
        $H9 = get_userdata($Je->get_customer_id());
        $HE = get_bloginfo();
        $EN = MoUtility::isBlank($H9) ? '' : $H9->user_login;
        $ZI = MoWcAddOnUtility::getCustomerNumberFromOrder($Je);
        $Pg = $Je->get_date_created()->date_i18n();
        $Qq = $Je->get_order_number();
        $ou = array("\163\151\164\145\x2d\x6e\x61\x6d\x65" => $HE, "\165\x73\x65\162\156\x61\x6d\x65" => $EN, "\157\x72\x64\145\162\55\144\141\x74\x65" => $Pg, "\x6f\162\x64\x65\x72\x2d\156\165\155\x62\x65\162" => $Qq);
        $ou = apply_filters("\155\x6f\x5f\167\143\137\x63\165\163\x74\157\x6d\145\x72\137\x6f\162\x64\145\x72\x5f\160\145\x6e\x64\x69\156\147\x5f\x6e\x6f\164\151\146\137\x73\164\x72\x69\156\147\137\x72\x65\x70\154\x61\143\145", $ou);
        $O8 = MoUtility::replaceString($ou, $this->smsBody);
        if (!MoUtility::isBlank($ZI)) {
            goto Pt;
        }
        return;
        Pt:
        MoUtility::send_phone_notif($ZI, $O8);
    }
}
