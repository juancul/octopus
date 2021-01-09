<?php


use OTP\Helper\MoUtility;
$u7 = remove_query_arg(array("\163\155\x73"), $_SERVER["\x52\x45\121\125\x45\123\124\137\x55\x52\x49"]);
$rO = $Rg->getWcOrderPendingNotif();
$K2 = $rO->page . "\x5f\x65\156\x61\142\x6c\x65";
$mN = $rO->page . "\137\x73\155\x73\142\x6f\144\x79";
$KL = $rO->page . "\137\x72\x65\143\151\160\151\145\x6e\x74";
$Zh = $rO->page . "\x5f\x73\x65\x74\164\x69\156\147\x73";
if (!MoUtility::areFormOptionsBeingSaved($Zh)) {
    goto MB;
}
$gu = array_key_exists($K2, $_POST) ? TRUE : FALSE;
$KL = serialize(explode("\x3b", $_POST[$KL]));
$Uw = MoUtility::isBlank($_POST[$mN]) ? $rO->defaultSmsBody : $_POST[$mN];
$Rg->getWcOrderPendingNotif()->setIsEnabled($gu);
$Rg->getWcOrderPendingNotif()->setRecipient($KL);
$Rg->getWcOrderPendingNotif()->setSmsBody($Uw);
update_wc_option("\x6e\x6f\x74\x69\x66\151\x63\x61\164\151\157\156\x5f\x73\x65\x74\164\151\156\147\x73", $Rg);
$rO = $Rg->getWcOrderPendingNotif();
MB:
$b9 = $rO->recipient;
$j7 = $rO->isEnabled ? "\x63\150\145\x63\153\x65\x64" : '';
include MSN_DIR . "\x2f\166\151\145\x77\163\x2f\x73\x6d\163\x6e\157\164\151\146\151\143\x61\x74\x69\x6f\x6e\163\x2f\x77\x63\55\x63\165\x73\164\x6f\x6d\x65\x72\55\163\155\x73\x2d\164\x65\155\160\154\x61\x74\x65\x2e\x70\150\160";
