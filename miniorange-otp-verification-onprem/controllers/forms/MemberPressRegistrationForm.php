<?php


use OTP\Handler\Forms\MemberPressRegistrationForm;
$ty = MemberPressRegistrationForm::instance();
$HB = $ty->isFormEnabled() ? "\x63\x68\x65\143\x6b\145\144" : '';
$mb = $HB == "\143\x68\145\143\153\145\x64" ? '' : "\150\x69\x64\x64\145\156";
$hW = $ty->getOtpTypeEnabled();
$tN = $ty->getPhoneKeyDetails();
$Ik = admin_url() . "\141\144\x6d\x69\156\56\160\150\160\77\160\141\x67\145\x3d\x6d\x65\155\142\145\162\x70\x72\145\x73\x73\55\157\x70\x74\151\x6f\156\163\x23\155\145\x70\x72\x2d\146\x69\x65\x6c\144\163";
$tW = $ty->getPhoneHTMLTag();
$hJ = $ty->getEmailHTMLTag();
$tK = $ty->getBothHTMLTag();
$h_ = $ty->getFormName();
$b2 = $ty->bypassForLoggedInUsers() ? "\143\x68\x65\143\x6b\145\x64" : '';
get_plugin_form_link($ty->getFormDocuments());
include MOV_DIR . "\x76\151\x65\x77\x73\57\146\x6f\162\155\x73\x2f\x4d\145\155\x62\145\x72\120\162\x65\163\163\x52\x65\147\151\x73\164\162\x61\164\151\157\156\x46\x6f\162\155\x2e\160\150\160";
