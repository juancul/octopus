<?php


namespace OTP\Addons\UmSMSNotification;

use OTP\Addons\UmSMSNotification\Handler\UltimateMemberSMSNotificationsHandler;
use OTP\Addons\UmSMSNotification\Helper\UltimateMemberNotificationsList;
use OTP\Addons\UmSMSNotification\Helper\UltimateMemberSMSNotificationMessages;
use OTP\Helper\AddOnList;
use OTP\Objects\AddOnInterface;
use OTP\Objects\BaseAddOn;
use OTP\Traits\Instance;
if (defined("\x41\102\123\120\x41\124\x48")) {
    goto HF;
}
die;
HF:
include "\x5f\x61\x75\x74\x6f\x6c\x6f\x61\144\56\160\x68\x70";
final class UltimateMemberSmsNotification extends BaseAddon implements AddOnInterface
{
    use Instance;
    public function __construct()
    {
        parent::__construct();
        add_action("\141\144\155\x69\156\x5f\145\156\x71\x75\x65\x75\x65\x5f\x73\143\x72\151\160\x74\163", array($this, "\165\x6d\x5f\163\x6d\163\x5f\156\x6f\164\x69\146\137\x73\x65\x74\164\x69\156\147\x73\x5f\x73\164\x79\x6c\x65"));
        add_action("\x6d\157\x5f\157\164\x70\x5f\x76\x65\162\151\x66\151\143\x61\164\151\157\x6e\x5f\x64\145\154\145\164\x65\137\141\x64\144\157\x6e\137\x6f\x70\164\x69\157\156\163", array($this, "\x75\155\137\163\x6d\163\x5f\156\x6f\164\151\146\x5f\x64\145\154\x65\164\x65\x5f\x6f\x70\164\x69\x6f\156\x73"));
    }
    function um_sms_notif_settings_style()
    {
        wp_enqueue_style("\x75\155\x5f\x73\x6d\163\137\156\157\164\x69\146\137\x61\144\155\151\x6e\137\163\145\x74\164\x69\156\x67\x73\x5f\x73\x74\171\x6c\x65", UMSN_CSS_URL);
    }
    function initializeHandlers()
    {
        $WR = AddOnList::instance();
        $ty = UltimateMemberSMSNotificationsHandler::instance();
        $WR->add($ty->getAddOnKey(), $ty);
    }
    function initializeHelpers()
    {
        UltimateMemberSMSNotificationMessages::instance();
        UltimateMemberNotificationsList::instance();
    }
    function show_addon_settings_page()
    {
        include UMSN_DIR . "\x2f\x63\x6f\x6e\x74\x72\x6f\x6c\x6c\x65\x72\163\57\155\x61\x69\x6e\55\x63\x6f\x6e\164\x72\x6f\154\x6c\145\x72\56\x70\x68\160";
    }
    function um_sms_notif_delete_options()
    {
        delete_site_option("\x6d\x6f\x5f\165\155\x5f\x73\x6d\x73\x5f\156\157\x74\151\146\x69\143\x61\164\151\157\156\x5f\163\x65\x74\164\151\156\x67\x73");
    }
}
