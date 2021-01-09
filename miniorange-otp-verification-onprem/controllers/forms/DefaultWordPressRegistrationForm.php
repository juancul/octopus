<?php


use OTP\Handler\Forms\DefaultWordPressRegistrationForm;
$ty = DefaultWordPressRegistrationForm::instance();
$rY = (bool) $ty->isFormEnabled() ? "\143\150\x65\x63\x6b\x65\x64" : '';
$h9 = $rY == "\143\x68\x65\143\x6b\145\144" ? '' : "\x68\151\x64\x64\x65\156";
$pk = $ty->getOtpTypeEnabled();
$ZC = (bool) $ty->restrictDuplicates() ? "\143\150\145\143\x6b\145\144" : '';
$X6 = $ty->getPhoneHTMLTag();
$sm = $ty->getEmailHTMLTag();
$In = $ty->getBothHTMLTag();
$h_ = $ty->getFormName();
$t8 = $ty->disableAutoActivation() ? '' : "\x63\150\x65\x63\x6b\145\x64";
get_plugin_form_link($ty->getFormDocuments());
include MOV_DIR . "\166\x69\x65\x77\163\x2f\146\157\162\155\x73\57\x44\145\146\141\165\x6c\164\127\x6f\162\x64\120\162\145\x73\163\x52\x65\x67\x69\163\164\162\141\164\x69\157\156\x46\x6f\162\155\56\x70\150\160";
