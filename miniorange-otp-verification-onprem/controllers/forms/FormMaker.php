<?php


use OTP\Handler\Forms\FormMaker;
$ty = FormMaker::instance();
$kI = (bool) $ty->isFormEnabled() ? "\143\x68\145\143\153\145\x64" : '';
$xB = $kI == "\143\150\145\143\153\145\144" ? '' : "\150\x69\144\x64\x65\156";
$Rh = admin_url() . "\141\x64\155\x69\x6e\x2e\x70\150\x70\77\x70\x61\x67\145\x3d\155\141\156\x61\147\x65\137\x66\155";
$OB = $ty->getOtpTypeEnabled();
$pi = $ty->getEmailHTMLTag();
$X7 = $ty->getPhoneHTMLTag();
$tv = $ty->getFormDetails();
$h_ = $ty->getFormName();
$Ix = $ty->getButtonText();
get_plugin_form_link($ty->getFormDocuments());
include MOV_DIR . "\x76\151\145\167\x73\x2f\x66\157\x72\x6d\x73\x2f\x46\x6f\x72\x6d\x4d\x61\153\145\162\x2e\160\x68\160";
