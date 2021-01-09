<?php


use OTP\Handler\Forms\SimplrRegistrationForm;
$ty = SimplrRegistrationForm::instance();
$zN = $ty->isFormEnabled() ? "\x63\150\145\x63\x6b\x65\x64" : '';
$Gz = $zN == "\143\150\145\x63\153\x65\x64" ? '' : "\x68\x69\x64\144\145\156";
$j3 = $ty->getOtpTypeEnabled();
$sW = admin_url() . "\157\160\x74\x69\x6f\x6e\x73\x2d\147\145\x6e\x65\162\x61\154\x2e\160\x68\160\77\160\x61\147\145\75\163\x69\155\x70\x6c\x72\137\x72\145\x67\x5f\163\145\164\x26\162\145\x67\x76\151\x65\167\75\x66\151\145\154\x64\163\46\x6f\x72\144\145\162\x62\171\75\156\x61\155\x65\46\157\x72\x64\145\x72\75\144\x65\163\143";
$o1 = $ty->getPhoneKeyDetails();
$ZU = $ty->getPhoneHTMLTag();
$yr = $ty->getEmailHTMLTag();
$T5 = $ty->getBothHTMLTag();
$h_ = $ty->getFormName();
get_plugin_form_link($ty->getFormDocuments());
include MOV_DIR . "\x76\151\145\167\x73\57\146\x6f\162\155\163\x2f\123\151\155\160\154\x72\x52\x65\x67\151\x73\x74\162\141\x74\x69\157\156\106\157\x72\155\x2e\x70\150\x70";
