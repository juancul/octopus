<?php


use OTP\Handler\Forms\WpMemberForm;
$ty = WpMemberForm::instance();
$PM = (bool) $ty->isFormEnabled() ? "\143\150\145\143\x6b\145\x64" : '';
$lI = $PM == "\143\x68\145\143\153\x65\144" ? '' : "\150\151\144\144\x65\x6e";
$qm = $ty->getOtpTypeEnabled();
$VC = admin_url() . "\141\144\x6d\x69\x6e\x2e\160\x68\x70\77\160\x61\x67\145\75\167\x70\155\145\155\x2d\163\x65\x74\164\151\156\147\x73\x26\164\x61\x62\75\146\151\145\154\x64\x73";
$jY = $ty->getPhoneHTMLTag();
$df = $ty->getEmailHTMLTag();
$h_ = $ty->getFormName();
$S0 = $ty->getPhoneKeyDetails();
get_plugin_form_link($ty->getFormDocuments());
include MOV_DIR . "\x76\x69\145\167\163\57\x66\157\162\155\x73\x2f\127\160\115\145\x6d\142\x65\x72\x46\157\x72\155\56\160\x68\160";
