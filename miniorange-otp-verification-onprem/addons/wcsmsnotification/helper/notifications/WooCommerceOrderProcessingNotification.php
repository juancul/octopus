<?php


namespace OTP\Addons\WcSMSNotification\Helper\Notifications;

use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnUtility;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class WooCommerceOrderProcessingNotification extends SMSNotification
{
    public static $instance;
    function __construct()
    {
        parent::__construct();
        $this->title = "\x50\162\x6f\x63\x65\163\163\x69\156\x67\40\117\162\144\x65\x72";
        $this->page = "\x77\143\137\157\162\144\145\162\x5f\160\x72\157\x63\145\163\x73\151\156\x67\x5f\156\x6f\x74\x69\146";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\117\122\104\105\122\x5f\120\122\117\103\x45\123\123\111\116\107\x5f\x4e\117\124\x49\x46\x5f\x48\105\101\x44\x45\122";
        $this->tooltipBody = "\x4f\x52\104\105\x52\137\x50\122\117\103\x45\123\123\111\x4e\x47\x5f\x4e\117\124\x49\106\137\x42\x4f\x44\131";
        $this->recipient = "\143\165\x73\x74\157\155\x65\162";
        $this->smsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::PROCESSING_ORDER_SMS);
        $this->defaultSmsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::PROCESSING_ORDER_SMS);
        $this->availableTags = "\x7b\x73\x69\x74\x65\55\x6e\x61\x6d\x65\x7d\x2c\173\x6f\x72\144\145\x72\x2d\x6e\x75\x6d\x62\x65\162\x7d\x2c\173\x75\163\x65\x72\156\x61\x6d\x65\x7d\173\x6f\162\x64\145\162\55\x64\x61\x74\x65\175";
        $this->pageHeader = mo_("\117\122\x44\x45\122\40\120\x52\x4f\x43\105\123\123\111\x4e\107\40\x4e\117\x54\111\106\111\x43\101\x54\x49\x4f\x4e\40\123\x45\124\124\111\x4e\107\123");
        $this->pageDescription = mo_("\x53\115\123\40\156\x6f\x74\x69\146\x69\x63\x61\164\151\157\x6e\x73\40\163\145\164\x74\x69\156\147\x73\40\x66\x6f\x72\x20\117\162\x64\x65\162\x20\x50\162\157\143\145\x73\x73\x69\156\x67\x20\x53\115\123\40\x73\x65\156\x74\x20\x74\157\x20\164\150\145\x20\165\x73\145\x72\163");
        $this->notificationType = mo_("\x43\165\x73\164\x6f\155\x65\162");
        self::$instance = $this;
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $Kc)
    {
        if ($this->isEnabled) {
            goto I_;
        }
        return;
        I_:
        $Je = $Kc["\157\x72\144\145\x72\x44\x65\164\x61\x69\154\x73"];
        if (!MoUtility::isBlank($Je)) {
            goto tY;
        }
        return;
        tY:
        $H9 = get_userdata($Je->get_customer_id());
        $HE = get_bloginfo();
        $EN = MoUtility::isBlank($H9) ? '' : $H9->user_login;
        $ZI = MoWcAddOnUtility::getCustomerNumberFromOrder($Je);
        $Pg = $Je->get_date_created()->date_i18n();
        $Qq = $Je->get_order_number();
        $ou = array("\x73\x69\164\145\55\156\x61\x6d\145" => $HE, "\165\163\x65\x72\x6e\141\x6d\145" => $EN, "\157\162\144\145\162\55\144\x61\x74\145" => $Pg, "\157\x72\x64\x65\x72\x2d\156\x75\155\142\145\162" => $Qq);
        $ou = apply_filters("\155\157\137\167\143\x5f\143\165\x73\164\157\155\x65\162\x5f\x6f\162\144\x65\162\137\160\162\x6f\143\x65\x73\x73\x69\156\147\x5f\x6e\157\x74\151\146\137\x73\164\x72\151\x6e\147\x5f\162\x65\x70\x6c\x61\x63\145", $ou);
        $O8 = MoUtility::replaceString($ou, $this->smsBody);
        if (!MoUtility::isBlank($ZI)) {
            goto w1;
        }
        return;
        w1:
        MoUtility::send_phone_notif($ZI, $O8);
    }
}
