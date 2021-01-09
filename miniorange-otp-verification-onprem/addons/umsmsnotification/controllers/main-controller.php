<?php


use OTP\Addons\UmSMSNotification\Handler\UltimateMemberSMSNotificationsHandler;
$ty = UltimateMemberSMSNotificationsHandler::instance();
$rr = $ty->moAddOnV();
$i4 = !$rr ? "\x64\151\x73\x61\x62\154\x65\144" : '';
$current_user = wp_get_current_user();
$PX = UMSN_DIR . "\x63\x6f\156\164\162\x6f\x6c\x6c\145\162\x73\x2f";
$sX = add_query_arg(array("\x70\141\147\x65" => "\x61\x64\x64\x6f\x6e"), remove_query_arg("\141\144\144\x6f\x6e", $_SERVER["\x52\105\x51\x55\x45\x53\x54\x5f\125\122\x49"]));
if (!isset($_GET["\x61\x64\144\x6f\156"])) {
    goto qo;
}
switch ($_GET["\141\144\144\x6f\x6e"]) {
    case "\x75\x6d\x5f\156\x6f\x74\x69\146":
        include $PX . "\x75\x6d\55\163\x6d\163\55\156\157\164\x69\146\x69\x63\141\x74\x69\157\x6e\56\160\x68\x70";
        goto sv;
}
Tv:
sv:
qo:
