<?php


namespace OTP\Objects;

interface IFormHandler
{
    public function unsetOTPSessionVariables();
    public function handle_post_verification($WE, $wE, $MQ, $eW, $TB, $HL, $au);
    public function handle_failed_verification($wE, $MQ, $TB, $au);
    public function handleForm();
    public function handleFormOptions();
    public function getPhoneNumberSelector($sq);
    public function isLoginOrSocialForm($is);
    public function is_ajax_form_in_play($hy);
    public function getPhoneHTMLTag();
    public function getEmailHTMLTag();
    public function getBothHTMLTag();
    public function getFormKey();
    public function getFormName();
    public function getOtpTypeEnabled();
    public function disableAutoActivation();
    public function getPhoneKeyDetails();
    public function isFormEnabled();
    public function getEmailKeyDetails();
    public function getButtonText();
    public function getFormDetails();
    public function getVerificationType();
    public function getFormDocuments();
}
