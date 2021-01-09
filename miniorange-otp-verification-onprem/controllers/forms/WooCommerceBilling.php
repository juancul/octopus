<?php


use OTP\Handler\Forms\WooCommerceBilling;
$ty = WooCommerceBilling::instance();
$Q0 = (bool) $ty->isFormEnabled() ? "\x63\150\x65\x63\x6b\x65\144" : '';
$EH = $Q0 == "\x63\x68\145\x63\x6b\145\144" ? '' : "\150\151\x64\x64\145\x6e";
$gl = $ty->getOtpTypeEnabled();
$Tz = $ty->getPhoneHTMLTag();
$s2 = $ty->getEmailHTMLTag();
$ca = (bool) $ty->restrictDuplicates() ? "\143\x68\x65\x63\153\x65\144" : '';
$Ix = $ty->getButtonText();
$h_ = $ty->getFormName();
get_plugin_form_link($ty->getFormDocuments());
include MOV_DIR . "\166\x69\x65\167\163\x2f\146\157\x72\155\x73\57\127\157\157\103\x6f\x6d\x6d\x65\x72\x63\145\102\151\154\x6c\151\x6e\x67\56\160\150\160";
