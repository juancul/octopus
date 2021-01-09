<?php


use OTP\Handler\Forms\PaidMembershipForm;
$ty = PaidMembershipForm::instance();
$J2 = $ty->isFormEnabled() ? "\143\150\x65\x63\153\x65\144" : '';
$tY = $J2 == "\143\150\145\x63\153\145\x64" ? '' : "\150\x69\x64\144\145\156";
$OK = $ty->getOtpTypeEnabled();
$w4 = $ty->getPhoneHTMLTag();
$QO = $ty->getEmailHTMLTag();
$h_ = $ty->getFormName();
get_plugin_form_link($ty->getFormDocuments());
include MOV_DIR . "\x76\x69\145\167\163\x2f\146\157\162\155\163\57\120\141\151\x64\x4d\x65\155\142\x65\162\x73\x68\151\160\x46\157\x72\x6d\x2e\x70\x68\160";
