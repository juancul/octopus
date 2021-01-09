<?php


use OTP\Handler\Forms\UserUltraRegistrationForm;
$ty = UserUltraRegistrationForm::instance();
$Ws = $ty->isFormEnabled() ? "\143\x68\x65\143\153\x65\x64" : '';
$OE = $Ws == "\x63\x68\145\x63\153\x65\x64" ? '' : "\x68\x69\144\144\x65\x6e";
$Q1 = $ty->getOtpTypeEnabled();
$Dg = admin_url() . "\x61\144\x6d\151\156\56\x70\x68\x70\x3f\x70\x61\x67\145\75\x75\163\145\x72\x75\x6c\164\x72\x61\46\x74\141\x62\75\x66\x69\x65\x6c\x64\x73";
$Gx = $ty->getPhoneKeyDetails();
$MM = $ty->getPhoneHTMLTag();
$Hb = $ty->getEmailHTMLTag();
$sc = $ty->getBothHTMLTag();
$h_ = $ty->getFormName();
get_plugin_form_link($ty->getFormDocuments());
include MOV_DIR . "\x76\151\x65\x77\163\57\146\x6f\x72\155\163\x2f\x55\x73\x65\x72\125\x6c\x74\162\141\122\x65\147\151\x73\164\162\x61\164\151\x6f\x6e\106\157\162\x6d\56\160\150\160";
