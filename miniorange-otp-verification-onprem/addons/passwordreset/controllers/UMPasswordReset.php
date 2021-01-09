<?php


use OTP\Addons\PasswordReset\Handler\UMPasswordResetHandler;
use OTP\Handler\MoOTPActionHandlerHandler;
$ty = UMPasswordResetHandler::instance();
$yJ = MoOTPActionHandlerHandler::instance();
$jd = $ty->isFormEnabled() ? "\143\150\145\x63\x6b\145\144" : '';
$rN = $jd == "\143\x68\145\x63\x6b\x65\144" ? '' : "\x68\151\144\x64\x65\x6e";
$om = $ty->getOtpTypeEnabled();
$GT = $ty->getPhoneHTMLTag();
$zy = $ty->getEmailHTMLTag();
$h_ = $ty->getFormName();
$el = $ty->getButtonText();
$jG = $yJ->getNonceValue();
$a0 = $ty->getFormOption();
$iz = $ty->getPhoneKeyDetails();
$wV = $ty->getIsOnlyPhoneReset() ? "\143\150\x65\143\153\x65\x64" : '';
include UMPR_DIR . "\x76\151\x65\167\163\x2f\x55\115\120\x61\x73\x73\167\x6f\x72\144\122\x65\163\145\x74\56\x70\x68\x70";
