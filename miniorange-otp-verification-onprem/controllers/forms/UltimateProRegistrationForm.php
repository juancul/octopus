<?php


use OTP\Handler\Forms\UltimateProRegistrationForm;
$ty = UltimateProRegistrationForm::instance();
$tl = (bool) $ty->isFormEnabled() ? "\143\150\x65\x63\153\145\144" : '';
$KC = $tl == "\143\150\x65\x63\153\145\x64" ? '' : "\x68\151\144\144\145\x6e";
$uy = $ty->getOtpTypeEnabled();
$j_ = admin_url() . "\141\144\155\151\156\56\160\x68\x70\x3f\160\141\147\x65\x3d\151\150\x63\x5f\x6d\x61\x6e\x61\x67\145\x26\164\141\142\75\x72\x65\x67\x69\163\164\145\162\x26\163\x75\142\x74\x61\142\x3d\x63\165\163\164\x6f\x6d\137\x66\151\145\x6c\x64\x73";
$rP = $ty->getPhoneHTMLTag();
$R8 = $ty->getEmailHTMLTag();
$h_ = $ty->getFormName();
get_plugin_form_link($ty->getFormDocuments());
include MOV_DIR . "\x76\x69\x65\167\163\57\146\x6f\x72\155\163\57\125\154\164\151\x6d\141\164\x65\120\x72\x6f\x52\145\x67\151\163\x74\162\141\164\x69\x6f\x6e\106\x6f\162\155\x2e\160\x68\160";
