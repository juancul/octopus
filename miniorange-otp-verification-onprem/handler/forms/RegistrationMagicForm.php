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
class RegistrationMagicForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::CRF_DEFAULT_REG;
        $this->_typePhoneTag = "\155\x6f\x5f\143\162\146\137\160\x68\x6f\156\145\137\145\x6e\x61\x62\154\x65";
        $this->_typeEmailTag = "\155\157\137\143\162\x66\137\145\155\141\151\154\x5f\x65\x6e\141\142\x6c\145";
        $this->_typeBothTag = "\155\x6f\x5f\x63\162\146\137\142\157\x74\150\137\145\x6e\141\142\154\145";
        $this->_formKey = "\103\x52\x46\137\x46\x4f\122\115";
        $this->_formName = mo_("\x43\x75\x73\164\x6f\155\x20\x55\163\145\162\40\x52\145\x67\x69\163\x74\x72\141\164\151\x6f\x6e\40\x46\x6f\162\x6d\x20\102\x75\x69\x6c\x64\145\x72\x20\x28\122\x65\x67\x69\x73\x74\x72\141\x74\151\x6f\x6e\40\115\141\147\x69\143\51");
        $this->_isFormEnabled = get_mo_option("\143\162\146\137\x64\x65\x66\141\165\x6c\x74\137\145\156\x61\x62\154\145");
        $this->_phoneFormId = array();
        $this->_formDocuments = MoOTPDocs::CRF_FORM_ENABLE;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x63\162\146\x5f\145\x6e\141\x62\x6c\145\x5f\164\x79\x70\x65");
        $this->_formDetails = maybe_unserialize(get_mo_option("\x63\x72\146\137\157\x74\160\137\x65\x6e\141\142\154\x65\144"));
        if (!empty($this->_formDetails)) {
            goto u_;
        }
        return;
        u_:
        foreach ($this->_formDetails as $O5 => $Xd) {
            array_push($this->_phoneFormId, "\x69\x6e\x70\x75\x74\x5b\x6e\x61\x6d\145\x3d" . $this->getFieldID($Xd["\x70\150\157\x6e\x65\153\145\x79"], $O5) . "\135");
            ur:
        }
        MK:
        if ($this->checkIfPromptForOTP()) {
            goto X8;
        }
        return;
        X8:
        $this->_handle_crf_form_submit($_REQUEST);
    }
    private function checkIfPromptForOTP()
    {
        if (!(array_key_exists("\x6f\160\x74\x69\x6f\x6e", $_POST) || !array_key_exists("\162\155\137\146\x6f\x72\x6d\x5f\x73\165\142\137\x69\144", $_POST))) {
            goto iq;
        }
        return FALSE;
        iq:
        foreach ($this->_formDetails as $O5 => $Xd) {
            if (!(strpos($_POST["\162\x6d\x5f\146\x6f\x72\155\x5f\163\165\142\137\151\x64"], "\146\x6f\162\155\x5f" . $O5 . "\137") !== FALSE)) {
                goto kQ;
            }
            MoUtility::initialize_transaction($this->_formSessionVar);
            SessionUtils::setFormOrFieldId($this->_formSessionVar, $O5);
            return TRUE;
            kQ:
            UD:
        }
        Mm:
        return FALSE;
    }
    private function isPhoneVerificationEnabled()
    {
        $CN = $this->getVerificationType();
        return $CN === VerificationType::PHONE || $CN === VerificationType::BOTH;
    }
    private function isEmailVerificationEnabled()
    {
        $CN = $this->getVerificationType();
        return $CN === VerificationType::EMAIL || $CN === VerificationType::BOTH;
    }
    private function _handle_crf_form_submit($gz)
    {
        $Vy = $this->isEmailVerificationEnabled() ? $this->getCRFEmailFromRequest($gz) : '';
        $l1 = $this->isPhoneVerificationEnabled() ? $this->getCRFPhoneFromRequest($gz) : '';
        $this->miniorange_crf_user($Vy, isset($gz["\x75\x73\x65\x72\137\156\141\155\145"]) ? $gz["\x75\163\145\x72\137\x6e\x61\x6d\x65"] : NULL, $l1);
        $this->checkIfValidated();
    }
    private function checkIfValidated()
    {
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto GC;
        }
        $this->unsetOTPSessionVariables();
        GC:
    }
    private function getCRFEmailFromRequest($gz)
    {
        $mA = SessionUtils::getFormOrFieldId($this->_formSessionVar);
        $a4 = $this->_formDetails[$mA]["\x65\x6d\141\151\x6c\x6b\x65\x79"];
        return $this->getFormPostSubmittedValue($this->getFieldID($a4, $mA), $gz);
    }
    private function getCRFPhoneFromRequest($gz)
    {
        $mA = SessionUtils::getFormOrFieldId($this->_formSessionVar);
        $rT = $this->_formDetails[$mA]["\x70\150\157\x6e\x65\x6b\x65\x79"];
        return $this->getFormPostSubmittedValue($this->getFieldID($rT, $mA), $gz);
    }
    private function getFormPostSubmittedValue($Hn, $gz)
    {
        return isset($gz[$Hn]) ? $gz[$Hn] : '';
    }
    private function getFieldID($O5, $tb)
    {
        global $wpdb;
        $jO = $wpdb->prefix . "\x72\x6d\137\x66\151\145\x6c\x64\x73";
        $fM = $wpdb->get_row("\x53\x45\114\105\103\124\40\x2a\40\106\x52\x4f\x4d\40{$jO}\x20\167\150\145\162\x65\x20\146\157\x72\155\x5f\x69\144\x20\75\40\x27" . $tb . "\47\40\141\156\144\x20\146\x69\145\x6c\144\137\x6c\x61\x62\x65\x6c\40\75\47" . $O5 . "\x27");
        return isset($fM) ? ($fM->field_type == "\115\157\142\x69\x6c\145" ? "\x54\145\170\164\142\157\x78" : $fM->field_type) . "\x5f" . $fM->field_id : "\x6e\x75\154\x6c";
    }
    private function miniorange_crf_user($MQ, $uK, $TB)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        $errors = new WP_Error();
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto yY;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) == 0) {
            goto MT;
        }
        $this->sendChallenge($uK, $MQ, $errors, $TB, VerificationType::EMAIL);
        goto iP;
        MT:
        $this->sendChallenge($uK, $MQ, $errors, $TB, VerificationType::BOTH);
        iP:
        goto od;
        yY:
        $this->sendChallenge($uK, $MQ, $errors, $TB, VerificationType::PHONE);
        od:
    }
    function handle_failed_verification($wE, $MQ, $TB, $au)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto E9;
        }
        return;
        E9:
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
            goto nj;
        }
        $sq = array_merge($sq, $this->_phoneFormId);
        nj:
        return $sq;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto uz;
        }
        return;
        uz:
        $form = $this->parseFormDetails();
        $this->_formDetails = !empty($form) ? $form : '';
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x63\x72\146\137\x64\145\x66\x61\165\154\164\x5f\x65\x6e\x61\x62\154\145");
        $this->_otpType = $this->sanitizeFormPOST("\143\162\x66\137\145\156\x61\142\x6c\145\x5f\164\171\160\145");
        update_mo_option("\143\162\146\137\144\x65\x66\x61\165\154\164\137\145\x6e\141\x62\x6c\145", $this->_isFormEnabled);
        update_mo_option("\x63\162\146\x5f\145\x6e\x61\142\154\145\x5f\164\171\x70\145", $this->_otpType);
        update_mo_option("\143\162\x66\x5f\x6f\164\x70\137\145\x6e\x61\142\154\145\144", maybe_serialize($this->_formDetails));
    }
    function parseFormDetails()
    {
        $form = array();
        if (!(!array_key_exists("\143\162\x66\137\x66\x6f\x72\x6d", $_POST) && empty($_POST["\143\x72\x66\137\146\157\162\x6d"]["\x66\x6f\x72\155"]))) {
            goto dT;
        }
        return $form;
        dT:
        foreach (array_filter($_POST["\143\162\146\137\146\157\162\x6d"]["\x66\x6f\162\x6d"]) as $O5 => $Xd) {
            $form[$Xd] = array("\x65\155\141\151\x6c\153\x65\x79" => $_POST["\143\162\x66\x5f\146\157\162\155"]["\145\155\141\151\x6c\153\x65\x79"][$O5], "\x70\x68\157\x6e\x65\x6b\x65\x79" => $_POST["\143\x72\x66\137\x66\x6f\162\155"]["\x70\150\157\156\x65\153\145\x79"][$O5], "\145\x6d\x61\x69\154\x5f\x73\x68\x6f\167" => $_POST["\x63\162\x66\x5f\x66\x6f\162\x6d"]["\145\155\141\x69\x6c\153\145\x79"][$O5], "\x70\x68\x6f\x6e\x65\137\x73\150\157\x77" => $_POST["\x63\162\x66\x5f\x66\157\162\155"]["\x70\x68\x6f\156\x65\153\145\x79"][$O5]);
            PD:
        }
        t2:
        return $form;
    }
}
