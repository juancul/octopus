<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationLogic;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
use WP_Error;
class WooCommerceProductVendors extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_formSessionVar = FormSessionVars::WC_PRODUCT_VENDOR;
        $this->_isAjaxForm = TRUE;
        $this->_typePhoneTag = "\x6d\157\x5f\167\143\137\160\166\x5f\x70\x68\x6f\156\x65\x5f\x65\x6e\141\x62\x6c\145";
        $this->_typeEmailTag = "\155\157\137\x77\143\x5f\160\166\x5f\145\x6d\x61\x69\154\x5f\x65\x6e\x61\142\154\145";
        $this->_phoneFormId = "\x23\x72\x65\x67\x5f\x62\x69\x6c\x6c\151\x6e\x67\137\160\150\x6f\156\x65";
        $this->_formKey = "\127\x43\x5f\x50\x56\x5f\x52\105\x47\x5f\x46\117\x52\x4d";
        $this->_formName = mo_("\x57\157\x6f\x63\157\155\x6d\145\162\x63\145\40\x50\162\x6f\x64\165\143\164\x20\126\145\x6e\x64\x6f\x72\x20\x52\145\x67\x69\163\164\162\141\164\x69\157\x6e\x20\x46\157\x72\155");
        $this->_isFormEnabled = get_mo_option("\x77\143\137\160\166\137\144\145\146\141\165\154\x74\x5f\145\x6e\141\142\x6c\x65");
        $this->_buttonText = get_mo_option("\167\143\x5f\x70\166\137\x62\x75\x74\x74\x6f\x6e\137\164\x65\170\x74");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\x43\x6c\151\143\x6b\40\x48\145\x72\x65\x20\x74\x6f\40\163\145\x6e\x64\x20\117\124\120");
        $this->_formDocuments = MoOTPDocs::WC_PRODUCT_VENDOR;
        parent::__construct();
    }
    public function handleForm()
    {
        $this->_otpType = get_mo_option("\x77\x63\x5f\x70\166\x5f\145\156\141\x62\154\x65\137\164\171\160\x65");
        $this->_restrictDuplicates = get_mo_option("\x77\143\x5f\160\166\x5f\x72\145\x73\x74\x72\x69\x63\164\x5f\144\165\160\154\x69\x63\x61\164\145\x73");
        add_action("\167\x63\160\166\137\162\x65\147\x69\163\164\x72\141\x74\x69\157\x6e\x5f\146\157\162\155", array($this, "\155\157\x5f\x61\144\x64\x5f\x70\150\x6f\156\x65\137\146\151\145\x6c\x64"), 1);
        add_action("\167\x70\137\141\x6a\x61\x78\137\156\157\x70\x72\x69\166\137\155\x69\x6e\151\x6f\162\141\x6e\x67\x65\x5f\167\143\x5f\x76\x70\x5f\162\x65\147\137\166\x65\x72\151\x66\x79", array($this, "\x73\145\x6e\144\101\152\141\170\117\x54\120\x52\x65\x71\165\145\x73\x74"));
        add_filter("\x77\143\160\166\137\163\150\157\x72\164\143\x6f\144\x65\137\x72\x65\147\x69\163\x74\162\141\x74\151\157\156\x5f\146\157\x72\155\137\x76\141\x6c\x69\x64\x61\x74\151\157\156\x5f\145\162\x72\157\162\x73", array($this, "\x72\x65\x67\x5f\x66\151\145\x6c\x64\x73\x5f\x65\x72\x72\x6f\162\x73"), 1, 2);
        add_action("\167\160\137\x65\156\161\165\x65\x75\145\x5f\163\x63\x72\151\160\164\x73", array($this, "\155\151\156\151\157\x72\141\x6e\x67\x65\x5f\162\145\x67\151\163\x74\145\x72\x5f\167\143\x5f\x73\x63\162\151\160\164"));
    }
    public function sendAjaxOTPRequest()
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        $this->validateAjaxRequest();
        $Pn = MoUtility::sanitizeCheck("\x75\x73\145\162\137\160\x68\157\156\145", $_POST);
        $MQ = MoUtility::sanitizeCheck("\165\163\x65\162\137\145\x6d\141\151\154", $_POST);
        if ($this->_otpType === $this->_typePhoneTag) {
            goto EH;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $MQ);
        goto Og;
        EH:
        SessionUtils::addPhoneVerified($this->_formSessionVar, MoUtility::processPhoneNumber($Pn));
        Og:
        $zu = $this->processFormFields(null, $MQ, new WP_Error(), null, $Pn);
        if (!$zu->get_error_code()) {
            goto Es;
        }
        wp_send_json(MoUtility::createJson($zu->get_error_message(), MoConstants::ERROR_JSON_TYPE));
        Es:
    }
    public function reg_fields_errors($errors, $Qd)
    {
        if (empty($errors)) {
            goto GO;
        }
        return $errors;
        GO:
        $this->assertOTPField($errors, $Qd);
        $this->checkIfOTPWasSent($errors);
        return $this->checkIntegrityAndValidateOTP($Qd, $errors);
    }
    private function assertOTPField(&$errors, $Qd)
    {
        if (MoUtility::sanitizeCheck("\x6d\157\166\x65\x72\151\x66\171", $Qd)) {
            goto VM;
        }
        $errors[] = MoMessages::showMessage(MoMessages::REQUIRED_OTP);
        VM:
    }
    private function checkIfOTPWasSent(&$errors)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto L2;
        }
        $errors[] = MoMessages::showMessage(MoMessages::PLEASE_VALIDATE);
        L2:
    }
    private function checkIntegrityAndValidateOTP($tT, array $errors)
    {
        if (empty($errors)) {
            goto MQ;
        }
        return $errors;
        MQ:
        $tT["\142\151\154\154\151\x6e\147\137\160\150\x6f\x6e\x65"] = MoUtility::processPhoneNumber($tT["\x62\x69\154\x6c\x69\156\147\137\x70\x68\x6f\156\145"]);
        $errors = $this->checkIntegrity($tT, $errors);
        if (empty($errors->errors)) {
            goto OV;
        }
        return $errors;
        OV:
        $CN = $this->getVerificationType();
        $this->validateChallenge($CN, NULL, $tT["\155\157\166\145\x72\151\x66\x79"]);
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $CN)) {
            goto MD;
        }
        $this->unsetOTPSessionVariables();
        goto SH;
        MD:
        $errors[] = MoUtility::_get_invalid_otp_method();
        SH:
        return $errors;
    }
    private function checkIntegrity($tT, array $errors)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto CJ;
        }
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) == 0)) {
            goto Nb;
        }
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $tT["\x65\x6d\141\151\154"])) {
            goto AW;
        }
        $errors[] = MoMessages::showMessage(MoMessages::EMAIL_MISMATCH);
        AW:
        Nb:
        goto X0;
        CJ:
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, MoUtility::processPhoneNumber($tT["\142\151\154\154\x69\156\147\137\160\x68\157\156\x65"]))) {
            goto LF;
        }
        $errors[] = MoMessages::showMessage(MoMessages::PHONE_MISMATCH);
        LF:
        X0:
        return $errors;
    }
    function processFormFields($EN, $Vy, $errors, $eW, $l1)
    {
        global $phoneLogic;
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0) {
            goto Kk;
        }
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) === 0)) {
            goto jr;
        }
        $l1 = isset($l1) ? $l1 : '';
        $this->sendChallenge($EN, $Vy, $errors, $l1, VerificationType::EMAIL, $eW);
        jr:
        goto d9;
        Kk:
        if (!isset($l1) || !MoUtility::validatePhoneNumber($l1)) {
            goto Qr;
        }
        if ($this->_restrictDuplicates && $this->isPhoneNumberAlreadyInUse($l1, "\x62\151\154\154\x69\156\147\x5f\160\x68\157\x6e\145")) {
            goto zn;
        }
        goto qX;
        Qr:
        return new WP_Error("\x62\151\x6c\x6c\x69\x6e\147\x5f\160\x68\157\x6e\145\137\145\x72\x72\x6f\x72", str_replace("\x23\x23\x70\150\x6f\156\145\43\43", $l1, $phoneLogic->_get_otp_invalid_format_message()));
        goto qX;
        zn:
        return new WP_Error("\x62\151\x6c\154\151\156\x67\137\x70\150\x6f\156\145\137\x65\162\x72\157\x72", MoMessages::showMessage(MoMessages::PHONE_EXISTS));
        qX:
        $this->sendChallenge($EN, $Vy, $errors, $l1, VerificationType::PHONE, $eW);
        d9:
        return $errors;
    }
    function isPhoneNumberAlreadyInUse($l1, $O5)
    {
        global $wpdb;
        $l1 = MoUtility::processPhoneNumber($l1);
        $KA = $wpdb->get_row("\123\105\x4c\x45\x43\124\x20\140\165\x73\x65\162\137\151\144\140\40\x46\x52\117\115\40\140{$wpdb->prefix}\165\163\x65\162\155\145\164\141\140\x20\127\110\x45\x52\105\x20\140\x6d\x65\x74\x61\x5f\153\145\171\140\40\75\x20\x27{$O5}\x27\x20\101\x4e\x44\x20\x60\x6d\145\x74\141\137\166\141\154\165\145\140\x20\75\40\40\x27{$l1}\x27");
        return !MoUtility::isBlank($KA);
    }
    function miniorange_register_wc_script()
    {
        wp_register_script("\155\157\x77\x63\x70\166\x72\x65\x67", MOV_URL . "\x69\x6e\x63\154\x75\144\x65\163\x2f\152\x73\57\167\143\160\166\162\x65\147\56\x6d\x69\x6e\x2e\152\x73", array("\152\161\165\x65\162\171"));
        wp_localize_script("\155\157\x77\143\160\166\x72\x65\x67", "\x6d\x6f\167\x63\x70\x76\162\145\147", array("\163\x69\164\x65\125\122\x4c" => wp_ajax_url(), "\157\x74\x70\124\x79\160\x65" => $this->_otpType, "\156\x6f\156\143\145" => wp_create_nonce($this->_nonce), "\x62\x75\164\x74\x6f\156\164\145\170\164" => mo_($this->_buttonText), "\146\151\145\154\x64" => $this->_otpType === $this->_typePhoneTag ? "\162\145\x67\137\166\x70\137\142\x69\154\x6c\151\x6e\147\x5f\160\150\x6f\156\x65" : "\x77\143\x70\x76\55\x63\x6f\x6e\x66\151\x72\155\55\x65\x6d\141\151\x6c", "\x69\x6d\x67\x55\x52\114" => MOV_LOADER_URL, "\143\x6f\x64\145\114\x61\142\x65\x6c" => mo_("\105\x6e\x74\x65\162\x20\x56\145\162\151\x66\x69\x63\141\164\x69\x6f\x6e\x20\103\157\144\145")));
        wp_enqueue_script("\155\x6f\x77\143\160\x76\x72\x65\147");
    }
    public function mo_add_phone_field()
    {
        echo "\74\160\x20\x63\154\141\x73\x73\x3d\42\146\x6f\162\x6d\x2d\162\x6f\167\40\x66\157\162\x6d\x2d\x72\x6f\x77\55\167\x69\x64\x65\x22\x3e\xa\11\11\11\x9\x9\x3c\154\141\142\145\x6c\40\146\x6f\162\75\x22\162\x65\x67\x5f\x76\160\137\x62\151\154\154\151\x6e\x67\x5f\160\150\157\156\145\x22\76\12\x9\11\11\x9\x9\40\x20\x20\40" . mo_("\x50\x68\x6f\x6e\145") . "\12\x9\11\11\x9\11\40\x20\x20\40\74\x73\x70\x61\x6e\40\143\154\x61\x73\x73\x3d\42\x72\145\161\x75\x69\x72\145\x64\x22\x3e\x2a\74\x2f\163\160\x61\x6e\x3e\12\x20\40\40\x20\x20\40\x20\40\40\40\40\40\40\40\40\40\40\40\40\40\74\x2f\x6c\x61\142\x65\154\x3e\12\x9\x9\11\11\11\x3c\x69\156\160\165\x74\40\x74\171\x70\145\75\42\x74\x65\x78\x74\x22\x20\x63\154\x61\x73\x73\x3d\42\x69\x6e\160\165\x74\x2d\164\x65\170\x74\x22\40\xa\11\11\x9\x9\x9\40\40\40\40\x20\x20\40\x20\156\141\155\145\x3d\42\x62\x69\154\154\x69\x6e\147\x5f\x70\150\157\x6e\145\42\40\x69\144\75\x22\x72\x65\x67\x5f\x76\x70\137\x62\x69\154\154\151\x6e\147\x5f\160\x68\x6f\156\x65\42\40\xa\x9\x9\x9\11\11\x20\40\40\40\40\40\40\x20\166\x61\x6c\x75\145\75\42" . (!empty($_POST["\142\x69\154\x6c\151\156\x67\x5f\x70\x68\157\x6e\145"]) ? $_POST["\142\x69\154\x6c\151\x6e\147\137\160\150\x6f\156\x65"] : '') . "\42\40\x2f\x3e\xa\x9\11\x9\40\40\11\40\40\x3c\x2f\160\x3e";
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function handle_post_verification($WE, $wE, $MQ, $eW, $TB, $HL, $au)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $au);
    }
    public function handle_failed_verification($wE, $MQ, $TB, $au)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VERIFICATION_FAILED, $au);
    }
    public function getPhoneNumberSelector($sq)
    {
        if (!$this->isFormEnabled()) {
            goto fP;
        }
        array_push($sq, $this->_phoneFormId);
        fP:
        return $sq;
    }
    public function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto qe;
        }
        return;
        qe:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x77\x63\137\160\166\137\x64\x65\x66\x61\165\x6c\x74\137\145\x6e\x61\142\x6c\145");
        $this->_otpType = $this->sanitizeFormPOST("\x77\x63\137\x70\x76\x5f\145\156\141\x62\154\145\137\x74\x79\160\x65");
        $this->_restrictDuplicates = $this->sanitizeFormPOST("\167\143\137\x70\x76\x5f\162\145\163\x74\x72\x69\143\x74\x5f\x64\x75\160\154\151\143\141\x74\145\163");
        $this->_buttonText = $this->sanitizeFormPOST("\x77\143\x5f\x70\166\137\142\165\x74\x74\157\x6e\137\164\145\170\164");
        update_mo_option("\167\x63\137\x70\x76\x5f\144\145\x66\x61\165\154\164\x5f\x65\156\x61\x62\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\167\143\x5f\x70\166\x5f\145\x6e\141\x62\x6c\x65\x5f\164\171\x70\x65", $this->_otpType);
        update_mo_option("\x77\143\137\x70\x76\137\x72\x65\x73\164\x72\151\143\164\137\x64\165\160\154\x69\x63\x61\x74\145\x73", $this->_restrictDuplicates);
        update_mo_option("\167\143\137\x70\166\x5f\x62\165\164\x74\x6f\x6e\x5f\x74\x65\x78\x74", $this->_buttonText);
    }
}
