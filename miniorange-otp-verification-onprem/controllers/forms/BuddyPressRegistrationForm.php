<?php


use OTP\Handler\Forms\BuddyPressRegistrationForm;
$ty = BuddyPressRegistrationForm::instance();
$po = $ty->isFormEnabled() ? "\x63\150\145\x63\x6b\x65\x64" : '';
$JY = $po == "\x63\x68\145\143\153\145\144" ? '' : "\150\x69\x64\x64\145\x6e";
$ND = $ty->getOtpTypeEnabled();
$fw = admin_url() . "\165\163\145\x72\163\x2e\x70\150\x70\77\x70\141\147\x65\x3d\142\160\55\x70\x72\157\x66\151\154\x65\x2d\x73\x65\x74\x75\x70";
$Mn = $ty->getPhoneKeyDetails();
$Bh = $ty->disableAutoActivation() ? "\x63\150\145\x63\153\145\144" : '';
$VN = $ty->getPhoneHTMLTag();
$vU = $ty->getEmailHTMLTag();
$ER = $ty->getBothHTMLTag();
$h_ = $ty->getFormName();
$WT = $ty->restrictDuplicates() ? "\143\x68\x65\143\153\145\x64" : '';
get_plugin_form_link($ty->getFormDocuments());
include MOV_DIR . "\x76\151\145\x77\x73\57\146\157\162\155\163\x2f\102\165\144\144\171\x50\x72\145\x73\163\x52\x65\x67\x69\x73\x74\162\x61\164\151\x6f\156\106\157\x72\155\x2e\x70\x68\160";
