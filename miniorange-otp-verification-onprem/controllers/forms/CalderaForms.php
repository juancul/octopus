<?php


use OTP\Handler\Forms\CalderaForms;
$ty = CalderaForms::instance();
$K8 = (bool) $ty->isFormEnabled() ? "\143\150\x65\143\153\x65\x64" : '';
$FM = $K8 == "\143\x68\145\x63\153\145\x64" ? '' : "\150\x69\144\144\x65\156";
$u9 = $ty->getOtpTypeEnabled();
$TN = $ty->getFormDetails();
$UV = admin_url() . "\x61\x64\x6d\x69\156\56\x70\150\160\77\x70\141\x67\145\75\143\141\154\x64\x65\162\x61\x2d\146\x6f\162\x6d\163";
$Ix = $ty->getButtonText();
$GC = $ty->getPhoneHTMLTag();
$u0 = $ty->getEmailHTMLTag();
$h_ = $ty->getFormName();
get_plugin_form_link($ty->getFormDocuments());
include MOV_DIR . "\166\151\x65\167\163\x2f\146\157\x72\x6d\163\x2f\x43\141\154\x64\x65\162\x61\x46\157\x72\x6d\x73\x2e\160\150\160";
