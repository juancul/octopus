<?php


use OTP\Addons\WcSMSNotification\Helper\MoWcAddOnMessages;
use OTP\Addons\WcSMSNotification\Helper\WooCommerceNotificationsList;
use OTP\Helper\MoUtility;
$Rg = get_wc_option("\156\x6f\x74\x69\146\151\143\x61\x74\151\157\156\137\163\145\164\x74\x69\156\147\163");
$Rg = $Rg ? maybe_unserialize($Rg) : WooCommerceNotificationsList::instance();
$Uw = '';
if (isset($_GET["\163\155\163"])) {
    goto zs;
}
include MSN_DIR . "\57\x76\151\145\167\x73\x2f\167\143\x2d\x73\x6d\x73\55\x6e\x6f\x74\151\x66\x69\143\x61\x74\x69\x6f\x6e\56\160\150\160";
goto PV;
zs:
$Uw = $_GET["\163\155\163"];
$JZ = $PX . "\57\163\155\163\x6e\x6f\164\x69\x66\151\x63\141\164\151\157\x6e\163\x2f";
switch ($_GET["\x73\155\x73"]) {
    case "\x77\143\x5f\156\145\x77\137\x63\x75\163\x74\x6f\x6d\145\x72\137\x6e\x6f\x74\151\x66":
        include $JZ . "\x77\143\x2d\x6e\145\x77\x2d\143\165\x73\x74\x6f\x6d\x65\162\55\x6e\x6f\x74\151\146\x2e\x70\150\160";
        goto Bm;
    case "\x77\x63\137\143\165\163\164\157\x6d\145\x72\137\156\157\164\x65\137\156\x6f\x74\x69\x66":
        include $JZ . "\x77\143\x2d\x63\165\x73\164\157\x6d\x65\162\55\156\157\164\x65\x2d\x6e\x6f\x74\x69\146\56\x70\x68\160";
        goto Bm;
    case "\x77\x63\x5f\157\x72\144\x65\x72\137\143\141\x6e\143\x65\x6c\x6c\145\x64\x5f\x6e\157\x74\x69\146":
        include $JZ . "\167\143\55\157\x72\144\x65\162\x2d\x63\141\156\x63\x65\x6c\x6c\x65\x64\x2d\x63\x75\x73\164\157\155\x65\x72\x2d\x6e\157\164\x69\x66\56\x70\150\160";
        goto Bm;
    case "\167\143\x5f\x6f\162\x64\145\162\x5f\143\x6f\155\x70\154\145\164\x65\144\137\x6e\157\164\151\x66":
        include $JZ . "\167\143\55\x6f\162\x64\x65\162\x2d\143\157\x6d\x70\154\x65\x74\x65\144\55\143\x75\x73\164\157\x6d\145\x72\x2d\x6e\157\x74\x69\x66\56\x70\x68\160";
        goto Bm;
    case "\167\143\x5f\157\x72\x64\x65\x72\137\146\x61\151\154\x65\144\137\156\157\164\x69\146":
        include $JZ . "\167\143\x2d\x6f\162\144\145\162\x2d\x66\141\x69\x6c\x65\x64\55\143\165\163\164\157\x6d\x65\162\55\156\157\x74\151\146\x2e\x70\x68\x70";
        goto Bm;
    case "\x77\143\137\157\162\x64\145\162\x5f\157\x6e\x5f\x68\157\154\144\137\x6e\x6f\x74\151\146":
        include $JZ . "\167\x63\x2d\157\162\x64\x65\162\x2d\157\x6e\x68\157\154\x64\55\x63\165\163\164\x6f\x6d\x65\x72\x2d\x6e\x6f\164\151\x66\56\160\x68\160";
        goto Bm;
    case "\x77\x63\137\x6f\x72\x64\x65\162\x5f\160\162\157\x63\x65\x73\x73\x69\156\x67\x5f\156\x6f\164\151\146":
        include $JZ . "\167\143\55\x6f\x72\x64\145\162\x2d\160\x72\x6f\x63\x65\163\x73\x69\156\x67\x2d\143\165\163\164\157\155\x65\162\x2d\x6e\157\164\x69\146\56\x70\x68\x70";
        goto Bm;
    case "\167\x63\x5f\x6f\x72\144\x65\x72\137\162\145\146\165\156\x64\x65\144\137\156\x6f\164\x69\x66":
        include $JZ . "\x77\143\55\157\162\x64\145\162\55\162\x65\x66\x75\x6e\144\x65\144\55\x63\165\x73\164\157\155\145\x72\55\x6e\157\x74\x69\146\x2e\160\x68\160";
        goto Bm;
    case "\167\x63\137\141\144\x6d\151\156\137\x6f\162\144\x65\162\x5f\163\x74\x61\x74\165\x73\x5f\x6e\157\164\151\x66":
        include $JZ . "\167\143\55\x6f\x72\x64\x65\162\x2d\163\x74\141\164\x75\163\x2d\x61\x64\155\151\156\55\x6e\157\164\151\x66\56\x70\150\x70";
        goto Bm;
    case "\x77\143\x5f\157\x72\144\145\162\x5f\160\x65\x6e\x64\x69\156\147\x5f\156\157\x74\x69\x66":
        include $JZ . "\167\143\x2d\157\x72\144\145\x72\x2d\x70\145\156\144\x69\156\x67\55\x63\x75\163\164\x6f\x6d\145\162\55\156\x6f\164\151\146\x2e\160\150\x70";
        goto Bm;
}
j8:
Bm:
PV:
function show_notifications_table(WooCommerceNotificationsList $JN)
{
    foreach ($JN as $X_ => $Wy) {
        $u1 = add_query_arg(array("\163\x6d\x73" => $Wy->page), $_SERVER["\x52\x45\x51\x55\105\123\x54\137\125\x52\x49"]);
        echo "\11\74\x74\162\76\15\xa\40\40\40\x20\40\40\x20\x20\x20\x20\x20\40\40\40\40\x20\40\x20\x20\40\x3c\x74\144\x20\x63\x6c\x61\163\163\75\42\155\163\156\55\x74\141\x62\154\x65\x2d\x6c\151\163\164\x2d\163\x74\x61\x74\165\163\x22\x3e\xd\12\x20\40\x20\40\40\40\x20\40\x20\x20\40\40\x20\40\40\40\40\x20\x20\x20\x20\40\40\40\74\x73\x70\x61\x6e\x20\143\x6c\141\163\163\x3d\42" . ($Wy->isEnabled ? "\x73\164\141\x74\x75\x73\x2d\x65\156\141\x62\x6c\x65\x64" : '') . "\x22\x3e\74\x2f\x73\x70\x61\x6e\x3e\15\12\x20\40\40\40\40\40\40\x20\x20\x20\x20\x20\40\x20\40\40\x20\x20\40\40\x3c\x2f\164\144\76\xd\xa\40\x20\40\40\x20\40\40\x20\x20\x20\x20\x20\x20\x20\40\x20\x20\40\x20\40\x3c\x74\x64\x20\x63\154\x61\163\163\x3d\42\155\163\156\55\164\141\142\154\x65\x2d\x6c\x69\163\x74\55\x6e\x61\155\145\x22\76\xd\12\x20\40\x20\40\40\x20\x20\40\x20\x20\x20\40\40\40\40\40\x20\40\x20\40\x20\40\40\x20\74\x61\x20\x68\162\145\146\x3d\42" . $u1 . "\x22\76" . $Wy->title . "\74\x2f\x61\76";
        mo_draw_tooltip(MoWcAddOnMessages::showMessage($Wy->tooltipHeader), MoWcAddOnMessages::showMessage($Wy->tooltipBody));
        echo "\x9\x9\74\x2f\164\x64\x3e\xd\xa\40\40\x20\40\40\x20\40\40\x20\x20\x20\40\40\40\x20\40\x20\40\x20\x20\74\164\x64\40\x63\x6c\141\163\163\x3d\42\x6d\x73\156\55\164\141\142\x6c\x65\x2d\x6c\x69\x73\x74\x2d\x72\x65\x63\151\x70\151\145\156\164\42\x20\x73\164\x79\154\x65\x3d\42\x77\157\x72\x64\x2d\x77\x72\x61\x70\72\x20\x62\x72\x65\141\153\x2d\167\x6f\x72\144\x3b\42\76\xd\xa\40\x20\40\x20\40\40\x20\x20\x20\40\40\40\40\40\x20\40\x20\40\x20\40\x20\x20\40\40" . $Wy->notificationType . "\xd\xa\x20\x20\40\40\40\40\x20\40\40\x20\x20\40\x20\x20\40\x20\40\40\x20\x20\x3c\x2f\x74\144\76\xd\xa\x20\x20\40\x20\40\x20\x20\40\x20\x20\40\x20\40\40\x20\40\x20\40\40\x20\x3c\x74\144\40\x63\154\141\163\x73\x3d\42\155\x73\156\55\x74\141\142\x6c\x65\x2d\154\x69\163\x74\55\x73\x74\x61\164\165\163\55\141\143\x74\151\x6f\x6e\x73\42\76\xd\12\x20\x20\40\40\x20\x20\40\40\40\40\40\x20\x20\x20\x20\40\x20\40\x20\40\40\40\40\x20\x3c\x61\x20\x63\154\x61\163\163\x3d\x22\x62\165\164\x74\157\156\40\x61\x6c\151\x67\x6e\x72\151\147\x68\164\40\x74\151\x70\163\x22\x20\150\162\x65\x66\75\42" . $u1 . "\x22\76\103\157\156\146\151\147\165\x72\x65\74\x2f\x61\x3e\15\xa\x20\40\40\x20\40\x20\40\x20\x20\40\x20\40\x20\40\x20\40\x20\x20\x20\x20\x3c\x2f\164\144\x3e\xd\xa\40\40\x20\40\x20\x20\x20\40\40\x20\x20\40\40\x20\x20\x20\x3c\x2f\x74\162\x3e";
        jc:
    }
    Gm:
}