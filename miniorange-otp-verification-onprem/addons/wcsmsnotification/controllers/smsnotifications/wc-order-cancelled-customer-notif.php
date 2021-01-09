<?php


use OTP\Helper\MoUtility;
$u7 = remove_query_arg(array("\163\155\x73"), $_SERVER["\x52\x45\121\x55\x45\123\x54\x5f\125\122\111"]);
$rO = $Rg->getWcOrderCancelledNotif();
$K2 = $rO->page . "\137\145\x6e\141\142\x6c\x65";
$mN = $rO->page . "\137\x73\x6d\163\142\157\144\171";
$KL = $rO->page . "\x5f\162\x65\x63\151\160\x69\145\156\164";
$Zh = $rO->page . "\137\163\145\164\x74\151\x6e\x67\163";
if (!MoUtility::areFormOptionsBeingSaved($Zh)) {
    goto oU;
}
$gu = array_key_exists($K2, $_POST) ? TRUE : FALSE;
$KL = serialize(explode("\x3b", $_POST[$KL]));
$Uw = MoUtility::isBlank($_POST[$mN]) ? $rO->defaultSmsBody : $_POST[$mN];
$Rg->getWcOrderCancelledNotif()->setIsEnabled($gu);
$Rg->getWcOrderCancelledNotif()->setRecipient($KL);
$Rg->getWcOrderCancelledNotif()->setSmsBody($Uw);
update_wc_option("\x6e\x6f\x74\x69\146\151\x63\141\x74\x69\157\x6e\x5f\163\145\164\x74\151\156\147\163", $Rg);
$rO = $Rg->getWcOrderCancelledNotif();
oU:
$b9 = $rO->recipient;
$j7 = $rO->isEnabled ? "\x63\x68\145\x63\153\x65\x64" : '';
include MSN_DIR . "\57\166\x69\145\x77\x73\x2f\x73\155\x73\156\x6f\x74\x69\x66\x69\143\x61\164\151\157\156\163\57\167\143\x2d\143\x75\x73\164\x6f\155\x65\162\x2d\163\155\x73\55\164\x65\155\x70\x6c\x61\x74\x65\56\x70\x68\x70";
