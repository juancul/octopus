<?php


use OTP\Helper\MoUtility;
$u7 = remove_query_arg(array("\x73\155\163"), $_SERVER["\122\105\x51\125\x45\123\124\x5f\125\122\111"]);
$rO = $Rg->getWcCustomerNoteNotif();
$K2 = $rO->page . "\137\145\156\141\142\154\145";
$mN = $rO->page . "\x5f\x73\155\x73\x62\x6f\144\171";
$KL = $rO->page . "\137\x72\145\x63\x69\x70\x69\145\x6e\x74";
$Zh = $rO->page . "\x5f\163\145\164\x74\151\x6e\147\163";
if (!MoUtility::areFormOptionsBeingSaved($Zh)) {
    goto lh;
}
$gu = array_key_exists($K2, $_POST) ? TRUE : FALSE;
$KL = serialize(explode("\x3b", $_POST[$KL]));
$Uw = MoUtility::isBlank($_POST[$mN]) ? $rO->defaultSmsBody : $_POST[$mN];
$Rg->getWcCustomerNoteNotif()->setIsEnabled($gu);
$Rg->getWcCustomerNoteNotif()->setRecipient($KL);
$Rg->getWcCustomerNoteNotif()->setSmsBody($Uw);
update_wc_option("\156\157\x74\151\x66\151\143\141\164\x69\x6f\x6e\137\163\x65\x74\x74\151\156\x67\x73", $Rg);
$rO = $Rg->getWcCustomerNoteNotif();
lh:
$b9 = $rO->recipient;
$j7 = $rO->isEnabled ? "\143\150\145\x63\x6b\x65\144" : '';
include MSN_DIR . "\57\x76\151\145\x77\x73\57\163\155\x73\x6e\x6f\164\151\146\x69\x63\x61\x74\x69\x6f\x6e\163\x2f\167\143\x2d\x63\165\x73\164\157\x6d\x65\162\55\x73\x6d\x73\55\x74\x65\155\160\x6c\x61\164\145\56\x70\x68\x70";
