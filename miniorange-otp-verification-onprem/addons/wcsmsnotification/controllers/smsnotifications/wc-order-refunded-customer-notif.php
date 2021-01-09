<?php


use OTP\Helper\MoUtility;
$u7 = remove_query_arg(array("\x73\x6d\x73"), $_SERVER["\122\105\x51\x55\x45\x53\124\137\x55\x52\111"]);
$rO = $Rg->getWcOrderRefundedNotif();
$K2 = $rO->page . "\137\x65\x6e\141\x62\x6c\145";
$mN = $rO->page . "\137\163\155\x73\x62\x6f\x64\x79";
$KL = $rO->page . "\x5f\162\x65\x63\x69\x70\151\145\x6e\x74";
$Zh = $rO->page . "\137\x73\145\x74\164\151\x6e\x67\163";
if (!MoUtility::areFormOptionsBeingSaved($Zh)) {
    goto YK;
}
$gu = array_key_exists($K2, $_POST) ? TRUE : FALSE;
$KL = serialize(explode("\73", $_POST[$KL]));
$Uw = MoUtility::isBlank($_POST[$mN]) ? $rO->defaultSmsBody : $_POST[$mN];
$Rg->getWcOrderRefundedNotif()->setIsEnabled($gu);
$Rg->getWcOrderRefundedNotif()->setRecipient($KL);
$Rg->getWcOrderRefundedNotif()->setSmsBody($Uw);
update_wc_option("\x6e\x6f\x74\x69\146\151\x63\x61\x74\x69\157\x6e\137\x73\x65\x74\x74\151\x6e\x67\163", $Rg);
$rO = $Rg->getWcOrderRefundedNotif();
YK:
$b9 = $rO->recipient;
$j7 = $rO->isEnabled ? "\143\x68\x65\143\x6b\145\x64" : '';
include MSN_DIR . "\57\x76\151\145\167\x73\x2f\x73\x6d\x73\x6e\157\164\x69\146\x69\143\141\164\151\157\156\x73\57\167\143\x2d\143\165\x73\x74\x6f\155\x65\x72\x2d\x73\x6d\x73\x2d\164\x65\x6d\x70\x6c\x61\164\x65\x2e\160\x68\160";
