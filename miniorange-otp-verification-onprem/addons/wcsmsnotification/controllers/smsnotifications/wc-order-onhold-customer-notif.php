<?php


use OTP\Helper\MoUtility;
$u7 = remove_query_arg(array("\163\155\163"), $_SERVER["\122\105\121\x55\x45\x53\124\137\125\122\111"]);
$rO = $Rg->getWcOrderOnHoldNotif();
$K2 = $rO->page . "\137\145\156\141\142\x6c\x65";
$mN = $rO->page . "\137\163\155\163\142\157\144\x79";
$KL = $rO->page . "\x5f\162\145\143\151\x70\x69\145\156\x74";
$Zh = $rO->page . "\x5f\163\x65\164\x74\151\156\x67\163";
if (!MoUtility::areFormOptionsBeingSaved($Zh)) {
    goto M6;
}
$gu = array_key_exists($K2, $_POST) ? TRUE : FALSE;
$KL = serialize(explode("\x3b", $_POST[$KL]));
$Uw = MoUtility::isBlank($_POST[$mN]) ? $rO->defaultSmsBody : $_POST[$mN];
$Rg->getWcOrderOnHoldNotif()->setIsEnabled($gu);
$Rg->getWcOrderOnHoldNotif()->setRecipient($KL);
$Rg->getWcOrderOnHoldNotif()->setSmsBody($Uw);
update_wc_option("\x6e\157\164\151\x66\151\x63\x61\x74\x69\x6f\156\x5f\x73\145\164\x74\x69\156\147\x73", $Rg);
$rO = $Rg->getWcOrderOnHoldNotif();
M6:
$b9 = $rO->recipient;
$j7 = $rO->isEnabled ? "\143\x68\145\143\153\145\144" : '';
include MSN_DIR . "\57\x76\151\145\x77\x73\57\x73\155\163\x6e\x6f\x74\x69\146\x69\143\141\164\151\x6f\x6e\163\x2f\167\x63\55\x63\165\x73\x74\157\155\145\x72\x2d\163\x6d\163\55\x74\145\155\160\154\141\164\145\56\160\150\160";
