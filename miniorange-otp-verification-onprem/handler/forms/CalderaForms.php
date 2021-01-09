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
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
use WP_Error;
class CalderaForms extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::CALDERA;
        $this->_typePhoneTag = "\x6d\157\137\143\141\x6c\x64\x65\x72\x61\137\x70\150\x6f\156\145\137\145\x6e\x61\142\154\x65";
        $this->_typeEmailTag = "\155\x6f\137\143\141\x6c\144\145\x72\x61\137\x65\x6d\141\x69\x6c\137\145\x6e\141\x62\154\x65";
        $this->_formKey = "\x43\x41\114\104\105\x52\101";
        $this->_formName = mo_("\x43\141\154\144\145\162\141\x20\106\x6f\162\x6d\x73");
        $this->_isFormEnabled = get_mo_option("\143\x61\x6c\144\145\x72\x61\137\145\156\x61\x62\x6c\145");
        $this->_buttonText = get_mo_option("\x63\x61\154\144\x65\x72\141\137\142\165\x74\164\157\x6e\137\x74\145\170\164");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\x43\154\151\143\x6b\40\x48\145\x72\x65\x20\164\157\40\163\x65\x6e\x64\40\x4f\124\x50");
        $this->_phoneFormId = array();
        $this->_formDocuments = MoOTPDocs::CALDERA_FORMS_LINK;
        $this->_generateOTPAction = "\155\x69\x6e\x69\157\162\x61\156\147\145\137\x63\141\154\144\145\162\x61\137\x67\145\156\145\x72\x61\x74\x65\137\157\x74\160";
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x63\x61\x6c\x64\145\162\x61\137\x65\156\141\142\x6c\145\137\164\x79\x70\x65");
        $this->_formDetails = maybe_unserialize(get_mo_option("\143\x61\154\x64\145\x72\141\x5f\146\157\162\x6d\x73"));
        if (!empty($this->_formDetails)) {
            goto GM;
        }
        return;
        GM:
        foreach ($this->_formDetails as $O5 => $Xd) {
            array_push($this->_phoneFormId, "\x69\x6e\x70\165\164\133\x6e\141\x6d\x65\75" . $Xd["\x70\x68\x6f\156\x65\x6b\145\171"]);
            add_filter("\143\141\x6c\144\x65\x72\x61\x5f\x66\157\162\x6d\x73\x5f\166\141\154\x69\144\x61\x74\145\137\146\151\145\x6c\x64\137" . $Xd["\160\150\157\156\x65\x6b\x65\x79"], array($this, "\166\141\154\151\x64\x61\x74\x65\x46\x6f\162\155"), 99, 3);
            add_filter("\x63\141\154\144\145\162\x61\137\146\x6f\x72\x6d\163\137\x76\x61\154\x69\x64\x61\x74\145\137\146\x69\x65\x6c\144\137" . $Xd["\x65\155\x61\x69\154\x6b\145\171"], array($this, "\x76\x61\x6c\x69\144\x61\164\x65\106\x6f\162\x6d"), 99, 3);
            add_filter("\x63\141\x6c\144\x65\162\x61\x5f\x66\x6f\162\155\x73\x5f\x76\141\154\x69\144\141\164\145\137\x66\151\145\x6c\144\137" . $Xd["\166\x65\162\151\146\171\x4b\x65\x79"], array($this, "\166\141\x6c\x69\144\141\164\145\x46\x6f\x72\155"), 99, 3);
            add_filter("\143\141\154\144\x65\x72\x61\x5f\x66\157\162\x6d\163\137\x73\x75\x62\155\x69\164\137\x72\x65\164\165\x72\156\137\164\x72\141\x6e\x73\x69\x65\x6e\x74", array($this, "\165\x6e\163\x65\164\x53\x65\x73\x73\x69\x6f\156\x56\x61\162\x69\x61\x62\154\145"), 99, 1);
            vs:
        }
        IC:
        add_action("\167\x70\137\141\152\x61\x78\x5f{$this->_generateOTPAction}", array($this, "\137\x73\x65\x6e\144\x5f\157\164\x70"));
        add_action("\167\160\x5f\141\x6a\x61\170\137\156\x6f\160\162\x69\166\x5f{$this->_generateOTPAction}", array($this, "\x5f\x73\x65\156\144\137\x6f\x74\x70"));
        add_action("\x77\x70\x5f\x65\156\x71\x75\145\x75\145\x5f\163\x63\162\151\x70\164\x73", array($this, "\155\x69\156\151\x6f\x72\x61\156\147\145\137\162\x65\147\x69\163\164\145\162\x5f\x63\x61\154\144\145\x72\x61\x5f\163\143\162\151\x70\x74"));
    }
    function unsetSessionVariable($Mq)
    {
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto Id;
        }
        $this->unsetOTPSessionVariables();
        Id:
        return $Mq;
    }
    function miniorange_register_caldera_script()
    {
        wp_register_script("\155\x6f\143\x61\x6c\x64\x65\x72\x61", MOV_URL . "\x69\156\143\154\165\144\x65\x73\57\x6a\x73\57\143\141\x6c\144\145\162\141\x2e\x6d\x69\x6e\56\152\x73", array("\152\161\165\x65\x72\171"));
        wp_localize_script("\x6d\x6f\143\141\154\x64\x65\x72\141", "\155\157\x63\141\x6c\x64\x65\162\x61", array("\x73\x69\x74\x65\125\x52\x4c" => wp_ajax_url(), "\x6f\164\x70\x54\x79\160\x65" => $this->_otpType, "\146\x6f\162\155\153\145\x79" => strcasecmp($this->_otpType, $this->_typePhoneTag) == 0 ? "\160\150\x6f\156\x65\153\x65\171" : "\145\x6d\x61\x69\154\x6b\x65\171", "\x6e\x6f\156\x63\145" => wp_create_nonce($this->_nonce), "\142\165\164\164\157\x6e\x74\x65\x78\164" => mo_($this->_buttonText), "\x69\x6d\x67\x55\x52\114" => MOV_LOADER_URL, "\x66\x6f\162\155\163" => $this->_formDetails, "\147\x65\156\145\162\x61\164\x65\x55\122\114" => $this->_generateOTPAction));
        wp_enqueue_script("\x6d\157\x63\141\154\144\145\162\141");
    }
    function _send_otp()
    {
        $tT = $_POST;
        $this->validateAjaxRequest();
        MoUtility::initialize_transaction($this->_formSessionVar);
        if ($this->_otpType == $this->_typePhoneTag) {
            goto sr;
        }
        $this->_processEmailAndStartOTPVerificationProcess($tT);
        goto Mi;
        sr:
        $this->_processPhoneAndStartOTPVerificationProcess($tT);
        Mi:
    }
    private function _processEmailAndStartOTPVerificationProcess($tT)
    {
        if (!MoUtility::sanitizeCheck("\165\x73\x65\x72\137\x65\155\x61\151\154", $tT)) {
            goto Kz;
        }
        $this->setSessionAndStartOTPVerification($tT["\165\163\145\x72\137\145\x6d\141\x69\154"], $tT["\165\x73\145\x72\137\x65\155\x61\x69\x6c"], NULL, VerificationType::EMAIL);
        goto Zm;
        Kz:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        Zm:
    }
    private function _processPhoneAndStartOTPVerificationProcess($tT)
    {
        if (!MoUtility::sanitizeCheck("\165\163\145\x72\137\x70\x68\x6f\x6e\x65", $tT)) {
            goto Ri;
        }
        $this->setSessionAndStartOTPVerification(trim($tT["\165\x73\145\x72\x5f\x70\150\157\156\x65"]), NULL, trim($tT["\165\163\x65\x72\137\160\150\x6f\156\145"]), VerificationType::PHONE);
        goto FZ;
        Ri:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        FZ:
    }
    private function setSessionAndStartOTPVerification($Jx, $W8, $ZI, $fZ)
    {
        SessionUtils::addEmailOrPhoneVerified($this->_formSessionVar, $Jx, $fZ);
        $this->sendChallenge('', $W8, NULL, $ZI, $fZ);
    }
    public function validateForm($YJ, $DH, $form)
    {
        if (!is_wp_error($YJ)) {
            goto yM;
        }
        return $YJ;
        yM:
        $HI = $form["\111\104"];
        if (array_key_exists($HI, $this->_formDetails)) {
            goto cD;
        }
        return $YJ;
        cD:
        $p8 = $this->_formDetails[$HI];
        $YJ = $this->checkIfOtpVerificationStarted($YJ);
        if (!is_wp_error($YJ)) {
            goto e6;
        }
        return $YJ;
        e6:
        if (strcasecmp($this->_otpType, $this->_typeEmailTag) == 0 && strcasecmp($DH["\x49\104"], $p8["\145\155\x61\x69\154\153\145\171"]) == 0) {
            goto L9;
        }
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0 && strcasecmp($DH["\x49\104"], $p8["\160\150\x6f\x6e\145\x6b\x65\x79"]) == 0) {
            goto nw;
        }
        if (empty($errors) && strcasecmp($DH["\x49\104"], $p8["\166\145\x72\x69\x66\x79\113\145\171"]) == 0) {
            goto BR;
        }
        goto Qm;
        L9:
        $YJ = $this->processEmail($YJ);
        goto Qm;
        nw:
        $YJ = $this->processPhone($YJ);
        goto Qm;
        BR:
        $YJ = $this->processOTPEntered($YJ);
        Qm:
        return $YJ;
    }
    function processOTPEntered($YJ)
    {
        $CN = $this->getVerificationType();
        $this->validateChallenge($CN, NULL, $YJ);
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $CN)) {
            goto j3;
        }
        $YJ = new WP_Error("\x49\x4e\x56\x41\114\111\x44\137\117\124\x50", MoUtility::_get_invalid_otp_method());
        j3:
        return $YJ;
    }
    function checkIfOtpVerificationStarted($YJ)
    {
        return SessionUtils::isOTPInitialized($this->_formSessionVar) ? $YJ : new WP_Error("\x45\116\124\105\x52\137\x56\105\122\111\x46\x59\137\x43\x4f\104\x45", MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE));
    }
    function processEmail($YJ)
    {
        return SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $YJ) ? $YJ : new WP_Error("\105\x4d\101\111\114\137\x4d\111\x53\115\x41\124\103\x48", MoMessages::showMessage(MoMessages::EMAIL_MISMATCH));
    }
    function processPhone($YJ)
    {
        return SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $YJ) ? $YJ : new WP_Error("\x50\x48\x4f\116\x45\x5f\x4d\111\123\x4d\101\124\103\x48", MoMessages::showMessage(MoMessages::PHONE_MISMATCH));
    }
    function handle_failed_verification($wE, $MQ, $TB, $au)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VERIFICATION_FAILED, $au);
    }
    function handle_post_verification($WE, $wE, $MQ, $eW, $TB, $HL, $au)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $au);
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_formSessionVar, $this->_txSessionId));
    }
    public function getPhoneNumberSelector($sq)
    {
        if (!($this->isFormEnabled() && $this->_otpType == $this->_typePhoneTag)) {
            goto tz;
        }
        $sq = array_merge($sq, $this->_phoneFormId);
        tz:
        return $sq;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto Kh;
        }
        return;
        Kh:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\143\141\154\144\145\x72\x61\x5f\x65\x6e\141\142\154\x65");
        $this->_otpType = $this->sanitizeFormPOST("\x63\141\x6c\x64\145\x72\x61\x5f\x65\x6e\x61\x62\154\x65\137\164\x79\160\x65");
        $this->_buttonText = $this->sanitizeFormPOST("\143\x61\154\x64\x65\x72\141\x5f\142\165\x74\164\157\156\x5f\x74\x65\x78\x74");
        $form = $this->parseFormDetails();
        $this->_formDetails = !empty($form) ? $form : '';
        update_mo_option("\x63\141\x6c\x64\145\x72\141\137\x65\156\141\142\154\145", $this->_isFormEnabled);
        update_mo_option("\143\141\x6c\x64\x65\x72\x61\x5f\145\156\x61\x62\x6c\x65\137\164\171\160\145", $this->_otpType);
        update_mo_option("\143\141\154\144\x65\x72\x61\137\142\165\164\x74\157\x6e\x5f\x74\x65\170\164", $this->_buttonText);
        update_mo_option("\x63\x61\x6c\x64\x65\x72\141\x5f\x66\157\x72\155\163", maybe_serialize($this->_formDetails));
    }
    function parseFormDetails()
    {
        $form = array();
        if (!(!array_key_exists("\143\141\154\x64\145\x72\x61\137\146\x6f\x72\155", $_POST) || !$this->_isFormEnabled)) {
            goto y_;
        }
        return $form;
        y_:
        foreach (array_filter($_POST["\x63\141\x6c\144\145\162\x61\137\x66\x6f\x72\x6d"]["\x66\x6f\x72\x6d"]) as $O5 => $Xd) {
            $form[$Xd] = array("\145\x6d\x61\151\154\153\x65\x79" => $_POST["\x63\141\x6c\144\x65\162\141\137\x66\157\x72\x6d"]["\x65\155\x61\151\154\x6b\145\171"][$O5], "\x70\x68\x6f\x6e\x65\153\x65\171" => $_POST["\x63\141\x6c\144\145\x72\141\x5f\x66\157\x72\155"]["\160\x68\x6f\156\145\x6b\x65\171"][$O5], "\166\x65\162\x69\146\x79\x4b\145\x79" => $_POST["\143\141\x6c\144\x65\x72\x61\x5f\146\157\162\x6d"]["\166\x65\x72\151\x66\x79\113\145\x79"][$O5], "\160\150\x6f\156\145\x5f\x73\x68\157\167" => $_POST["\143\141\x6c\x64\x65\x72\x61\x5f\x66\157\162\x6d"]["\x70\x68\x6f\156\x65\153\145\x79"][$O5], "\145\x6d\141\x69\x6c\137\x73\x68\157\x77" => $_POST["\x63\141\x6c\x64\x65\162\141\x5f\x66\x6f\162\x6d"]["\x65\155\141\151\x6c\153\145\171"][$O5], "\166\x65\162\x69\x66\171\x5f\163\x68\x6f\167" => $_POST["\x63\x61\x6c\144\x65\162\x61\137\x66\157\x72\x6d"]["\166\x65\162\151\x66\x79\113\x65\x79"][$O5]);
            Sa:
        }
        BB:
        return $form;
    }
}
