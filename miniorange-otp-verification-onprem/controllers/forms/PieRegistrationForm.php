<?php


use OTP\Handler\Forms\PieRegistrationForm;
$ty = PieRegistrationForm::instance();
$W5 = $ty->isFormEnabled() ? "\x63\x68\x65\143\x6b\145\x64" : '';
$Mo = $W5 == "\x63\150\145\143\153\145\x64" ? '' : "\150\151\x64\144\145\x6e";
$P9 = $ty->getOtpTypeEnabled();
$VE = $ty->getPhoneKeyDetails();
$Oq = $ty->getPhoneHTMLTag();
$rU = $ty->getEmailHTMLTag();
$ie = $ty->getBothHTMLTag();
$h_ = $ty->getFormName();
get_plugin_form_link($ty->getFormDocuments());
include MOV_DIR . "\x76\x69\145\167\x73\57\146\x6f\x72\155\x73\57\x50\x69\x65\x52\x65\x67\151\x73\x74\162\x61\164\x69\x6f\156\x46\157\162\155\56\x70\150\160";
