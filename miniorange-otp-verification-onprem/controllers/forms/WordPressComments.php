<?php


use OTP\Handler\Forms\WordPressComments;
$ty = WordPressComments::instance();
$Gn = (bool) $ty->isFormEnabled() ? "\143\150\x65\143\x6b\x65\144" : '';
$ad = $Gn == "\x63\150\145\143\x6b\145\x64" ? '' : "\150\151\x64\x64\x65\x6e";
$W7 = $ty->getOtpTypeEnabled();
$eI = $ty->bypassForLoggedInUsers() ? "\143\x68\145\143\x6b\145\144" : '';
$n2 = $ty->getPhoneHTMLTag();
$Qc = $ty->getEmailHTMLTag();
$h_ = $ty->getFormName();
get_plugin_form_link($ty->getFormDocuments());
include MOV_DIR . "\166\151\x65\167\163\x2f\x66\x6f\162\155\163\57\127\157\x72\x64\120\x72\145\163\163\x43\157\x6d\155\145\x6e\164\x73\x2e\160\150\160";
