<?php


use OTP\Handler\Forms\UltimateMemberRegistrationForm;
$ty = UltimateMemberRegistrationForm::instance();
$q_ = $ty->isFormEnabled() ? "\x63\x68\145\x63\x6b\x65\144" : '';
$d5 = $q_ == "\x63\x68\145\143\x6b\x65\144" ? '' : "\150\151\x64\144\x65\x6e";
$OV = $ty->getOtpTypeEnabled();
$wx = admin_url() . "\145\144\151\x74\x2e\160\150\x70\x3f\x70\157\163\164\137\x74\171\160\x65\75\x75\155\x5f\146\157\162\155";
$mC = $ty->getPhoneHTMLTag();
$n_ = $ty->getEmailHTMLTag();
$Nq = $ty->getBothHTMLTag();
$cy = $ty->restrictDuplicates() ? "\143\x68\x65\143\x6b\145\144" : '';
$h_ = $ty->getFormName();
$l3 = $ty->getButtonText();
$E3 = $ty->isAjaxForm();
$BA = $E3 ? "\143\x68\x65\143\x6b\145\144" : '';
$IO = $ty->getFormKey();
$w3 = $ty->getPhoneKeyDetails();
get_plugin_form_link($ty->getFormDocuments());
include MOV_DIR . "\x76\151\x65\x77\x73\x2f\x66\x6f\x72\155\163\57\125\154\x74\x69\x6d\141\164\145\x4d\x65\155\142\x65\162\122\x65\x67\151\x73\164\162\141\x74\151\157\x6e\106\x6f\x72\x6d\x2e\160\150\x70";
