<?php


use OTP\Helper\MoUtility;
$u7 = remove_query_arg(array("\x73\155\163"), $_SERVER["\122\105\121\x55\x45\123\x54\x5f\125\122\x49"]);
$rO = $Rg->getUmNewCustomerNotif();
$K2 = $rO->page . "\x5f\145\156\141\142\x6c\x65";
$mN = $rO->page . "\x5f\x73\155\163\x62\x6f\144\171";
$KL = $rO->page . "\x5f\162\x65\143\151\x70\x69\x65\156\164";
$Zh = $rO->page . "\137\163\x65\x74\164\151\x6e\147\163";
if (!MoUtility::areFormOptionsBeingSaved($Zh)) {
    goto LW;
}
$gu = array_key_exists($K2, $_POST) ? TRUE : FALSE;
$b9 = $_POST[$KL];
$Uw = MoUtility::isBlank($_POST[$mN]) ? $rO->defaultSmsBody : $_POST[$mN];
$Rg->getUmNewCustomerNotif()->setIsEnabled($gu);
$Rg->getUmNewCustomerNotif()->setRecipient($b9);
$Rg->getUmNewCustomerNotif()->setSmsBody($Uw);
update_umsn_option("\x6e\x6f\x74\x69\x66\x69\x63\141\x74\151\157\x6e\x5f\x73\145\x74\x74\x69\x6e\x67\x73", $Rg);
$rO = $Rg->getUmNewCustomerNotif();
LW:
$b9 = maybe_unserialize($rO->recipient);
$b9 = MoUtility::isBlank($b9) ? "\x6d\x6f\x62\x69\x6c\x65\137\x6e\x75\155\142\x65\162" : $b9;
$j7 = $rO->isEnabled ? "\x63\150\145\x63\x6b\145\144" : '';
include UMSN_DIR . "\x2f\166\x69\145\x77\163\x2f\163\x6d\163\x6e\x6f\x74\151\146\x69\x63\x61\x74\x69\157\x6e\x73\57\165\155\x2d\143\165\163\164\157\155\145\x72\55\x73\155\x73\55\164\x65\x6d\160\x6c\x61\x74\x65\x2e\x70\x68\160";
