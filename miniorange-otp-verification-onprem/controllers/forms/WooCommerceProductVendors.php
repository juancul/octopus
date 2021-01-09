<?php


use OTP\Handler\Forms\WooCommerceProductVendors;
$ty = WooCommerceProductVendors::instance();
$b0 = (bool) $ty->isFormEnabled() ? "\x63\150\x65\x63\x6b\145\x64" : '';
$NS = $b0 == "\143\x68\x65\x63\x6b\x65\144" ? '' : "\x68\x69\x64\x64\145\156";
$Dz = $ty->getOtpTypeEnabled();
$qD = (bool) $ty->restrictDuplicates() ? "\x63\x68\145\143\153\x65\x64" : '';
$rI = $ty->getPhoneHTMLTag();
$Tc = $ty->getEmailHTMLTag();
$Vz = $ty->getBothHTMLTag();
$h_ = $ty->getFormName();
$E3 = $ty->isAjaxForm();
$BA = $E3 ? "\143\150\145\143\x6b\x65\x64" : '';
$xn = $ty->getButtonText();
get_plugin_form_link($ty->getFormDocuments());
include MOV_DIR . "\166\151\145\167\163\x2f\146\x6f\x72\155\163\57\127\157\x6f\103\157\155\x6d\145\162\x63\145\x50\x72\x6f\144\x75\143\164\126\145\156\x64\157\162\163\x2e\x70\150\160";
