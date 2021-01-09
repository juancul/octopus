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
use WP_Error;
class WpEmemberForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::EMEMBER;
        $this->_typePhoneTag = "\x6d\157\x5f\145\155\145\x6d\142\145\162\x5f\160\x68\157\x6e\x65\x5f\x65\156\141\142\x6c\145";
        $this->_typeEmailTag = "\x6d\x6f\137\x65\155\x65\x6d\142\x65\x72\137\145\x6d\141\151\154\137\145\x6e\x61\142\x6c\145";
        $this->_typeBothTag = "\155\x6f\x5f\145\155\145\x6d\x62\145\162\x5f\x62\x6f\164\150\x5f\x65\156\141\x62\154\x65";
        $this->_formKey = "\x57\120\137\x45\x4d\105\115\102\x45\x52";
        $this->_formName = mo_("\127\120\x20\x65\x4d\145\155\142\145\x72");
        $this->_isFormEnabled = get_mo_option("\x65\x6d\145\x6d\x62\145\x72\x5f\144\145\146\x61\165\x6c\164\x5f\x65\156\141\x62\x6c\145");
        $this->_phoneKey = "\167\160\x5f\x65\155\145\x6d\142\x65\162\x5f\160\150\x6f\156\145";
        $this->_phoneFormId = "\x69\156\160\x75\x74\x5b\x6e\141\155\145\75" . $this->_phoneKey . "\x5d";
        $this->_formDocuments = MoOTPDocs::EMEMBER_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\145\155\145\155\x62\x65\x72\x5f\145\x6e\141\142\x6c\x65\x5f\x74\x79\160\x65");
        if (!(array_key_exists("\145\155\x65\155\142\145\x72\x5f\x64\163\143\x5f\x6e\x6f\156\143\145", $_POST) && !array_key_exists("\157\160\x74\x69\157\x6e", $_POST))) {
            goto XY;
        }
        $this->miniorange_emember_user_registration();
        XY:
    }
    function isPhoneVerificationEnabled()
    {
        $au = $this->getVerificationType();
        return $au === VerificationType::PHONE || $au === VerificationType::BOTH;
    }
    function miniorange_emember_user_registration()
    {
        if (!$this->validatePostFields()) {
            goto c9;
        }
        $l1 = array_key_exists($this->_phoneKey, $_POST) ? $_POST[$this->_phoneKey] : NULL;
        $this->startTheOTPVerificationProcess($_POST["\167\x70\137\145\155\145\155\142\145\162\x5f\165\x73\x65\x72\x5f\x6e\141\155\x65"], $_POST["\x77\x70\x5f\145\x6d\145\x6d\142\x65\162\x5f\x65\x6d\141\151\154"], $l1);
        c9:
    }
    function startTheOTPVerificationProcess($EN, $W8, $l1)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        $errors = new WP_Error();
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0) {
            goto LI;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) === 0) {
            goto Rh;
        }
        $this->sendChallenge($EN, $W8, $errors, $l1, VerificationType::EMAIL);
        goto EQ;
        Rh:
        $this->sendChallenge($EN, $W8, $errors, $l1, VerificationType::BOTH);
        EQ:
        goto cW;
        LI:
        $this->sendChallenge($EN, $W8, $errors, $l1, VerificationType::PHONE);
        cW:
    }
    function handle_failed_verification($wE, $MQ, $TB, $au)
    {
        $CN = $this->getVerificationType();
        $Ta = $CN === VerificationType::BOTH ? TRUE : FALSE;
        miniorange_site_otp_validation_form($wE, $MQ, $TB, MoUtility::_get_invalid_otp_method(), $CN, $Ta);
    }
    function validatePostFields()
    {
        if (!is_blocked_ip(get_real_ip_addr())) {
            goto cj;
        }
        return FALSE;
        cj:
        if (!(emember_wp_username_exists($_POST["\167\160\x5f\145\155\145\x6d\x62\x65\162\x5f\165\x73\x65\162\137\x6e\141\155\x65"]) || emember_username_exists($_POST["\167\160\x5f\145\155\x65\x6d\x62\x65\x72\x5f\165\163\145\x72\x5f\156\141\155\x65"]))) {
            goto Fm;
        }
        return FALSE;
        Fm:
        if (!(is_blocked_email($_POST["\167\x70\137\145\x6d\x65\155\x62\x65\162\137\x65\155\141\151\154"]) || emember_registered_email_exists($_POST["\167\x70\137\145\155\145\x6d\142\145\x72\137\145\155\x61\x69\x6c"]) || emember_wp_email_exists($_POST["\167\x70\x5f\x65\x6d\145\x6d\142\x65\x72\x5f\145\x6d\x61\x69\x6c"]))) {
            goto R_;
        }
        return FALSE;
        R_:
        if (!(isset($_POST["\145\115\x65\155\x62\145\162\x5f\122\145\147\151\x73\164\145\162"]) && array_key_exists("\167\160\137\145\x6d\145\x6d\x62\145\162\x5f\x70\167\x64\x5f\x72\x65", $_POST) && $_POST["\x77\x70\x5f\x65\x6d\x65\x6d\142\145\x72\137\x70\167\x64"] != $_POST["\167\160\x5f\x65\x6d\145\x6d\x62\x65\162\x5f\160\x77\144\x5f\x72\x65"])) {
            goto F3;
        }
        return FALSE;
        F3:
        return TRUE;
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
            goto uN;
        }
        array_push($sq, $this->_phoneFormId);
        uN:
        return $sq;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto O1;
        }
        return;
        O1:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x65\x6d\145\155\x62\145\x72\137\x64\145\x66\x61\165\154\164\x5f\145\x6e\x61\142\x6c\x65");
        $this->_otpType = $this->sanitizeFormPOST("\145\155\x65\x6d\142\145\x72\137\x65\156\141\142\154\x65\137\164\x79\160\x65");
        update_mo_option("\145\x6d\x65\155\x62\145\162\x5f\144\145\x66\x61\165\154\164\x5f\145\156\x61\x62\154\x65", $this->_isFormEnabled);
        update_mo_option("\145\x6d\x65\155\142\x65\162\137\145\x6e\x61\142\x6c\145\137\x74\171\x70\145", $this->_otpType);
    }
}
