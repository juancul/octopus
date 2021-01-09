<?php


use OTP\Handler\Forms\ClassifyRegistrationForm;
$ty = ClassifyRegistrationForm::instance();
$nI = $ty->isFormEnabled() ? "\143\150\x65\x63\153\145\144" : '';
$WP = $nI == "\x63\150\145\143\153\145\144" ? '' : "\x68\x69\x64\x64\x65\x6e";
$fo = $ty->getOtpTypeEnabled();
$er = $ty->getPhoneHTMLTag();
$Xl = $ty->getEmailHTMLTag();
$h_ = $ty->getFormName();
get_plugin_form_link($ty->getFormDocuments());
include MOV_DIR . "\166\151\x65\167\163\57\x66\157\x72\x6d\x73\x2f\103\154\x61\163\x73\151\x66\171\x52\x65\x67\x69\x73\x74\x72\141\x74\151\x6f\x6e\106\157\162\155\56\x70\x68\160";
