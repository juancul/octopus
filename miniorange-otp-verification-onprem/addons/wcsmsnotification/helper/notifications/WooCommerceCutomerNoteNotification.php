<?php


namespace OTP\Addons\WcSMSNotification\Helper\Notifications;

use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnUtility;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class WooCommerceCutomerNoteNotification extends SMSNotification
{
    public static $instance;
    function __construct()
    {
        parent::__construct();
        $this->title = "\x43\x75\x73\x74\157\x6d\x65\x72\x20\116\157\x74\x65";
        $this->page = "\167\143\x5f\143\165\x73\x74\x6f\155\145\x72\137\x6e\x6f\x74\145\137\x6e\157\164\151\146";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\x43\125\123\x54\117\x4d\105\x52\x5f\x4e\117\124\x45\x5f\x4e\x4f\124\x49\x46\137\110\x45\x41\x44\105\x52";
        $this->tooltipBody = "\x43\x55\123\124\x4f\115\105\122\x5f\x4e\117\x54\x45\x5f\116\x4f\124\x49\106\x5f\x42\x4f\x44\131";
        $this->recipient = "\x63\165\x73\x74\157\x6d\145\x72";
        $this->smsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::CUSTOMER_NOTE_SMS);
        $this->defaultSmsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::CUSTOMER_NOTE_SMS);
        $this->availableTags = "\x7b\x6f\162\x64\145\x72\55\x64\141\x74\x65\x7d\x2c\173\157\162\144\145\162\x2d\x6e\165\155\142\145\162\175\x2c\173\x75\163\145\x72\156\141\155\145\175\54\173\x73\x69\164\x65\55\x6e\141\155\x65\175";
        $this->pageHeader = mo_("\x43\x55\123\124\x4f\115\x45\x52\40\x4e\x4f\x54\x45\x20\x4e\117\124\111\x46\x49\x43\101\x54\x49\117\x4e\40\x53\x45\x54\x54\111\x4e\107\x53");
        $this->pageDescription = mo_("\x53\115\123\x20\156\x6f\x74\x69\x66\x69\x63\x61\164\151\157\156\x73\x20\163\145\x74\164\x69\x6e\x67\x73\40\146\x6f\x72\x20\x43\x75\x73\x74\157\x6d\x65\x72\40\x4e\157\164\145\40\x53\x4d\x53\x20\163\x65\x6e\164\40\x74\x6f\40\x74\x68\x65\x20\165\x73\145\x72\163");
        $this->notificationType = mo_("\103\165\163\x74\157\155\x65\x72");
        self::$instance = $this;
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $Kc)
    {
        if ($this->isEnabled) {
            goto pC;
        }
        return;
        pC:
        $Je = $Kc["\x6f\162\144\145\x72\x44\x65\x74\141\151\x6c\163"];
        if (!MoUtility::isBlank($Je)) {
            goto c8;
        }
        return;
        c8:
        $H9 = get_userdata($Je->get_customer_id());
        $HE = get_bloginfo();
        $EN = MoUtility::isBlank($H9) ? '' : $H9->user_login;
        $ZI = MoWcAddOnUtility::getCustomerNumberFromOrder($Je);
        $Pg = $Je->get_date_created()->date_i18n();
        $Qq = $Je->get_order_number();
        $ou = array("\x73\x69\x74\x65\55\x6e\x61\x6d\x65" => $HE, "\165\x73\145\162\x6e\x61\155\145" => $EN, "\157\162\144\145\x72\x2d\144\141\164\x65" => $Pg, "\157\162\x64\145\162\x2d\156\165\x6d\142\x65\162" => $Qq);
        $ou = apply_filters("\x6d\157\137\x77\x63\x5f\x63\165\x73\164\157\155\145\162\137\x6e\157\x74\145\x5f\163\x74\162\151\156\147\137\x72\145\x70\x6c\141\x63\x65", $ou);
        $O8 = MoUtility::replaceString($ou, $this->smsBody);
        if (!MoUtility::isBlank($ZI)) {
            goto O_;
        }
        return;
        O_:
        MoUtility::send_phone_notif($ZI, $O8);
    }
}
