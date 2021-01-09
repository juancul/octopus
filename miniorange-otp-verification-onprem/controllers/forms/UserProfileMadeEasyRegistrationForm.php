<?php


use OTP\Handler\Forms\UserProfileMadeEasyRegistrationForm;
$ty = UserProfileMadeEasyRegistrationForm::instance();
$fs = $ty->isFormEnabled() ? "\143\150\145\x63\x6b\x65\144" : '';
$i7 = $fs == "\143\x68\x65\x63\x6b\145\144" ? '' : "\150\x69\144\144\x65\156";
$FU = $ty->getOtpTypeEnabled();
$or = admin_url() . "\141\x64\155\x69\x6e\x2e\x70\x68\160\77\160\141\x67\145\75\165\x70\155\145\x2d\146\x69\145\154\144\55\x63\165\x73\x74\157\155\x69\x7a\145\x72";
$Rz = $ty->getPhoneKeyDetails();
$Yn = $ty->getPhoneHTMLTag();
$Sw = $ty->getEmailHTMLTag();
$kd = $ty->getBothHTMLTag();
$h_ = $ty->getFormName();
get_plugin_form_link($ty->getFormDocuments());
include MOV_DIR . "\x76\151\145\167\x73\x2f\146\157\x72\x6d\163\57\125\x73\x65\x72\x50\x72\157\x66\151\x6c\145\115\x61\x64\x65\105\x61\163\x79\x52\x65\147\x69\x73\x74\162\x61\x74\x69\x6f\x6e\x46\157\x72\155\56\160\x68\160";
