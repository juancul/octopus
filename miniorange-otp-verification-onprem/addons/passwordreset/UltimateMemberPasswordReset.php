<?php


namespace OTP\Addons\PasswordReset;

use OTP\Addons\PasswordReset\Handler\UMPasswordResetAddOnHandler;
use OTP\Addons\PasswordReset\Helper\UMPasswordResetMessages;
use OTP\Helper\AddOnList;
use OTP\Objects\AddOnInterface;
use OTP\Objects\BaseAddOn;
use OTP\Traits\Instance;
if (defined("\x41\x42\x53\120\101\124\110")) {
    goto oH;
}
die;
oH:
include "\137\x61\165\164\x6f\x6c\x6f\x61\x64\56\160\x68\160";
final class UltimateMemberPasswordReset extends BaseAddOn implements AddOnInterface
{
    use Instance;
    public function __construct()
    {
        parent::__construct();
        add_action("\x61\144\x6d\151\156\x5f\x65\x6e\161\165\145\x75\x65\137\163\143\162\151\x70\164\163", array($this, "\165\155\x5f\x70\x72\x5f\x6e\157\164\x69\x66\x5f\163\145\164\x74\151\156\x67\163\137\163\x74\171\x6c\x65"));
        add_action("\155\157\137\x6f\164\x70\137\166\145\162\x69\146\151\143\141\164\x69\x6f\x6e\137\x64\145\154\145\164\145\137\141\144\x64\157\x6e\137\157\160\164\x69\157\156\x73", array($this, "\165\155\x5f\x70\x72\x5f\156\x6f\164\x69\146\137\144\145\154\x65\164\145\137\157\x70\x74\x69\x6f\156\163"));
    }
    function um_pr_notif_settings_style()
    {
        wp_enqueue_style("\x75\x6d\x5f\x70\162\137\x6e\x6f\x74\x69\x66\x5f\141\144\x6d\x69\x6e\137\163\x65\x74\164\151\x6e\x67\x73\x5f\163\x74\x79\x6c\x65", UMPR_CSS_URL);
    }
    function initializeHandlers()
    {
        $WR = AddOnList::instance();
        $ty = UMPasswordResetAddOnHandler::instance();
        $WR->add($ty->getAddOnKey(), $ty);
    }
    function initializeHelpers()
    {
        UMPasswordResetMessages::instance();
    }
    function show_addon_settings_page()
    {
        include UMPR_DIR . "\143\157\x6e\x74\x72\157\x6c\154\145\162\x73\x2f\155\141\151\x6e\55\x63\157\x6e\164\x72\157\x6c\154\145\162\56\160\150\160";
    }
    function um_pr_notif_delete_options()
    {
        delete_site_option("\x6d\x6f\x5f\x75\155\137\x70\x72\137\160\141\163\163\x5f\x65\156\141\x62\154\145");
        delete_site_option("\155\x6f\x5f\165\x6d\x5f\160\x72\x5f\x70\141\163\163\x5f\142\165\164\x74\x6f\x6e\x5f\164\145\x78\x74");
        delete_site_option("\x6d\x6f\137\x75\155\137\x70\162\x5f\145\x6e\x61\142\154\x65\x64\x5f\164\x79\160\145");
    }
}
