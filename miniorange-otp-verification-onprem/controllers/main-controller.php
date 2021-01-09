<?php


use OTP\Handler\MoOTPActionHandlerHandler;
use OTP\Helper\MoUtility;
use OTP\Objects\PluginPageDetails;
use OTP\Objects\TabDetails;
$OF = MoUtility::micr();
$IW = MoUtility::mclv();
$ml = MoUtility::micv();
$i4 = $OF && $IW ? '' : "\144\x69\163\x61\142\154\x65\x64";
$current_user = wp_get_current_user();
$Vy = get_mo_option("\141\x64\155\151\156\x5f\145\x6d\141\x69\x6c");
$l1 = get_mo_option("\x61\x64\155\151\156\x5f\x70\x68\157\x6e\145");
$PX = MOV_DIR . "\x63\x6f\156\x74\x72\157\x6c\154\145\162\163\x2f";
$yJ = MoOTPActionHandlerHandler::instance();
$l4 = TabDetails::instance();
include $PX . "\x6e\141\x76\x62\x61\x72\x2e\x70\x68\160";
echo "\x3c\x64\151\166\40\143\154\141\163\x73\75\x27\x6d\x6f\55\x6f\x70\164\55\143\x6f\156\x74\145\156\164\x27\76\12\40\40\x20\40\40\40\x20\x20\74\x64\x69\x76\40\151\144\x3d\x27\x6d\157\x62\x6c\157\143\x6b\47\40\x63\x6c\x61\163\x73\75\x27\155\x6f\x5f\x63\165\x73\x74\157\155\x65\162\x5f\166\141\x6c\151\144\x61\164\x69\x6f\156\x2d\155\x6f\144\x61\154\55\x62\x61\143\x6b\144\162\157\160\x20\x64\141\x73\x68\142\x6f\141\x72\x64\x27\76" . "\x3c\151\x6d\x67\40\163\x72\x63\75\x27" . MOV_LOADER_URL . "\47\x3e" . "\x3c\57\144\x69\166\x3e";
if (!isset($_GET["\160\x61\x67\x65"])) {
    goto jE;
}
foreach ($l4->_tabDetails as $ej) {
    if (!($ej->_menuSlug == $_GET["\x70\x61\147\x65"])) {
        goto te;
    }
    include $PX . $ej->_view;
    te:
    o7:
}
G3:
do_action("\x6d\x6f\137\157\x74\x70\x5f\166\x65\x72\151\x66\151\x63\x61\164\151\x6f\x6e\x5f\x61\x64\x64\137\157\156\137\143\x6f\x6e\164\162\x6f\154\x6c\145\x72");
include $PX . "\163\165\x70\x70\157\162\164\56\x70\x68\160";
jE:
echo "\x3c\57\x64\x69\166\76";
echo "\x20\40\40\74\x64\151\166\40\143\x6c\x61\163\163\x3d\x22\155\x6f\x5f\x6f\164\160\137\x66\x6f\x6f\164\145\x72\x22\x3e\40\12\40\x20\x3c\x64\151\x76\x20\143\x6c\x61\163\163\75\x22\x6d\x6f\55\157\164\160\x2d\x6d\x61\151\x6c\55\x62\x75\x74\x74\157\156\42\76\12\x20\x20\x3c\151\x6d\147\40\163\x72\143\x3d\42" . MOV_MAIL_LOGO . "\x22\x20\x63\154\141\x73\x73\x3d\x22\163\150\x6f\x77\137\163\165\160\160\x6f\162\164\137\146\x6f\162\155\x22\x20\x69\x64\x3d\42\x68\145\154\x70\x42\165\x74\x74\157\x6e\x22\x3e\74\57\x64\151\166\x3e\xa\40\40\74\x62\x75\x74\x74\157\156\x20\164\171\160\x65\x3d\42\x62\x75\164\164\157\156\42\x20\143\x6c\141\x73\x73\75\42\x6d\x6f\55\x6f\164\160\x2d\150\x65\x6c\160\55\x62\165\164\x74\x6f\156\x2d\164\x65\x78\164\42\76\110\x65\154\x6c\x6f\x20\164\x68\145\162\145\41\74\142\162\76\116\145\145\144\x20\110\145\154\160\77\40\104\162\x6f\x70\40\165\x73\40\141\x6e\40\105\155\x61\151\x6c\74\x2f\x62\x75\x74\x74\x6f\x6e\x3e\xa\x20\x20\74\x2f\x64\x69\166\76";
