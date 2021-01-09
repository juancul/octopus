<?php


namespace OTP\Addons\WcSMSNotification\Helper\Notifications;

use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnUtility;
use OTP\Addons\WcSMSNotification\Helper\WcOrderStatus;
use OTP\Helper\MoUtility;
use OTP\Objects\SMSNotification;
class WooCommerceAdminOrderstatusNotification extends SMSNotification
{
    public static $instance;
    public static $statuses;
    function __construct()
    {
        parent::__construct();
        $this->title = "\x4f\x72\144\x65\162\x20\x53\164\x61\164\x75\x73";
        $this->page = "\167\x63\137\141\144\x6d\x69\x6e\x5f\x6f\x72\x64\145\162\x5f\x73\x74\x61\x74\165\x73\137\156\x6f\x74\151\x66";
        $this->isEnabled = FALSE;
        $this->tooltipHeader = "\x4e\x45\x57\x5f\x4f\122\x44\x45\x52\x5f\116\x4f\x54\x49\106\137\x48\105\101\104\x45\122";
        $this->tooltipBody = "\116\105\127\x5f\x4f\x52\x44\105\122\137\116\x4f\124\111\106\x5f\102\117\104\131";
        $this->recipient = MoWcAddOnUtility::getAdminPhoneNumber();
        $this->smsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ADMIN_STATUS_SMS);
        $this->defaultSmsBody = MoWcAddOnMessages::showMessage(MoWcAddOnMessages::ADMIN_STATUS_SMS);
        $this->availableTags = "\x7b\x73\151\164\145\x2d\156\x61\155\x65\175\x2c\173\157\x72\144\x65\162\55\x6e\x75\155\x62\x65\162\x7d\x2c\173\157\162\x64\x65\x72\x2d\x73\164\x61\164\165\163\175\54\x7b\x75\163\x65\x72\x6e\x61\x6d\145\175\x7b\x6f\162\144\145\x72\55\144\x61\x74\145\175";
        $this->pageHeader = mo_("\x4f\122\104\x45\122\40\x41\x44\x4d\x49\116\x20\123\124\x41\x54\x55\123\x20\x4e\117\x54\x49\x46\111\x43\x41\x54\111\117\116\x20\x53\105\124\x54\111\x4e\x47\x53");
        $this->pageDescription = mo_("\123\x4d\x53\40\156\x6f\164\x69\146\x69\x63\141\x74\151\157\156\x73\40\x73\x65\x74\x74\x69\156\147\163\x20\x66\157\x72\40\117\x72\144\145\162\x20\123\164\141\164\x75\163\x20\x53\x4d\123\40\163\145\x6e\164\40\164\157\40\x74\x68\145\40\141\x64\155\151\156\x73");
        $this->notificationType = mo_("\101\144\155\151\156\151\163\164\x72\x61\x74\x6f\x72");
        self::$instance = $this;
        self::$statuses = WcOrderStatus::getAllStatus();
    }
    public static function getInstance()
    {
        return self::$instance === null ? new self() : self::$instance;
    }
    function sendSMS(array $Kc)
    {
        if ($this->isEnabled) {
            goto R6;
        }
        return;
        R6:
        $Je = $Kc["\x6f\x72\x64\x65\162\104\145\x74\141\151\154\163"];
        $Xq = $Kc["\156\x65\x77\x5f\163\x74\141\x74\x75\x73"];
        if (!MoUtility::isBlank($Je)) {
            goto ED;
        }
        return;
        ED:
        if (in_array($Xq, self::$statuses)) {
            goto IR;
        }
        return;
        IR:
        $H9 = get_userdata($Je->get_customer_id());
        $HE = get_bloginfo();
        $EN = MoUtility::isBlank($H9) ? '' : $H9->user_login;
        $q8 = maybe_unserialize($this->recipient);
        $Pg = $Je->get_date_created()->date_i18n();
        $Qq = $Je->get_order_number();
        $ou = array("\x73\x69\164\145\x2d\x6e\141\155\145" => $HE, "\x75\x73\x65\x72\x6e\141\155\145" => $EN, "\x6f\162\x64\x65\162\x2d\x64\x61\x74\x65" => $Pg, "\x6f\162\x64\x65\162\55\156\x75\x6d\142\145\162" => $Qq, "\x6f\x72\x64\145\x72\55\x73\x74\x61\164\165\163" => $Xq);
        $ou = apply_filters("\155\x6f\137\167\143\137\141\x64\x6d\151\156\x5f\x6f\162\x64\145\x72\x5f\x6e\x6f\x74\x69\146\x5f\163\x74\x72\151\x6e\x67\137\162\x65\160\x6c\141\143\x65", $ou);
        $O8 = MoUtility::replaceString($ou, $this->smsBody);
        if (!MoUtility::isBlank($q8)) {
            goto PI;
        }
        return;
        PI:
        foreach ($q8 as $ZI) {
            MoUtility::send_phone_notif($ZI, $O8);
            m3:
        }
        AF:
    }
}
