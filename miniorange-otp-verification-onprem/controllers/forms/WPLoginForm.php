<?php


use OTP\Handler\Forms\WPLoginForm;
$ty = WPLoginForm::instance();
$Wi = (bool) $ty->isFormEnabled() ? "\143\x68\x65\x63\x6b\x65\144" : '';
$Gk = $Wi == "\143\x68\145\x63\x6b\145\x64" ? '' : "\150\151\144\x64\x65\156";
$aC = (bool) $ty->savePhoneNumbers() ? "\143\150\x65\x63\x6b\x65\x64" : '';
$gb = $ty->getPhoneKeyDetails();
$K0 = (bool) $ty->byPassCheckForAdmins() ? "\143\150\145\x63\153\145\144" : '';
$NK = (bool) $ty->allowLoginThroughPhone() ? "\143\150\x65\x63\x6b\x65\x64" : '';
$r8 = (bool) $ty->restrictDuplicates() ? "\143\150\x65\x63\x6b\145\x64" : '';
$OX = $ty->getOtpTypeEnabled();
$bs = $ty->getPhoneHTMLTag();
$OT = $ty->getEmailHTMLTag();
$h_ = $ty->getFormName();
$c4 = $ty->getSkipPasswordCheck() ? "\143\x68\145\x63\x6b\145\x64" : '';
$fA = $ty->getSkipPasswordCheck() ? "\x62\154\157\x63\x6b" : "\150\151\144\x64\145\156";
$VL = $ty->getSkipPasswordCheckFallback() ? "\143\150\x65\x63\x6b\x65\x64" : '';
$CG = $ty->getUserLabel();
$AF = $ty->isDelayOtp() ? "\x63\x68\x65\x63\153\x65\144" : '';
$PD = $ty->isDelayOtp() ? "\x62\x6c\157\143\x6b" : "\x68\x69\144\144\145\x6e";
$xf = $ty->getDelayOtpInterval();
get_plugin_form_link($ty->getFormDocuments());
include MOV_DIR . "\166\151\145\167\163\x2f\x66\x6f\162\155\163\57\x57\x50\114\157\x67\151\156\x46\x6f\162\155\x2e\x70\x68\160";
