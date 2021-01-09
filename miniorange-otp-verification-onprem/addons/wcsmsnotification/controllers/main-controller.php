<?php


use OTP\Addons\WcSMSNotification\Handler\WooCommerceNotifications;
$rr = WooCommerceNotifications::instance()->moAddOnV();
$i4 = !$rr ? "\144\x69\x73\x61\x62\154\x65\x64" : '';
$current_user = wp_get_current_user();
$PX = MSN_DIR . "\x63\157\x6e\164\x72\x6f\x6c\x6c\x65\x72\x73\57";
$sX = add_query_arg(array("\x70\x61\x67\x65" => "\141\144\x64\157\x6e"), remove_query_arg("\141\144\x64\157\156", $_SERVER["\x52\x45\121\125\105\123\x54\x5f\125\x52\x49"]));
if (!isset($_GET["\x61\x64\x64\x6f\x6e"])) {
    goto IK;
}
switch ($_GET["\x61\x64\x64\157\156"]) {
    case "\167\x6f\x6f\143\157\x6d\155\x65\x72\x63\x65\x5f\x6e\x6f\164\x69\146":
        include $PX . "\167\x63\55\x73\155\x73\55\x6e\x6f\164\x69\x66\x69\x63\x61\164\151\157\x6e\x2e\x70\x68\x70";
        goto vp;
}
Fb:
vp:
IK:
