<?php


use OTP\Helper\MoUtility;
$u7 = remove_query_arg(array("\x73\x6d\163"), $_SERVER["\x52\x45\x51\125\105\x53\124\x5f\x55\x52\111"]);
$rO = $Rg->getWcOrderProcessingNotif();
$K2 = $rO->page . "\x5f\x65\x6e\141\142\x6c\145";
$mN = $rO->page . "\137\163\x6d\163\x62\157\x64\x79";
$KL = $rO->page . "\137\162\145\143\x69\160\151\145\x6e\164";
$Zh = $rO->page . "\137\163\145\x74\164\x69\156\147\x73";
if (!MoUtility::areFormOptionsBeingSaved($Zh)) {
    goto tr;
}
$gu = array_key_exists($K2, $_POST) ? TRUE : FALSE;
$KL = serialize(explode("\x3b", $_POST[$KL]));
$Uw = MoUtility::isBlank($_POST[$mN]) ? $rO->defaultSmsBody : $_POST[$mN];
$Rg->getWcOrderProcessingNotif()->setIsEnabled($gu);
$Rg->getWcOrderProcessingNotif()->setRecipient($KL);
$Rg->getWcOrderProcessingNotif()->setSmsBody($Uw);
update_wc_option("\x6e\157\164\151\146\x69\143\x61\x74\151\157\x6e\137\163\x65\164\x74\151\156\x67\163", $Rg);
$rO = $Rg->getWcOrderProcessingNotif();
tr:
$b9 = $rO->recipient;
$j7 = $rO->isEnabled ? "\143\x68\145\x63\153\145\144" : '';
include MSN_DIR . "\57\166\x69\145\x77\x73\57\x73\x6d\x73\156\x6f\x74\151\x66\x69\143\141\164\x69\157\x6e\163\x2f\167\x63\x2d\x63\x75\x73\x74\x6f\155\145\162\x2d\x73\155\163\x2d\164\x65\x6d\160\154\141\164\145\56\160\150\x70";
