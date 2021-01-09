<?php


use OTP\Addons\PasswordReset\Handler\UMPasswordResetAddOnHandler;
$ty = UMPasswordResetAddOnHandler::instance();
$OF = $ty->moAddOnV();
$i4 = !$OF ? "\x64\x69\163\141\x62\x6c\x65\144" : '';
$current_user = wp_get_current_user();
$PX = UMPR_DIR . "\x63\x6f\156\164\x72\157\x6c\154\x65\162\x73\57";
$sX = add_query_arg(array("\160\x61\x67\x65" => "\141\144\144\x6f\156"), remove_query_arg("\x61\x64\144\x6f\x6e", $_SERVER["\x52\105\121\125\x45\123\124\137\125\x52\x49"]));
if (!isset($_GET["\141\x64\x64\x6f\x6e"])) {
    goto xT;
}
switch ($_GET["\x61\144\144\157\156"]) {
    case "\x75\155\160\x72\x5f\x6e\x6f\x74\x69\146":
        include $PX . "\125\115\x50\141\x73\x73\167\x6f\x72\x64\122\x65\163\x65\164\56\x70\x68\x70";
        goto vd;
}
v0:
vd:
xT:
