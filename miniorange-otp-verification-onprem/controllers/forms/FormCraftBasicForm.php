<?php


use OTP\Handler\Forms\FormCraftBasicForm;
$ty = FormCraftBasicForm::instance();
$d1 = $ty->isFormEnabled() ? "\143\150\x65\143\153\145\x64" : '';
$gX = $d1 == "\x63\x68\145\x63\153\145\x64" ? '' : "\x68\x69\144\x64\145\156";
$fb = $ty->getOtpTypeEnabled();
$Mt = admin_url() . "\141\x64\155\x69\156\x2e\x70\150\160\x3f\160\x61\x67\145\x3d\x66\x6f\162\155\143\x72\x61\x66\164\137\142\141\163\151\143\x5f\144\x61\163\150\142\x6f\141\x72\x64";
$gF = $ty->getFormDetails();
$Ys = $ty->getPhoneHTMLTag();
$rb = $ty->getEmailHTMLTag();
$h_ = $ty->getFormName();
get_plugin_form_link($ty->getFormDocuments());
include MOV_DIR . "\166\151\x65\x77\163\57\146\x6f\162\x6d\x73\57\106\157\x72\x6d\103\x72\141\146\x74\x42\x61\x73\151\x63\106\157\x72\155\x2e\x70\x68\x70";
