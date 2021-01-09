<?php


use OTP\Handler\Forms\WPClientRegistration;
$ty = WPClientRegistration::instance();
$Kk = $ty->isFormEnabled() ? "\x63\150\x65\x63\x6b\145\x64" : '';
$EQ = $Kk == "\143\x68\x65\x63\x6b\x65\x64" ? '' : "\x68\151\144\144\145\x6e";
$J5 = $ty->getOtpTypeEnabled();
$u2 = $ty->getPhoneHTMLTag();
$Qw = $ty->getEmailHTMLTag();
$kT = $ty->getBothHTMLTag();
$h_ = $ty->getFormName();
$WT = $ty->restrictDuplicates() ? "\x63\150\145\143\153\145\x64" : '';
get_plugin_form_link($ty->getFormDocuments());
include MOV_DIR . "\x76\x69\145\x77\x73\x2f\x66\x6f\162\155\163\57\x57\120\x43\x6c\151\x65\x6e\x74\x52\x65\147\x69\163\x74\x72\141\x74\151\x6f\156\x2e\160\150\x70";
