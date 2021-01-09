<?php


use OTP\Handler\Forms\UltimateMemberProfileForm;
$ty = UltimateMemberProfileForm::instance();
$UF = $ty->isFormEnabled() ? "\x63\150\x65\x63\153\x65\x64" : '';
$pY = $UF == "\143\150\x65\143\x6b\145\x64" ? '' : "\x68\151\144\144\x65\156";
$CK = $ty->getOtpTypeEnabled();
$kN = $ty->getPhoneKeyDetails();
$wN = admin_url() . "\145\x64\x69\x74\56\x70\x68\160\x3f\160\157\x73\x74\x5f\164\x79\x70\x65\x3d\165\x6d\x5f\146\157\162\x6d";
$V8 = $ty->getPhoneHTMLTag();
$eR = $ty->getEmailHTMLTag();
$jL = $ty->getBothHTMLTag();
$KZ = $ty->restrictDuplicates() ? "\x63\150\x65\143\x6b\x65\144" : '';
$h_ = $ty->getFormName();
$gC = $ty->getButtonText();
get_plugin_form_link($ty->getFormDocuments());
include MOV_DIR . "\166\151\x65\x77\x73\57\x66\157\162\155\x73\57\x55\x6c\x74\x69\x6d\141\164\x65\115\x65\155\x62\145\162\x50\162\157\x66\151\154\x65\x46\157\x72\155\x2e\160\x68\x70";
