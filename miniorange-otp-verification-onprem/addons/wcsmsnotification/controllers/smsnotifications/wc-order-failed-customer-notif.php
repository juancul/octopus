<?php


use OTP\Helper\MoUtility;
$u7 = remove_query_arg(array("\x73\155\163"), $_SERVER["\122\105\121\x55\105\x53\x54\x5f\x55\x52\x49"]);
$rO = $Rg->getWcOrderFailedNotif();
$K2 = $rO->page . "\x5f\145\156\141\x62\x6c\145";
$mN = $rO->page . "\137\x73\x6d\163\x62\x6f\x64\x79";
$KL = $rO->page . "\x5f\x72\x65\x63\151\x70\151\x65\x6e\x74";
$Zh = $rO->page . "\x5f\163\145\x74\164\151\x6e\x67\x73";
if (!MoUtility::areFormOptionsBeingSaved($Zh)) {
    goto DI;
}
$gu = array_key_exists($K2, $_POST) ? TRUE : FALSE;
$KL = serialize(explode("\x3b", $_POST[$KL]));
$Uw = MoUtility::isBlank($_POST[$mN]) ? $rO->defaultSmsBody : $_POST[$mN];
$Rg->getWcOrderFailedNotif()->setIsEnabled($gu);
$Rg->getWcOrderFailedNotif()->setRecipient($KL);
$Rg->getWcOrderFailedNotif()->setSmsBody($Uw);
update_wc_option("\x6e\x6f\164\x69\146\x69\143\141\164\x69\157\x6e\137\163\x65\x74\x74\151\x6e\x67\163", $Rg);
$rO = $Rg->getWcOrderFailedNotif();
DI:
$b9 = $rO->recipient;
$j7 = $rO->isEnabled ? "\143\x68\x65\x63\x6b\x65\x64" : '';
include MSN_DIR . "\x2f\166\x69\x65\x77\x73\x2f\163\x6d\x73\x6e\x6f\164\x69\x66\x69\x63\x61\x74\x69\157\x6e\163\x2f\x77\x63\x2d\x63\x75\163\164\x6f\155\145\x72\x2d\x73\155\x73\55\164\x65\x6d\x70\154\141\164\x65\56\160\x68\x70";
