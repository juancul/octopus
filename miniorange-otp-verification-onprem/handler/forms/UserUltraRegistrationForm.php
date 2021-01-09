<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
use XooUserRegister;
use XooUserRegisterLite;
class UserUltraRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::UULTRA_REG;
        $this->_typePhoneTag = "\x6d\157\137\165\x75\154\164\162\x61\x5f\x70\x68\157\x6e\145\x5f\145\156\141\x62\x6c\x65";
        $this->_typeEmailTag = "\x6d\157\x5f\x75\x75\x6c\164\x72\141\137\145\155\141\x69\x6c\137\x65\156\141\142\154\x65";
        $this->_typeBothTag = "\x6d\157\137\165\165\x6c\164\162\x61\x5f\x62\157\164\x68\137\x65\156\x61\x62\x6c\x65";
        $this->_formKey = "\125\x55\x4c\x54\x52\x41\137\106\x4f\x52\115";
        $this->_formName = mo_("\x55\163\x65\x72\x20\125\x6c\x74\x72\x61\x20\122\145\x67\x69\163\x74\x72\x61\x74\x69\157\156\x20\x46\157\162\155");
        $this->_isFormEnabled = get_mo_option("\x75\165\x6c\x74\162\x61\x5f\x64\145\x66\x61\x75\154\164\x5f\x65\x6e\141\142\x6c\145");
        $this->_formDocuments = MoOTPDocs::UULTRA_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_phoneKey = get_mo_option("\x75\165\x6c\164\162\x61\137\x70\x68\157\156\x65\137\153\145\171");
        $this->_otpType = get_mo_option("\165\x75\154\164\x72\x61\x5f\x65\x6e\141\142\x6c\x65\137\x74\x79\160\x65");
        $this->_phoneFormId = "\x69\156\160\x75\164\133\x6e\x61\155\145\75" . $this->_phoneKey . "\135";
        $CN = $this->getVerificationType();
        if (MoUtility::sanitizeCheck("\x78\x6f\157\165\163\145\162\165\154\164\x72\141\x2d\x72\145\147\151\x73\x74\145\x72\55\146\157\x72\x6d", $_POST)) {
            goto t3;
        }
        return;
        t3:
        $l1 = $this->isPhoneVerificationEnabled() ? $_POST[$this->_phoneKey] : NULL;
        $this->_handle_uultra_form_submit($_POST["\x75\x73\145\x72\137\154\157\x67\151\x6e"], $_POST["\x75\x73\145\x72\x5f\x65\x6d\141\151\154"], $l1);
    }
    function isPhoneVerificationEnabled()
    {
        $CN = $this->getVerificationType();
        return $CN == VerificationType::PHONE || $CN === VerificationType::BOTH;
    }
    function _handle_uultra_form_submit($uK, $MQ, $l1)
    {
        $xE = class_exists("\130\157\157\125\163\x65\x72\122\x65\147\x69\x73\x74\145\x72\114\151\164\145") ? new XooUserRegisterLite() : new XooUserRegister();
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto hL;
        }
        return;
        hL:
        $xE->uultra_prepare_request($_POST);
        $xE->uultra_handle_errors();
        if (!MoUtility::isBlank($xE->errors)) {
            goto N7;
        }
        $_POST["\x6e\157\x5f\x63\141\x70\x74\143\x68\x61"] = "\171\x65\163";
        $this->_handle_otp_verification_uultra($uK, $MQ, null, $l1);
        N7:
        return;
    }
    function _handle_otp_verification_uultra($uK, $MQ, $errors, $l1)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto qp;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) == 0) {
            goto O5;
        }
        $this->sendChallenge($uK, $MQ, $errors, $l1, VerificationType::EMAIL);
        goto tv;
        O5:
        $this->sendChallenge($uK, $MQ, $errors, $l1, VerificationType::BOTH);
        tv:
        goto yR;
        qp:
        $this->sendChallenge($uK, $MQ, $errors, $l1, VerificationType::PHONE);
        yR:
    }
    function handle_failed_verification($wE, $MQ, $TB, $au)
    {
        $CN = $this->getVerificationType();
        $Ta = $CN === VerificationType::BOTH ? TRUE : FALSE;
        miniorange_site_otp_validation_form($wE, $MQ, $TB, MoUtility::_get_invalid_otp_method(), $CN, $Ta);
    }
    function handle_post_verification($WE, $wE, $MQ, $eW, $TB, $HL, $au)
    {
        $this->unsetOTPSessionVariables();
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($sq)
    {
        if (!($this->isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto Pw;
        }
        array_push($sq, $this->_phoneFormId);
        Pw:
        return $sq;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto fK;
        }
        return;
        fK:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\165\165\x6c\x74\162\x61\137\x64\145\x66\141\165\x6c\x74\x5f\145\x6e\x61\x62\x6c\x65");
        $this->_otpType = $this->sanitizeFormPOST("\165\x75\154\164\162\x61\x5f\x65\156\141\142\154\x65\x5f\x74\171\160\145");
        $this->_phoneKey = $this->sanitizeFormPOST("\x75\165\154\x74\162\x61\x5f\x70\x68\x6f\x6e\145\137\x66\x69\145\154\144\137\x6b\145\171");
        update_mo_option("\x75\x75\x6c\x74\x72\141\x5f\144\x65\x66\141\165\x6c\164\x5f\x65\156\141\142\154\145", $this->_isFormEnabled);
        update_mo_option("\x75\x75\154\x74\162\x61\137\x65\156\x61\x62\x6c\x65\137\x74\171\x70\145", $this->_otpType);
        update_mo_option("\x75\165\x6c\164\162\x61\x5f\x70\150\x6f\x6e\x65\137\x6b\145\171", $this->_phoneKey);
    }
}
