<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoMessages;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
class PieRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::PIE_REG;
        $this->_typePhoneTag = "\155\x6f\x5f\x70\x69\145\x5f\x70\150\157\156\x65\x5f\x65\x6e\141\142\x6c\x65";
        $this->_typeEmailTag = "\155\157\x5f\x70\x69\x65\137\x65\155\141\x69\x6c\137\145\156\141\142\x6c\x65";
        $this->_typeBothTag = "\x6d\157\137\x70\151\x65\x5f\x62\x6f\x74\150\x5f\x65\156\x61\142\154\x65";
        $this->_formKey = "\120\111\x45\137\106\117\122\x4d";
        $this->_formName = mo_("\x50\111\105\x20\x52\145\x67\x69\x73\x74\162\141\164\151\157\156\40\x46\x6f\x72\155");
        $this->_isFormEnabled = get_mo_option("\160\151\145\137\144\145\x66\x61\165\x6c\164\137\145\156\x61\142\x6c\x65");
        $this->_formDocuments = MoOTPDocs::PIE_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\160\x69\x65\x5f\x65\x6e\141\142\x6c\145\137\x74\171\x70\x65");
        $this->_phoneKey = get_mo_option("\x70\x69\x65\137\x70\150\x6f\156\x65\x5f\x6b\x65\x79");
        $this->_phoneFormId = $this->getPhoneFieldKey();
        add_action("\160\x69\145\137\162\x65\x67\x69\x73\x74\145\162\x5f\142\145\146\x6f\x72\145\x5f\162\x65\147\151\x73\164\145\x72\x5f\x76\141\154\151\144\141\x74\x65", array($this, "\x6d\x69\156\x69\x6f\x72\x61\156\x67\145\x5f\160\151\145\137\x75\x73\145\162\x5f\162\x65\147\151\x73\164\162\141\164\x69\157\156"), 99, 1);
    }
    function isPhoneVerificationEnabled()
    {
        $CN = $this->getVerificationType();
        return $CN === VerificationType::PHONE || $CN === VerificationType::BOTH;
    }
    function miniorange_pie_user_registration()
    {
        global $errors;
        if (empty($errors->errors)) {
            goto BS;
        }
        return;
        BS:
        if (!$this->checkIfVerificationIsComplete()) {
            goto AB;
        }
        return;
        AB:
        if (!(empty($_POST[$this->_phoneFormId]) && $this->isPhoneVerificationEnabled())) {
            goto rL;
        }
        $errors->add("\x6d\x6f\137\157\164\160\137\x76\145\162\151\x66\x79", MoMessages::showMessage(MoMessages::ENTER_PHONE_DEFAULT));
        return;
        rL:
        $this->startTheOTPVerificationProcess($_POST["\145\x5f\x6d\x61\x69\x6c"], "\x2b" . $_POST[$this->_phoneFormId]);
        if ($this->checkIfVerificationIsComplete()) {
            goto tD;
        }
        $errors->add("\155\157\137\157\164\160\x5f\166\x65\162\151\146\x79", MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE));
        tD:
    }
    function checkIfVerificationIsComplete()
    {
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto CG;
        }
        $this->unsetOTPSessionVariables();
        return TRUE;
        CG:
        return FALSE;
    }
    function startTheOTPVerificationProcess($W8, $l1)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto Jw;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) == 0) {
            goto q8;
        }
        $this->sendChallenge('', $W8, null, $l1, VerificationType::EMAIL);
        goto uD;
        q8:
        $this->sendChallenge('', $W8, null, $l1, VerificationType::BOTH);
        uD:
        goto L0;
        Jw:
        $this->sendChallenge('', $W8, null, $l1, VerificationType::PHONE);
        L0:
    }
    function getPhoneFieldKey()
    {
        $aJ = get_option("\160\151\145\x5f\146\151\x65\x6c\144\x73");
        if (!empty($aJ)) {
            goto hP;
        }
        return '';
        hP:
        $K_ = maybe_unserialize($aJ);
        foreach ($K_ as $O5) {
            if (!(strcasecmp(trim($O5["\x6c\141\142\145\154"]), $this->_phoneKey) == 0)) {
                goto W1;
            }
            return str_replace("\x2d", "\137", sanitize_title($O5["\x74\x79\160\x65"] . "\137" . (isset($O5["\151\144"]) ? $O5["\x69\x64"] : '')));
            W1:
            FM:
        }
        Sg:
        return '';
    }
    function handle_failed_verification($wE, $MQ, $TB, $au)
    {
        $CN = $this->getVerificationType();
        $Ta = $CN === VerificationType::BOTH ? TRUE : FALSE;
        miniorange_site_otp_validation_form($wE, $MQ, $TB, MoUtility::_get_invalid_otp_method(), $CN, $Ta);
    }
    function handle_post_verification($WE, $wE, $MQ, $eW, $TB, $HL, $au)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $au);
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($sq)
    {
        if (!($this->isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto FX;
        }
        array_push($sq, "\151\x6e\x70\165\x74\x23" . $this->_phoneFormId);
        FX:
        return $sq;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto yW;
        }
        return;
        yW:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\160\151\145\137\144\145\146\141\165\x6c\x74\137\145\156\x61\x62\x6c\145");
        $this->_otpType = $this->sanitizeFormPOST("\160\x69\x65\137\x65\156\141\x62\x6c\x65\137\x74\x79\x70\145");
        $this->_phoneKey = $this->sanitizeFormPOST("\x70\x69\145\x5f\160\150\x6f\156\x65\x5f\146\x69\x65\x6c\x64\137\x6b\x65\171");
        update_mo_option("\160\x69\x65\x5f\144\x65\146\x61\x75\154\x74\x5f\x65\x6e\x61\142\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\x70\151\x65\x5f\145\156\141\142\154\x65\x5f\164\x79\x70\145", $this->_otpType);
        update_mo_option("\160\x69\x65\137\160\150\x6f\156\x65\x5f\153\x65\171", $this->_phoneKey);
    }
}
