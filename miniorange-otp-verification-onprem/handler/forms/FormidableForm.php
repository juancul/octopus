<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\BaseMessages;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
class FormidableForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::FORMIDABLE_FORM;
        $this->_typePhoneTag = "\x6d\157\137\x66\x72\x6d\x5f\146\x6f\x72\x6d\x5f\x70\150\x6f\156\145\137\145\156\x61\142\x6c\x65";
        $this->_typeEmailTag = "\x6d\x6f\137\x66\162\x6d\137\x66\157\162\155\137\x65\x6d\141\x69\154\x5f\145\156\141\x62\x6c\145";
        $this->_formKey = "\x46\x4f\122\x4d\111\104\x41\x42\114\x45\137\106\117\x52\x4d";
        $this->_formName = mo_("\x46\x6f\x72\155\151\x64\141\142\154\x65\x20\106\157\x72\x6d\163");
        $this->_isFormEnabled = get_mo_option("\146\x72\155\137\146\x6f\x72\155\x5f\145\156\x61\x62\x6c\145");
        $this->_buttonText = get_mo_option("\x66\x72\x6d\x5f\142\165\164\x74\157\156\137\164\145\x78\x74");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\103\x6c\x69\143\153\x20\110\145\x72\145\x20\164\x6f\40\x73\x65\156\x64\x20\x4f\x54\x50");
        $this->_generateOTPAction = "\155\151\156\151\x6f\x72\x61\156\x67\145\x5f\x66\x72\x6d\x5f\x67\x65\x6e\x65\162\x61\x74\x65\137\x6f\164\160";
        $this->_formDocuments = MoOTPDocs::FORMIDABLE_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x66\x72\x6d\x5f\146\x6f\162\x6d\x5f\x65\156\x61\x62\154\145\x5f\164\171\x70\145");
        $this->_formDetails = maybe_unserialize(get_mo_option("\x66\162\155\x5f\146\x6f\162\155\x5f\157\x74\x70\x5f\x65\x6e\141\142\154\x65\144"));
        $this->_phoneFormId = array();
        if (!(empty($this->_formDetails) || !$this->_isFormEnabled)) {
            goto uO;
        }
        return;
        uO:
        foreach ($this->_formDetails as $O5 => $Xd) {
            array_push($this->_phoneFormId, "\x23" . $Xd["\x70\x68\157\x6e\145\153\145\171"] . "\40\151\156\x70\x75\164");
            d2:
        }
        Io:
        add_filter("\146\162\155\137\x76\x61\x6c\x69\x64\141\164\145\137\146\x69\145\x6c\x64\137\x65\156\164\162\x79", array($this, "\x6d\151\156\x69\x6f\162\141\x6e\x67\145\x5f\157\x74\x70\137\x76\141\154\151\x64\x61\x74\151\157\x6e"), 11, 4);
        add_action("\167\160\x5f\x61\x6a\x61\170\137{$this->_generateOTPAction}", array($this, "\137\x73\145\156\x64\137\x6f\x74\160\x5f\146\162\x6d\x5f\x61\152\141\x78"));
        add_action("\167\x70\137\x61\x6a\x61\x78\137\156\157\x70\x72\151\166\137{$this->_generateOTPAction}", array($this, "\137\x73\x65\156\144\137\157\x74\160\137\146\162\155\137\x61\152\x61\x78"));
        add_action("\167\160\x5f\x65\x6e\161\x75\x65\x75\x65\137\x73\x63\x72\151\160\164\163", array($this, "\155\x69\x6e\x69\x6f\x72\141\156\147\145\x5f\x72\x65\147\151\163\x74\x65\x72\x5f\146\x6f\x72\155\x69\144\141\x62\x6c\145\x5f\x73\143\x72\151\x70\164"));
    }
    function miniorange_register_formidable_script()
    {
        wp_register_script("\155\157\146\x6f\x72\155\151\x64\x61\x62\154\x65", MOV_URL . "\x69\156\x63\154\x75\x64\x65\163\x2f\x6a\x73\x2f\146\x6f\x72\x6d\x69\x64\141\142\154\145\x2e\155\151\x6e\56\x6a\163", array("\152\x71\x75\x65\x72\x79"));
        wp_localize_script("\x6d\157\x66\157\162\x6d\151\144\141\x62\x6c\x65", "\x6d\x6f\x66\x6f\x72\155\151\x64\x61\x62\154\145", array("\163\151\164\145\x55\122\114" => wp_ajax_url(), "\x6f\164\160\x54\x79\160\145" => $this->_otpType, "\x66\x6f\x72\155\x6b\x65\171" => strcasecmp($this->_otpType, $this->_typePhoneTag) == 0 ? "\160\150\157\x6e\145\x6b\x65\x79" : "\x65\x6d\141\151\154\153\x65\x79", "\x6e\x6f\156\x63\145" => wp_create_nonce($this->_nonce), "\142\x75\164\164\x6f\156\x74\145\170\x74" => mo_($this->_buttonText), "\x69\x6d\x67\x55\122\x4c" => MOV_LOADER_URL, "\x66\x6f\162\x6d\x73" => $this->_formDetails, "\147\145\156\145\x72\x61\x74\145\x55\x52\114" => $this->_generateOTPAction));
        wp_enqueue_script("\155\157\146\x6f\x72\155\151\x64\x61\x62\154\x65");
    }
    function _send_otp_frm_ajax()
    {
        $this->validateAjaxRequest();
        if ($this->_otpType == $this->_typePhoneTag) {
            goto NM;
        }
        $this->_send_frm_otp_to_email($_POST);
        goto sB;
        NM:
        $this->_send_frm_otp_to_phone($_POST);
        sB:
    }
    function _send_frm_otp_to_phone($tT)
    {
        if (!MoUtility::sanitizeCheck("\165\x73\145\162\x5f\160\x68\157\x6e\x65", $tT)) {
            goto hn;
        }
        $this->sendOTP(trim($tT["\x75\x73\x65\162\137\160\x68\x6f\156\x65"]), NULL, trim($tT["\x75\x73\x65\x72\137\160\x68\157\x6e\145"]), VerificationType::PHONE);
        goto wm;
        hn:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        wm:
    }
    function _send_frm_otp_to_email($tT)
    {
        if (!MoUtility::sanitizeCheck("\165\x73\x65\x72\137\145\x6d\x61\x69\x6c", $tT)) {
            goto Sk;
        }
        $this->sendOTP($tT["\165\x73\145\162\137\x65\155\x61\151\154"], $tT["\x75\163\x65\162\x5f\145\155\x61\x69\x6c"], NULL, VerificationType::EMAIL);
        goto Ov;
        Sk:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        Ov:
    }
    private function sendOTP($Jx, $W8, $ZI, $au)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if ($au === VerificationType::PHONE) {
            goto D3;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $Jx);
        goto uP;
        D3:
        SessionUtils::addPhoneVerified($this->_formSessionVar, $Jx);
        uP:
        $this->sendChallenge('', $W8, NULL, $ZI, $au);
    }
    function miniorange_otp_validation($errors, $DH, $Xd, $Kc)
    {
        if (!($this->getFieldId("\166\145\162\x69\146\171\x5f\163\150\x6f\167", $DH) !== $DH->id)) {
            goto eN;
        }
        return $errors;
        eN:
        if (MoUtility::isBlank($errors)) {
            goto zB;
        }
        return $errors;
        zB:
        if ($this->hasOTPBeenSent($errors, $DH)) {
            goto Cz;
        }
        return $errors;
        Cz:
        if (!$this->isMisMatchEmailOrPhone($errors, $DH)) {
            goto tH;
        }
        return $errors;
        tH:
        if ($this->isValidOTP($Xd, $DH, $errors)) {
            goto oK;
        }
        return $errors;
        oK:
        return $errors;
    }
    private function hasOTPBeenSent(&$errors, $DH)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto dF;
        }
        $Tg = MoMessages::showMessage(BaseMessages::ENTER_VERIFY_CODE);
        if ($this->isPhoneVerificationEnabled()) {
            goto RB;
        }
        $errors["\x66\151\x65\x6c\x64" . $this->getFieldId("\x65\155\141\151\x6c\x5f\163\150\157\x77", $DH)] = $Tg;
        goto Co;
        RB:
        $errors["\x66\x69\x65\x6c\x64" . $this->getFieldId("\x70\150\157\156\145\137\163\x68\x6f\167", $DH)] = $Tg;
        Co:
        return false;
        dF:
        return true;
    }
    private function isMisMatchEmailOrPhone(&$errors, $DH)
    {
        $rq = $this->getFieldId($this->isPhoneVerificationEnabled() ? "\160\x68\x6f\x6e\x65\137\x73\x68\157\167" : "\x65\x6d\x61\x69\154\137\x73\x68\x6f\x77", $DH);
        $dF = $_POST["\x69\164\x65\155\x5f\155\145\x74\141"][$rq];
        if ($this->checkPhoneOrEmailIntegrity($dF)) {
            goto xG;
        }
        if ($this->isPhoneVerificationEnabled()) {
            goto EC;
        }
        $errors["\x66\x69\145\x6c\x64" . $this->getFieldId("\x65\x6d\x61\151\154\137\163\x68\157\x77", $DH)] = MoMessages::showMessage(BaseMessages::EMAIL_MISMATCH);
        goto Ys;
        EC:
        $errors["\x66\x69\145\154\144" . $this->getFieldId("\x70\x68\157\156\145\x5f\x73\x68\x6f\x77", $DH)] = MoMessages::showMessage(BaseMessages::PHONE_MISMATCH);
        Ys:
        return true;
        xG:
        return false;
    }
    private function isValidOTP($Xd, $DH, &$errors)
    {
        $au = $this->getVerificationType();
        $this->validateChallenge($au, NULL, $Xd);
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $au)) {
            goto P6;
        }
        $errors["\146\x69\145\x6c\x64" . $this->getFieldId("\x76\145\x72\151\x66\x79\x5f\x73\x68\x6f\167", $DH)] = MoUtility::_get_invalid_otp_method();
        return false;
        goto UU;
        P6:
        $this->unsetOTPSessionVariables();
        return true;
        UU:
    }
    private function checkPhoneOrEmailIntegrity($dF)
    {
        if ($this->isPhoneVerificationEnabled()) {
            goto Ff;
        }
        return SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $dF);
        goto L8;
        Ff:
        return SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $dF);
        L8:
    }
    function handle_failed_verification($wE, $MQ, $TB, $au)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VERIFICATION_FAILED, $au);
    }
    function handle_post_verification($WE, $wE, $MQ, $eW, $TB, $HL, $au)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $au);
    }
    function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($sq)
    {
        if (!($this->_isFormEnabled && $this->isPhoneVerificationEnabled())) {
            goto Bo;
        }
        $sq = array_merge($sq, $this->_phoneFormId);
        Bo:
        return $sq;
    }
    function isPhoneVerificationEnabled()
    {
        return $this->getVerificationType() === VerificationType::PHONE;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto gR;
        }
        return;
        gR:
        $form = $this->parseFormDetails();
        $this->_isFormEnabled = $this->sanitizeFormPOST("\146\x72\x6d\x5f\146\x6f\162\155\x5f\145\156\x61\142\154\145");
        $this->_otpType = $this->sanitizeFormPOST("\x66\x72\155\x5f\x66\157\x72\x6d\137\x65\x6e\x61\x62\154\145\137\164\x79\160\x65");
        $this->_formDetails = !empty($form) ? $form : '';
        $this->_buttonText = $this->sanitizeFormPOST("\146\162\155\137\142\x75\164\164\x6f\156\137\x74\x65\170\164");
        if (!$this->basicValidationCheck(BaseMessages::FORMIDABLE_CHOOSE)) {
            goto Vs;
        }
        update_mo_option("\146\x72\155\137\142\x75\x74\x74\x6f\156\137\164\145\x78\164", $this->_buttonText);
        update_mo_option("\x66\x72\x6d\x5f\146\x6f\162\x6d\137\145\x6e\141\x62\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\x66\162\x6d\x5f\146\x6f\162\x6d\137\145\156\x61\142\154\x65\137\x74\x79\x70\145", $this->_otpType);
        update_mo_option("\x66\162\x6d\x5f\146\x6f\x72\155\x5f\157\164\x70\137\x65\156\141\142\154\145\x64", maybe_serialize($this->_formDetails));
        Vs:
    }
    function parseFormDetails()
    {
        $form = array();
        if (array_key_exists("\146\x72\155\x5f\x66\x6f\162\x6d", $_POST)) {
            goto Pi;
        }
        return array();
        Pi:
        foreach (array_filter($_POST["\146\x72\155\x5f\146\x6f\162\155"]["\146\157\162\155"]) as $O5 => $Xd) {
            $form[$Xd] = array("\x65\155\141\x69\x6c\x6b\145\x79" => "\146\162\155\137\146\x69\145\x6c\144\137" . $_POST["\x66\162\155\137\146\157\162\155"]["\145\x6d\x61\151\154\153\x65\171"][$O5] . "\x5f\x63\157\156\164\x61\x69\156\145\162", "\x70\150\x6f\x6e\x65\x6b\x65\x79" => "\x66\162\x6d\137\x66\151\145\x6c\144\137" . $_POST["\146\162\x6d\137\x66\157\x72\x6d"]["\160\150\157\156\x65\x6b\x65\171"][$O5] . "\x5f\143\x6f\x6e\x74\x61\x69\156\x65\x72", "\x76\145\162\151\x66\171\x4b\x65\171" => "\x66\162\x6d\137\146\151\145\154\144\x5f" . $_POST["\x66\x72\155\137\x66\x6f\162\x6d"]["\166\145\x72\151\x66\171\x4b\x65\171"][$O5] . "\137\143\x6f\x6e\x74\x61\151\x6e\145\162", "\x70\x68\x6f\x6e\145\137\x73\x68\x6f\167" => $_POST["\146\x72\155\137\x66\157\x72\x6d"]["\x70\x68\x6f\156\145\153\145\x79"][$O5], "\x65\155\x61\151\154\137\x73\x68\x6f\x77" => $_POST["\x66\162\155\137\x66\157\x72\155"]["\x65\155\x61\x69\x6c\x6b\x65\x79"][$O5], "\166\145\x72\151\146\x79\x5f\163\150\x6f\x77" => $_POST["\146\x72\155\x5f\x66\157\162\x6d"]["\x76\145\162\x69\x66\171\113\145\x79"][$O5]);
            ow:
        }
        ut:
        return $form;
    }
    function getFieldId($O5, $DH)
    {
        return $this->_formDetails[$DH->form_id][$O5];
    }
}
