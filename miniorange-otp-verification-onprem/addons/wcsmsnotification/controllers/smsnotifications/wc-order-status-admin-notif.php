<?php


use OTP\Helper\MoUtility;
$u7 = remove_query_arg(array("\x73\155\163"), $_SERVER["\x52\x45\x51\125\x45\123\124\x5f\125\122\111"]);
$rO = $Rg->getWcAdminOrderStatusNotif();
$K2 = $rO->page . "\x5f\x65\156\x61\x62\x6c\145";
$mN = $rO->page . "\137\163\155\x73\x62\x6f\x64\171";
$KL = $rO->page . "\x5f\162\145\143\x69\x70\151\x65\x6e\x74";
$Zh = $rO->page . "\x5f\163\x65\164\164\151\156\147\x73";
if (!MoUtility::areFormOptionsBeingSaved($Zh)) {
    goto BU;
}
$gu = array_key_exists($K2, $_POST) ? TRUE : FALSE;
$KL = serialize(explode("\x3b", $_POST[$KL]));
$Uw = MoUtility::isBlank($_POST[$mN]) ? $rO->defaultSmsBody : $_POST[$mN];
$Rg->getWcAdminOrderStatusNotif()->setIsEnabled($gu);
$Rg->getWcAdminOrderStatusNotif()->setRecipient($KL);
$Rg->getWcAdminOrderStatusNotif()->setSmsBody($Uw);
update_wc_option("\x6e\x6f\164\x69\146\x69\143\141\164\151\x6f\x6e\137\163\145\x74\x74\x69\156\147\163", $Rg);
$rO = $Rg->getWcAdminOrderStatusNotif();
BU:
$b9 = maybe_unserialize($rO->recipient);
$b9 = is_array($b9) ? implode("\73", $b9) : $b9;
$j7 = $rO->isEnabled ? "\x63\150\x65\143\153\x65\x64" : '';
include MSN_DIR . "\57\166\151\145\167\163\x2f\x73\x6d\x73\156\x6f\x74\x69\x66\x69\x63\x61\164\151\x6f\156\x73\57\167\143\x2d\141\x64\x6d\x69\156\55\163\155\163\55\x74\145\155\160\x6c\141\x74\x65\x2e\160\x68\x70";
