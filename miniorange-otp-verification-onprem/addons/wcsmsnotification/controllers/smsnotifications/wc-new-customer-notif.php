<?php


use OTP\Helper\MoUtility;
$u7 = remove_query_arg(array("\163\x6d\x73"), $_SERVER["\122\105\121\x55\105\x53\124\137\125\x52\111"]);
$rO = $Rg->getWcNewCustomerNotif();
$K2 = $rO->page . "\x5f\x65\x6e\141\142\154\x65";
$mN = $rO->page . "\x5f\x73\x6d\163\x62\x6f\144\x79";
$KL = $rO->page . "\137\162\x65\x63\x69\x70\151\x65\156\164";
$Zh = $rO->page . "\x5f\163\145\164\164\x69\x6e\147\x73";
if (!MoUtility::areFormOptionsBeingSaved($Zh)) {
    goto s_;
}
$gu = array_key_exists($K2, $_POST) ? TRUE : FALSE;
$KL = serialize(explode("\x3b", $_POST[$KL]));
$Uw = MoUtility::isBlank($_POST[$mN]) ? $rO->defaultSmsBody : $_POST[$mN];
$Rg->getWcNewCustomerNotif()->setIsEnabled($gu);
$Rg->getWcNewCustomerNotif()->setRecipient($KL);
$Rg->getWcNewCustomerNotif()->setSmsBody($Uw);
update_wc_option("\x6e\157\164\151\146\x69\143\141\x74\151\157\x6e\x5f\163\145\164\164\151\156\x67\x73", $Rg);
$rO = $Rg->getWcNewCustomerNotif();
s_:
$b9 = $rO->recipient;
$j7 = $rO->isEnabled ? "\x63\x68\145\x63\153\145\144" : '';
include MSN_DIR . "\x2f\x76\x69\145\167\x73\57\163\x6d\163\x6e\157\x74\x69\x66\x69\143\x61\x74\x69\x6f\x6e\x73\x2f\167\143\x2d\143\165\x73\x74\x6f\x6d\145\162\x2d\x73\x6d\x73\55\164\x65\x6d\x70\154\141\x74\x65\x2e\160\150\160";
