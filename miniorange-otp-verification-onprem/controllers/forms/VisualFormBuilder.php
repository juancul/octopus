<?php


use OTP\Handler\Forms\VisualFormBuilder;
$ty = VisualFormBuilder::instance();
$vV = $ty->isFormEnabled() ? "\x63\x68\145\143\x6b\x65\144" : '';
$UL = $vV == "\143\150\x65\x63\153\145\x64" ? '' : "\150\151\x64\x64\x65\x6e";
$m9 = $ty->getOtpTypeEnabled();
$xZ = admin_url() . "\x61\144\155\151\x6e\x2e\160\x68\160\x3f\x70\x61\x67\145\75\166\151\x73\x75\141\154\55\x66\x6f\x72\x6d\x2d\x62\x75\151\154\x64\x65\162";
$dP = $ty->getFormDetails();
$x5 = $ty->getPhoneHTMLTag();
$nX = $ty->getEmailHTMLTag();
$Ix = $ty->getButtonText();
$h_ = $ty->getFormName();
get_plugin_form_link($ty->getFormDocuments());
include MOV_DIR . "\x76\151\x65\x77\163\57\x66\157\x72\155\x73\x2f\126\151\x73\165\141\x6c\x46\157\x72\x6d\x42\165\151\x6c\x64\145\x72\x2e\160\150\160";
