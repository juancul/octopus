<?php


use OTP\Helper\MoUtility;
$u7 = remove_query_arg(array("\163\x6d\163"), $_SERVER["\x52\105\121\x55\105\x53\x54\x5f\125\122\111"]);
$rO = $Rg->getWcOrderCompletedNotif();
$K2 = $rO->page . "\x5f\145\x6e\x61\x62\154\x65";
$mN = $rO->page . "\x5f\163\155\163\142\x6f\144\171";
$KL = $rO->page . "\x5f\x72\x65\x63\151\x70\151\145\x6e\x74";
$Zh = $rO->page . "\x5f\163\145\x74\164\x69\156\x67\163";
if (!MoUtility::areFormOptionsBeingSaved($Zh)) {
    goto sa;
}
$gu = array_key_exists($K2, $_POST) ? TRUE : FALSE;
$KL = serialize(explode("\73", $_POST[$KL]));
$Uw = MoUtility::isBlank($_POST[$mN]) ? $rO->defaultSmsBody : $_POST[$mN];
$Rg->getWcOrderCompletedNotif()->setIsEnabled($gu);
$Rg->getWcOrderCompletedNotif()->setRecipient($KL);
$Rg->getWcOrderCompletedNotif()->setSmsBody($Uw);
update_wc_option("\x6e\x6f\164\151\146\x69\x63\x61\x74\x69\x6f\x6e\x5f\163\145\x74\164\x69\x6e\147\x73", $Rg);
$rO = $Rg->getWcOrderCompletedNotif();
sa:
$b9 = $rO->recipient;
$j7 = $rO->isEnabled ? "\x63\150\x65\x63\x6b\145\x64" : '';
include MSN_DIR . "\57\x76\x69\145\167\x73\x2f\x73\x6d\x73\156\157\164\x69\146\151\143\x61\x74\x69\x6f\156\x73\57\x77\x63\55\143\165\163\164\157\x6d\x65\x72\x2d\x73\x6d\163\55\164\145\155\160\x6c\141\164\x65\56\x70\x68\160";
