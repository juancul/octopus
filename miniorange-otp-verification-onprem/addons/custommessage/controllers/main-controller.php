<?php


use OTP\Addons\CustomMessage\Handler\CustomMessages;
$ty = CustomMessages::instance();
$rr = $ty->moAddOnV();
$i4 = !$rr ? "\x64\x69\x73\141\x62\154\145\x64" : '';
$current_user = wp_get_current_user();
$PX = MCM_DIR . "\x63\x6f\156\x74\x72\x6f\x6c\154\145\162\x73\57";
$sX = add_query_arg(array("\160\x61\x67\145" => "\x61\x64\x64\157\156"), remove_query_arg("\141\144\x64\x6f\156", $_SERVER["\122\105\121\125\x45\x53\124\x5f\125\x52\111"]));
if (!isset($_GET["\x61\x64\144\157\x6e"])) {
    goto RS;
}
switch ($_GET["\x61\x64\144\x6f\x6e"]) {
    case "\x63\x75\163\164\x6f\x6d":
        include $PX . "\143\x75\x73\164\157\155\x2e\160\x68\160";
        goto Al;
}
Ky:
Al:
RS:
