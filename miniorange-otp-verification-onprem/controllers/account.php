<?php


use OTP\Handler\MoRegistrationHandler;
use OTP\Helper\MoConstants;
use OTP\Helper\MoUtility;
$u1 = MoConstants::HOSTNAME . "\x2f\x6d\157\x61\x73\x2f\x6c\157\147\151\x6e" . "\x3f\x72\x65\144\151\x72\x65\143\164\x55\162\154\75" . MoConstants::HOSTNAME . "\57\x6d\x6f\x61\163\57\166\x69\x65\x77\154\151\143\145\x6e\163\145\153\x65\171\x73";
$ty = MoRegistrationHandler::instance();
if (get_mo_option("\x72\x65\x67\x69\x73\164\162\x61\x74\x69\157\156\137\x73\x74\x61\164\165\163") === "\x4d\x4f\137\117\x54\120\x5f\104\x45\x4c\x49\126\105\x52\x45\104\x5f\x53\125\103\103\x45\123\123" || get_mo_option("\x72\145\x67\151\x73\x74\x72\141\x74\151\x6f\x6e\x5f\163\164\x61\x74\165\163") === "\x4d\x4f\x5f\117\x54\120\x5f\x56\x41\114\x49\104\101\x54\x49\x4f\116\x5f\106\101\111\x4c\125\122\105" || get_mo_option("\162\x65\x67\x69\x73\x74\x72\x61\x74\x69\157\x6e\137\163\x74\x61\164\x75\163") === "\x4d\x4f\137\117\124\x50\137\104\105\x4c\x49\x56\105\122\105\x44\137\x46\101\x49\114\125\x52\105") {
    goto eZ;
}
if (get_mo_option("\166\x65\x72\151\146\x79\137\x63\165\163\164\x6f\155\145\x72")) {
    goto t4;
}
if (!MoUtility::micr()) {
    goto pk;
}
if (MoUtility::micr() && !MoUtility::mclv()) {
    goto Cf;
}
$Op = get_mo_option("\x61\144\155\151\156\x5f\143\x75\163\x74\157\155\145\162\x5f\x6b\x65\171");
$lQ = get_mo_option("\x61\144\155\x69\156\x5f\x61\160\x69\137\153\145\x79");
$P6 = get_mo_option("\x63\x75\x73\x74\157\x6d\x65\162\x5f\164\x6f\153\145\x6e");
$Ng = MoUtility::mclv() && !MoUtility::isMG();
$jG = $yJ->getNonceValue();
$jP = $ty->getNonceValue();
include MOV_DIR . "\166\151\145\x77\x73\57\141\x63\x63\x6f\x75\156\164\57\x70\162\x6f\x66\x69\x6c\x65\x2e\x70\150\160";
goto G9;
Cf:
$jG = $ty->getNonceValue();
include MOV_DIR . "\166\151\x65\x77\163\x2f\x61\x63\x63\157\x75\x6e\164\57\x76\x65\162\151\146\171\x2d\x6c\153\56\x70\150\160";
G9:
goto YE;
pk:
$current_user = wp_get_current_user();
$S3 = get_mo_option("\x61\144\x6d\151\156\x5f\160\150\x6f\x6e\145") ? get_mo_option("\141\x64\155\151\156\x5f\x70\x68\157\x6e\145") : '';
$jG = $ty->getNonceValue();
delete_site_option("\x70\x61\163\x73\167\x6f\162\144\x5f\155\151\x73\155\141\x74\143\x68");
update_mo_option("\156\x65\167\x5f\x72\x65\147\x69\x73\x74\162\x61\x74\x69\x6f\156", "\x74\162\165\x65");
include MOV_DIR . "\x76\x69\x65\x77\x73\x2f\141\x63\143\x6f\x75\x6e\x74\x2f\x72\x65\x67\x69\163\x74\145\162\x2e\160\150\160";
YE:
goto H9;
t4:
$Ap = get_mo_option("\141\144\x6d\151\x6e\137\145\155\141\151\x6c") ? get_mo_option("\x61\x64\155\x69\156\137\x65\x6d\141\x69\154") : '';
$jG = $ty->getNonceValue();
include MOV_DIR . "\x76\x69\x65\167\x73\57\141\x63\143\x6f\x75\x6e\164\x2f\154\157\147\x69\x6e\x2e\x70\x68\160";
H9:
goto BV;
eZ:
$S3 = get_mo_option("\141\144\155\151\x6e\137\x70\150\157\x6e\145") ? get_mo_option("\x61\144\155\x69\156\137\x70\150\x6f\156\x65") : '';
$jG = $ty->getNonceValue();
include MOV_DIR . "\x76\x69\145\x77\x73\x2f\x61\x63\143\x6f\x75\156\x74\x2f\166\145\x72\151\x66\x79\x2e\x70\150\x70";
BV:
