<?php


use OTP\Handler\Forms\NinjaFormAjaxForm;
$ty = NinjaFormAjaxForm::instance();
$jV = $ty->isFormEnabled() ? "\x63\150\145\x63\153\145\144" : '';
$Xu = $jV == "\143\150\x65\x63\153\x65\144" ? '' : "\x68\151\144\x64\145\156";
$u_ = $ty->getOtpTypeEnabled();
$am = admin_url() . "\141\x64\155\x69\156\56\160\150\x70\77\x70\141\147\x65\x3d\x6e\x69\156\x6a\x61\55\146\157\x72\155\x73";
$rV = $ty->getFormDetails();
$LV = $ty->getPhoneHTMLTag();
$J3 = $ty->getEmailHTMLTag();
$Ix = $ty->getButtonText();
$h_ = $ty->getFormName();
get_plugin_form_link($ty->getFormDocuments());
include MOV_DIR . "\x76\x69\145\x77\x73\x2f\x66\157\162\155\x73\x2f\x4e\151\156\x6a\141\106\157\x72\x6d\x41\x6a\141\x78\106\x6f\x72\x6d\x2e\160\x68\160";
