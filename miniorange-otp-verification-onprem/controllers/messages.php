<?php


use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
$jG = $yJ->getNonceValue();
$vO = get_mo_option("\x73\165\143\x63\145\x73\163\x5f\x65\x6d\141\x69\x6c\137\x6d\x65\x73\163\x61\x67\x65", "\155\157\x5f\157\164\x70\x5f") ? get_mo_option("\163\165\143\143\145\x73\x73\x5f\145\155\x61\151\x6c\137\x6d\145\163\x73\141\147\145", "\x6d\157\137\x6f\x74\160\x5f") : MoMessages::showMessage(MoMessages::OTP_SENT_EMAIL);
$Tn = get_mo_option("\163\x75\143\143\145\x73\x73\x5f\160\150\157\x6e\145\x5f\x6d\x65\163\x73\x61\x67\x65", "\155\x6f\137\x6f\164\x70\x5f") ? get_mo_option("\163\165\143\x63\x65\163\163\137\160\150\157\x6e\x65\x5f\155\x65\x73\163\x61\147\x65", "\155\x6f\137\x6f\164\x70\x5f") : MoMessages::showMessage(MoMessages::OTP_SENT_PHONE);
$ug = get_mo_option("\x65\162\162\x6f\x72\x5f\x70\150\x6f\x6e\x65\x5f\x6d\145\x73\163\x61\147\x65", "\155\x6f\x5f\157\x74\160\137") ? get_mo_option("\145\x72\162\x6f\x72\x5f\160\150\x6f\156\x65\137\155\x65\x73\x73\x61\147\x65", "\155\157\137\x6f\x74\x70\137") : MoMessages::showMessage(MoMessages::ERROR_OTP_PHONE);
$ks = get_mo_option("\x65\162\x72\x6f\162\137\145\155\141\151\154\137\155\145\x73\163\141\147\x65", "\x6d\x6f\137\157\x74\160\137") ? get_mo_option("\x65\162\x72\157\162\137\x65\x6d\141\x69\x6c\137\x6d\145\x73\163\x61\x67\x65", "\155\x6f\x5f\x6f\164\160\137") : MoMessages::showMessage(MoMessages::ERROR_OTP_EMAIL);
$RI = get_mo_option("\x69\156\x76\141\154\151\x64\x5f\x70\x68\157\x6e\x65\x5f\155\145\x73\163\141\147\145", "\155\157\x5f\157\164\x70\137") ? get_mo_option("\x69\156\x76\x61\x6c\x69\144\x5f\160\150\157\x6e\x65\x5f\155\x65\163\163\141\x67\x65", "\155\x6f\137\x6f\x74\160\137") : MoMessages::showMessage(MoMessages::ERROR_PHONE_FORMAT);
$y9 = get_mo_option("\151\x6e\x76\x61\154\x69\144\x5f\x65\x6d\141\x69\x6c\137\155\145\163\x73\x61\x67\145", "\x6d\157\x5f\x6f\164\160\x5f") ? get_mo_option("\151\x6e\x76\x61\x6c\151\144\137\x65\155\141\151\x6c\x5f\155\x65\x73\x73\141\147\145", "\x6d\157\x5f\x6f\164\160\137") : MoMessages::showMessage(MoMessages::ERROR_EMAIL_FORMAT);
$dU = MoUtility::_get_invalid_otp_method();
$jj = get_mo_option("\x62\154\x6f\143\x6b\145\144\x5f\145\x6d\x61\151\154\137\x6d\x65\x73\x73\x61\x67\x65", "\155\x6f\137\157\x74\x70\137") ? get_mo_option("\x62\x6c\157\x63\x6b\145\144\137\145\x6d\x61\x69\x6c\137\155\x65\163\x73\x61\x67\x65", "\x6d\x6f\x5f\x6f\x74\160\x5f") : MoMessages::showMessage(MoMessages::ERROR_EMAIL_BLOCKED);
$wf = get_mo_option("\x62\154\157\x63\153\x65\144\137\160\x68\157\x6e\x65\137\x6d\145\163\x73\141\x67\145", "\155\157\137\x6f\x74\160\137") ? get_mo_option("\x62\154\157\x63\153\x65\x64\137\160\150\157\x6e\x65\x5f\155\x65\x73\163\141\x67\145", "\155\157\137\x6f\x74\160\x5f") : MoMessages::showMessage(MoMessages::ERROR_PHONE_BLOCKED);
include MOV_DIR . "\166\151\145\167\x73\57\x6d\x65\163\x73\x61\147\145\x73\56\160\150\x70";
