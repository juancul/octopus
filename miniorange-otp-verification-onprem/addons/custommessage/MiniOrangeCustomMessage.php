<?php


namespace OTP\Addons\CustomMessage;

use OTP\Addons\CustomMessage\Handler\CustomMessages;
use OTP\Addons\CustomMessage\Handler\CustomMessagesShortcode;
use OTP\Helper\AddOnList;
use OTP\Objects\AddOnInterface;
use OTP\Objects\BaseAddOn;
use OTP\Traits\Instance;
if (defined("\x41\x42\123\120\x41\124\110")) {
    goto e7;
}
die;
e7:
include "\x5f\141\165\x74\157\x6c\157\x61\144\56\160\x68\x70";
class MiniOrangeCustomMessage extends BaseAddOn implements AddOnInterface
{
    use Instance;
    function initializeHandlers()
    {
        $WR = AddOnList::instance();
        $ty = CustomMessages::instance();
        $WR->add($ty->getAddOnKey(), $ty);
    }
    function initializeHelpers()
    {
        CustomMessagesShortcode::instance();
    }
    function show_addon_settings_page()
    {
        include MCM_DIR . "\143\157\156\x74\x72\157\x6c\x6c\x65\162\x73\57\x6d\x61\x69\x6e\x2d\x63\x6f\x6e\x74\x72\x6f\x6c\154\145\162\x2e\x70\150\160";
    }
}
