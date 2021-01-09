<?php


use OTP\Handler\Forms\UserProRegistrationForm;
$ty = UserProRegistrationForm::instance();
$Qv = $ty->isFormEnabled() ? "\143\x68\145\x63\153\x65\144" : '';
$rC = $Qv == "\143\150\145\x63\x6b\x65\144" ? '' : "\x68\x69\144\144\x65\x6e";
$Z9 = $ty->getOtpTypeEnabled();
$LO = admin_url() . "\141\144\155\x69\x6e\56\x70\150\x70\x3f\x70\141\x67\145\75\165\163\145\162\160\x72\x6f\x26\x74\x61\142\x3d\x66\x69\x65\154\144\163";
$qJ = $ty->disableAutoActivation() ? "\x63\150\x65\143\x6b\145\x64" : '';
$bM = $ty->getPhoneHTMLTag();
$hl = $ty->getEmailHTMLTag();
$h_ = $ty->getFormName();
get_plugin_form_link($ty->getFormDocuments());
include MOV_DIR . "\x76\x69\x65\167\x73\57\146\x6f\162\x6d\x73\57\125\163\145\162\120\162\157\122\x65\x67\x69\x73\x74\x72\141\x74\151\157\156\106\157\162\155\56\160\150\x70";
