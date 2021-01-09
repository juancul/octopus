<?php


use OTP\Handler\Forms\FormCraftPremiumForm;
$ty = FormCraftPremiumForm::instance();
$PQ = $ty->isFormEnabled() ? "\143\x68\x65\143\153\x65\x64" : '';
$Xt = $PQ == "\x63\x68\145\x63\x6b\x65\144" ? '' : "\150\151\x64\144\145\156";
$Lk = $ty->getOtpTypeEnabled();
$ux = admin_url() . "\141\x64\x6d\151\x6e\x2e\x70\x68\160\77\x70\x61\x67\x65\75\146\x6f\x72\155\143\x72\x61\x66\164\x5f\x61\x64\x6d\151\156";
$Yu = $ty->getFormDetails();
$ly = $ty->getPhoneHTMLTag();
$Iz = $ty->getEmailHTMLTag();
$h_ = $ty->getFormName();
get_plugin_form_link($ty->getFormDocuments());
include MOV_DIR . "\x76\151\x65\x77\x73\57\x66\157\162\x6d\x73\x2f\x46\x6f\x72\x6d\x43\162\141\x66\164\120\x72\x65\x6d\151\165\x6d\106\x6f\162\155\x2e\160\x68\x70";
