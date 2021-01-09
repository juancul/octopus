<?php


namespace OTP\Helper;

if (defined("\x41\102\123\x50\x41\x54\x48")) {
    goto gU;
}
die;
gU:
use OTP\Addons\CustomMessage\MiniOrangeCustomMessage;
use OTP\Addons\PasswordReset\UltimateMemberPasswordReset;
use OTP\Addons\UmSMSNotification\UltimateMemberSmsNotification;
use OTP\Addons\WcSMSNotification\WooCommerceSmsNotification;
use OTP\Objects\BaseAddOnHandler;
use OTP\Objects\IGatewayFunctions;
use OTP\Traits\Instance;
class CustomGatewayWithAddons extends CustomGateway implements IGatewayFunctions
{
    use Instance;
    protected $applicationName = "\x77\160\x5f\x65\x6d\x61\x69\154\137\x76\x65\x72\151\x66\x69\143\141\x74\151\x6f\156\x5f\x69\156\164\162\x61\x6e\x65\164";
    public function registerAddOns()
    {
        UltimateMemberSmsNotification::instance();
        WooCommerceSmsNotification::instance();
        MiniOrangeCustomMessage::instance();
        UltimateMemberPasswordReset::instance();
    }
    public function showAddOnList()
    {
        $Rj = AddOnList::instance();
        $Rj = $Rj->getList();
        foreach ($Rj as $sX) {
            echo "\x3c\x74\162\x3e\12\40\40\x20\x20\40\40\40\x20\x20\40\x20\40\x20\x20\x20\x20\40\x20\x20\x20\x3c\x74\144\40\x63\154\141\x73\x73\75\42\141\144\x64\157\156\55\x74\141\142\154\145\x2d\154\151\163\x74\x2d\x73\164\141\x74\x75\163\x22\76\xa\40\x20\40\x20\x20\x20\x20\x20\40\x20\40\40\x20\x20\40\40\x20\x20\40\40\40\40\x20\40" . $sX->getAddOnName() . "\12\x20\x20\x20\40\x20\40\40\40\40\x20\x20\x20\x20\40\40\40\x20\x20\40\40\x3c\57\164\x64\76\12\40\x20\x20\x20\40\x20\40\x20\x20\x20\x20\x20\40\x20\40\x20\x20\40\40\x20\74\x74\x64\40\143\154\x61\163\x73\75\x22\141\x64\144\x6f\156\x2d\x74\x61\x62\154\145\55\x6c\x69\x73\x74\x2d\x6e\x61\x6d\145\42\x3e\xa\40\x20\40\x20\40\40\40\40\x20\x20\40\40\40\40\40\40\x20\x20\x20\x20\x20\40\x20\x20\74\x69\76\xa\40\x20\40\x20\x20\40\40\x20\x20\x20\40\x20\x20\40\40\x20\40\x20\40\x20\40\40\x20\x20\40\x20\40\x20" . $sX->getAddOnDesc() . "\xa\x20\x20\x20\40\40\x20\x20\x20\x20\x20\40\x20\x20\40\x20\40\x20\40\x20\x20\x20\x20\40\x20\x3c\x2f\x69\x3e\12\40\x20\x20\x20\x20\40\x20\40\40\40\40\x20\40\x20\40\40\x20\x20\x20\x20\74\x2f\x74\x64\x3e\xa\40\40\x20\40\40\x20\40\x20\x20\40\40\x20\40\40\x20\40\x20\40\x20\40\74\x74\144\x20\x63\x6c\x61\x73\x73\x3d\x22\x61\x64\x64\x6f\x6e\x2d\x74\x61\x62\x6c\x65\55\154\x69\x73\x74\x2d\x61\143\164\x69\x6f\156\163\x22\76\xa\40\40\40\40\40\40\x20\x20\40\x20\40\x20\40\x20\x20\40\x20\x20\x20\40\40\40\x20\x20\x3c\x61\x20\40\143\154\141\163\163\75\42\142\165\164\164\x6f\156\55\x70\x72\151\x6d\141\162\171\40\x62\165\164\164\157\156\x20\164\x69\160\x73\42\40\12\x20\x20\40\x20\x20\40\x20\x20\x20\40\x20\40\40\x20\40\x20\40\40\x20\x20\x20\40\40\40\x20\40\x20\x20\x68\x72\145\146\75\42" . $sX->getSettingsUrl() . "\42\x3e\12\40\x20\x20\x20\x20\x20\40\x20\x20\x20\x20\x20\40\x20\x20\x20\40\x20\40\x20\40\40\x20\40\x20\40\40\x20" . mo_("\123\x65\164\164\x69\x6e\147\x73") . "\12\x20\40\x20\x20\x20\x20\40\40\40\x20\40\x20\40\x20\40\x20\40\40\40\40\40\40\40\40\74\x2f\x61\x3e\xa\x20\40\x20\40\x20\x20\40\40\x20\40\x20\x20\x20\40\x20\40\x20\40\40\x20\74\x2f\x74\144\76\12\40\x20\40\x20\40\40\x20\x20\x20\x20\40\40\40\40\40\40\x3c\57\x74\x72\x3e";
            Dd:
        }
        bJ:
    }
    public function getConfigPagePointers()
    {
        return array();
    }
}
