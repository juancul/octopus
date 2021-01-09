<?php


use OTP\Handler\Forms\GravityForm;
$ty = GravityForm::instance();
$cP = $ty->isFormEnabled() ? "\143\150\x65\x63\x6b\x65\144" : '';
$t7 = $cP == "\x63\x68\145\x63\153\145\144" ? '' : "\150\151\144\x64\145\x6e";
$nJ = $ty->getOtpTypeEnabled();
$v7 = admin_url() . "\x61\144\x6d\151\x6e\56\160\x68\160\x3f\160\141\x67\145\x3d\147\x66\137\x65\144\151\164\137\146\157\162\155\x73";
$CJ = $ty->getFormDetails();
$uX = $ty->getEmailHTMLTag();
$JR = $ty->getPhoneHTMLTag();
$h_ = $ty->getFormName();
$t6 = $ty->getButtonText();
get_plugin_form_link($ty->getFormDocuments());
include MOV_DIR . "\x76\x69\145\x77\163\57\x66\157\x72\155\163\57\x47\x72\x61\166\151\x74\x79\106\x6f\x72\x6d\56\x70\150\160";
