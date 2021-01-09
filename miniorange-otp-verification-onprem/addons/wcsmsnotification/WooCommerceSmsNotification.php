<?php


namespace OTP\Addons\WcSMSNotification;

use OTP\Addons\WcSMSNotification\Handler\WooCommerceNotifications;
use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\WooCommerceNotificationsList;
use OTP\Helper\AddOnList;
use OTP\Objects\AddOnInterface;
use OTP\Objects\BaseAddOn;
use OTP\Traits\Instance;
if (defined("\x41\102\123\x50\101\124\x48")) {
    goto QQ;
}
die;
QQ:
include "\137\141\x75\164\157\154\157\141\144\x2e\x70\x68\160";
final class WooCommerceSmsNotification extends BaseAddon implements AddOnInterface
{
    use Instance;
    public function __construct()
    {
        parent::__construct();
        add_action("\x61\x64\155\x69\156\x5f\x65\156\161\x75\x65\165\x65\x5f\x73\143\162\151\160\164\x73", array($this, "\155\157\x5f\163\x6d\x73\137\156\x6f\164\x69\146\137\163\x65\164\164\x69\156\147\x73\137\163\164\171\154\x65"));
        add_action("\141\144\x6d\151\156\x5f\x65\x6e\161\x75\x65\x75\x65\x5f\x73\x63\x72\x69\160\164\163", array($this, "\x6d\x6f\137\163\155\x73\137\x6e\157\x74\151\x66\x5f\x73\145\164\164\x69\156\x67\x73\137\x73\143\x72\151\160\x74"));
        add_action("\155\x6f\x5f\x6f\164\160\x5f\166\x65\162\x69\146\x69\x63\x61\164\151\157\156\x5f\x64\x65\x6c\145\164\x65\x5f\x61\144\144\157\x6e\137\157\160\x74\151\157\x6e\163", array($this, "\x6d\157\x5f\x73\155\163\x5f\x6e\x6f\x74\151\146\137\x64\145\154\145\x74\x65\137\157\x70\164\x69\157\x6e\163"));
    }
    function mo_sms_notif_settings_style()
    {
        wp_enqueue_style("\x6d\157\137\163\155\x73\x5f\156\x6f\x74\x69\x66\137\141\x64\155\151\156\137\x73\x65\164\164\x69\156\x67\x73\x5f\163\164\x79\x6c\145", MSN_CSS_URL);
    }
    function mo_sms_notif_settings_script()
    {
        wp_register_script("\155\157\x5f\x73\155\163\x5f\x6e\157\x74\151\x66\137\x61\144\155\151\x6e\x5f\x73\x65\164\164\x69\156\x67\x73\137\163\x63\162\151\160\164", MSN_JS_URL, array("\152\161\x75\x65\x72\x79"));
        wp_localize_script("\155\x6f\137\163\155\163\x5f\x6e\157\x74\151\x66\137\x61\x64\155\151\x6e\x5f\163\145\164\x74\x69\x6e\147\163\137\163\143\162\151\160\x74", "\155\x6f\143\165\163\164\x6f\155\x6d\x73\x67", array("\x73\151\x74\145\x55\122\x4c" => admin_url()));
        wp_enqueue_script("\155\x6f\137\163\155\163\x5f\156\157\164\x69\146\x5f\141\144\155\x69\156\137\x73\x65\x74\164\x69\156\147\163\137\163\x63\162\151\160\164");
    }
    function initializeHandlers()
    {
        $WR = AddOnList::instance();
        $ty = WooCommerceNotifications::instance();
        $WR->add($ty->getAddOnKey(), $ty);
    }
    function initializeHelpers()
    {
        MoWcAddOnMessages::instance();
        WooCommerceNotificationsList::instance();
    }
    function show_addon_settings_page()
    {
        include MSN_DIR . "\x2f\x63\157\x6e\x74\162\x6f\154\x6c\x65\x72\x73\x2f\155\x61\x69\156\x2d\143\x6f\156\164\x72\157\x6c\x6c\x65\162\56\160\x68\x70";
    }
    function mo_sms_notif_delete_options()
    {
        delete_site_option("\155\x6f\137\167\143\x5f\x73\x6d\163\x5f\x6e\x6f\164\x69\x66\151\x63\141\x74\151\x6f\x6e\x5f\x73\x65\164\x74\x69\156\x67\x73");
    }
}
