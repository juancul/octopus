<?php


use OTP\Helper\MoUtility;
$u7 = remove_query_arg(array("\x73\155\163"), $_SERVER["\x52\x45\x51\x55\x45\x53\124\137\125\122\x49"]);
$rO = $Rg->getUmNewUserAdminNotif();
$K2 = $rO->page . "\137\x65\156\141\x62\x6c\145";
$mN = $rO->page . "\137\x73\x6d\x73\142\x6f\144\171";
$KL = $rO->page . "\137\x72\x65\143\x69\x70\151\145\x6e\x74";
$Zh = $rO->page . "\x5f\x73\145\164\x74\x69\156\x67\x73";
if (!MoUtility::areFormOptionsBeingSaved($Zh)) {
    goto Ti;
}
$gu = array_key_exists($K2, $_POST) ? TRUE : FALSE;
$b9 = serialize(explode("\x3b", $_POST[$KL]));
$Uw = MoUtility::isBlank($_POST[$mN]) ? $rO->defaultSmsBody : $_POST[$mN];
$Rg->getUmNewUserAdminNotif()->setIsEnabled($gu);
$Rg->getUmNewUserAdminNotif()->setRecipient($b9);
$Rg->getUmNewUserAdminNotif()->setSmsBody($Uw);
update_umsn_option("\x6e\x6f\164\x69\146\x69\x63\141\164\x69\x6f\156\x5f\x73\x65\164\164\151\156\x67\163", $Rg);
$rO = $Rg->getUmNewUserAdminNotif();
Ti:
$b9 = maybe_unserialize($rO->recipient);
$b9 = is_array($b9) ? implode("\73", $b9) : $b9;
$j7 = $rO->isEnabled ? "\143\x68\145\x63\x6b\x65\x64" : '';
include UMSN_DIR . "\x2f\x76\151\145\x77\x73\x2f\x73\x6d\x73\156\x6f\x74\151\x66\x69\143\x61\x74\151\157\156\x73\57\x75\155\x2d\141\144\155\151\x6e\55\163\155\x73\x2d\x74\145\155\160\x6c\141\x74\145\x2e\160\150\160";
