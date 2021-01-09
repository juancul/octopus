<?php


namespace OTP\Addons\PasswordReset\Handler;

use OTP\Objects\BaseAddOnHandler;
use OTP\Traits\Instance;
class UMPasswordResetAddOnHandler extends BaseAddOnHandler
{
    use Instance;
    function __construct()
    {
        parent::__construct();
        if ($this->moAddOnV()) {
            goto AG;
        }
        return;
        AG:
        UMPasswordResetHandler::instance();
    }
    function setAddonKey()
    {
        $this->_addOnKey = "\x75\x6d\137\160\141\163\163\x5f\x72\145\x73\x65\x74\137\x61\x64\144\x6f\x6e";
    }
    function setAddOnDesc()
    {
        $this->_addOnDesc = mo_("\x41\154\x6c\x6f\x77\x73\40\171\x6f\165\162\40\x75\163\x65\162\163\40\x74\x6f\40\x72\145\x73\145\164\x20\x74\150\145\151\162\x20\160\141\x73\x73\x77\157\162\x64\40\x75\x73\151\x6e\x67\40\x4f\124\x50\40\x69\156\163\164\x65\141\x64\40\157\146\x20\x65\155\x61\151\x6c\x20\154\x69\156\x6b\x73\56" . "\103\x6c\151\143\153\40\157\x6e\x20\164\x68\145\x20\x73\x65\164\x74\x69\156\147\x73\x20\142\165\164\164\157\156\40\164\x6f\x20\164\150\x65\x20\x72\x69\x67\150\164\40\164\157\x20\x63\x6f\156\x66\151\x67\x75\162\145\x20\163\145\164\164\151\156\147\x73\40\x66\157\x72\40\164\x68\145\x20\x73\x61\x6d\145\x2e");
    }
    function setAddOnName()
    {
        $this->_addOnName = mo_("\125\x6c\x74\151\x6d\x61\164\x65\x20\x4d\x65\x6d\x62\145\162\x20\120\141\163\x73\x77\x6f\162\x64\40\x52\x65\x73\145\164\40\x4f\x76\145\x72\x20\117\x54\x50");
    }
    function setSettingsUrl()
    {
        $this->_settingsUrl = add_query_arg(array("\x61\144\144\x6f\156" => "\x75\155\x70\162\137\156\x6f\x74\151\146"), $_SERVER["\122\105\x51\125\x45\x53\x54\137\125\122\x49"]);
    }
}
