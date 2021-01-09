<?php


use OTP\Handler\Forms\WPFormsPlugin;
$ty = WPFormsPlugin::instance();
$Hf = (bool) $ty->isFormEnabled() ? "\x63\x68\145\143\153\145\144" : '';
$tn = $Hf == "\x63\x68\x65\x63\x6b\145\x64" ? '' : "\x68\x69\144\144\x65\x6e";
$Ip = $ty->getOtpTypeEnabled();
$JP = $ty->getFormDetails();
$M0 = admin_url() . "\141\x64\x6d\x69\x6e\x2e\x70\150\160\77\160\141\147\x65\x3d\x77\160\x66\157\x72\x6d\163\x2d\x6f\166\x65\162\x76\151\x65\167";
$Ix = $ty->getButtonText();
$Ef = $ty->getPhoneHTMLTag();
$cY = $ty->getEmailHTMLTag();
$uk = $ty->getBothHTMLTag();
$h_ = $ty->getFormName();
get_plugin_form_link($ty->getFormDocuments());
include MOV_DIR . "\x76\151\145\167\x73\x2f\146\x6f\162\155\x73\x2f\127\x50\x46\157\162\x6d\x73\120\154\165\x67\151\x6e\56\x70\150\x70";
