<?php


use OTP\Handler\Forms\WooCommerceRegistrationForm;
use OTP\Helper\MoUtility;
$ty = WooCommerceRegistrationForm::instance();
$RZ = (bool) $ty->isFormEnabled() ? "\x63\150\145\143\153\x65\144" : '';
$o3 = $RZ == "\143\x68\145\143\153\x65\144" ? '' : "\x68\151\144\x64\x65\x6e";
$UZ = $ty->getOtpTypeEnabled();
$ca = (bool) $ty->restrictDuplicates() ? "\x63\x68\x65\143\x6b\x65\144" : '';
$E6 = $ty->getPhoneHTMLTag();
$Ur = $ty->getEmailHTMLTag();
$rx = $ty->getBothHTMLTag();
$h_ = $ty->getFormName();
$lN = $ty->redirectToPage();
$ii = MoUtility::isBlank($lN) ? '' : get_page_by_title($lN)->ID;
$E3 = $ty->isAjaxForm();
$BA = $E3 ? "\x63\150\x65\x63\153\145\x64" : '';
$Ui = $ty->getButtonText();
get_plugin_form_link($ty->getFormDocuments());
include MOV_DIR . "\x76\x69\145\167\163\57\146\x6f\x72\155\163\x2f\127\157\157\x43\x6f\155\x6d\145\162\x63\145\x52\145\147\151\x73\164\x72\x61\x74\151\x6f\x6e\106\157\162\155\56\x70\x68\x70";
