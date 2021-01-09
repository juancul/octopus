<?php


use OTP\Handler\Forms\ProfileBuilderRegistrationForm;
$ty = ProfileBuilderRegistrationForm::instance();
$fh = $ty->isFormEnabled() ? "\x63\x68\x65\x63\x6b\145\144" : '';
$RQ = $fh == "\x63\150\145\x63\153\145\x64" ? '' : "\x68\151\x64\144\145\x6e";
$If = $ty->getOtpTypeEnabled();
$Uv = $ty->getPhoneKeyDetails();
$nd = admin_url() . "\141\x64\155\x69\156\56\160\150\160\77\x70\141\x67\x65\75\155\x61\156\141\147\145\x2d\x66\151\x65\154\144\163";
$tG = $ty->getPhoneHTMLTag();
$BS = $ty->getEmailHTMLTag();
$CO = $ty->getBothHTMLTag();
$h_ = $ty->getFormName();
get_plugin_form_link($ty->getFormDocuments());
include MOV_DIR . "\166\151\x65\167\x73\x2f\x66\157\162\155\163\57\120\x72\x6f\x66\x69\154\145\102\x75\151\x6c\144\x65\x72\x52\145\x67\151\163\x74\162\141\x74\151\x6f\x6e\x46\157\162\155\x2e\160\x68\160";
