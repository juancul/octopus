<?php


use OTP\Handler\Forms\RegistrationMagicForm;
$ty = RegistrationMagicForm::instance();
$mS = $ty->isFormEnabled() ? "\x63\x68\x65\143\153\x65\144" : '';
$cB = $mS == "\143\150\145\x63\153\x65\144" ? '' : "\150\151\144\x64\x65\x6e";
$Mi = $ty->getOtpTypeEnabled();
$sM = admin_url() . "\141\144\x6d\151\x6e\x2e\x70\150\160\x3f\x70\141\x67\145\x3d\162\155\137\146\157\162\x6d\137\x6d\141\x6e\141\x67\145";
$Dk = $ty->getFormDetails();
$z3 = $ty->getPhoneHTMLTag();
$XE = $ty->getEmailHTMLTag();
$kf = $ty->getBothHTMLTag();
$h_ = $ty->getFormName();
get_plugin_form_link($ty->getFormDocuments());
include MOV_DIR . "\x76\x69\145\x77\163\x2f\x66\x6f\162\155\163\57\x52\145\147\x69\163\164\x72\x61\164\151\x6f\156\x4d\141\147\151\143\x46\x6f\x72\155\x2e\x70\x68\x70";
