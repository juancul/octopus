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
class VisualFormBuilder extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::VISUAL_FORM;
        $this->_typePhoneTag = "\155\157\x5f\x76\151\163\165\x61\x6c\x5f\146\x6f\x72\155\137\x70\150\157\x6e\x65\x5f\145\x6e\x61\142\154\145";
        $this->_typeEmailTag = "\155\x6f\137\166\x69\x73\165\141\x6c\137\x66\x6f\x72\x6d\137\145\x6d\x61\151\x6c\137\x65\156\141\142\x6c\145";
        $this->_typeBothTag = "\155\157\137\166\151\x73\x75\141\154\137\146\x6f\162\x6d\137\142\157\x74\x68\x5f\x65\156\141\142\x6c\x65";
        $this->_formKey = "\126\111\x53\x55\x41\114\x5f\x46\117\122\115";
        $this->_formName = mo_("\x56\151\163\x75\x61\x6c\x20\x46\x6f\162\x6d\40\102\x75\151\154\144\x65\x72");
        $this->_phoneFormId = array();
        $this->_isFormEnabled = get_mo_option("\x76\151\x73\165\x61\154\x5f\146\157\x72\x6d\137\145\x6e\x61\x62\154\x65");
        $this->_buttonText = get_mo_option("\x76\151\163\x75\141\x6c\137\x66\x6f\x72\x6d\137\x62\x75\164\164\x6f\x6e\137\x74\x65\170\x74");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\103\x6c\151\143\153\40\110\x65\x72\x65\x20\x74\x6f\40\163\145\x6e\144\x20\x4f\x54\x50");
        $this->_generateOTPAction = "\x6d\x69\156\x69\157\x72\141\156\x67\145\55\166\x66\55\x73\145\156\x64\55\x6f\164\160";
        $this->_validateOTPAction = "\155\x69\156\x69\x6f\162\x61\156\147\145\x2d\x76\x66\55\166\x65\x72\x69\146\x79\x2d\143\x6f\144\145";
        $this->_formDocuments = MoOTPDocs::VISUAL_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\166\x69\163\x75\141\154\137\x66\x6f\x72\155\137\x65\x6e\141\x62\154\145\x5f\164\171\160\x65");
        $this->_formDetails = maybe_unserialize(get_mo_option("\166\151\x73\165\141\154\x5f\146\157\162\x6d\x5f\x6f\164\160\137\x65\156\141\142\154\145\x64"));
        if (!(empty($this->_formDetails) || !$this->_isFormEnabled)) {
            goto TX;
        }
        return;
        TX:
        foreach ($this->_formDetails as $O5 => $Xd) {
            array_push($this->_phoneFormId, "\43" . $Xd["\160\x68\157\x6e\145\x6b\145\171"]);
            CZ:
        }
        ou:
        add_action("\167\160\x5f\x65\156\161\x75\145\x75\145\137\163\143\162\151\x70\x74\163", array($this, "\x6d\157\137\145\156\161\x75\145\165\x65\137\x76\146"));
        add_action("\167\x70\x5f\141\152\141\x78\137{$this->_generateOTPAction}", array($this, "\x5f\163\x65\x6e\144\137\157\x74\x70\x5f\x76\146\137\141\x6a\x61\x78"));
        add_action("\167\160\137\141\x6a\141\170\137\156\x6f\160\x72\151\x76\x5f{$this->_generateOTPAction}", array($this, "\137\x73\145\x6e\x64\x5f\157\164\160\x5f\166\146\x5f\141\152\x61\170"));
        add_action("\167\160\x5f\x61\x6a\141\170\137{$this->_validateOTPAction}", array($this, "\160\x72\157\143\x65\x73\163\106\157\x72\155\x41\156\x64\x56\141\x6c\151\144\x61\164\145\117\124\x50"));
        add_action("\167\160\137\x61\x6a\x61\x78\x5f\156\x6f\160\x72\151\166\137{$this->_validateOTPAction}", array($this, "\x70\x72\x6f\143\145\x73\163\x46\x6f\162\x6d\101\156\144\126\141\154\x69\144\141\x74\145\x4f\124\x50"));
    }
    function mo_enqueue_vf()
    {
        wp_register_script("\166\x66\x73\x63\162\151\160\164", MOV_URL . "\x69\x6e\143\x6c\x75\144\145\163\x2f\x6a\x73\x2f\166\x66\163\143\x72\151\160\x74\x2e\155\x69\x6e\56\x6a\163", array("\x6a\161\x75\145\x72\x79"));
        wp_localize_script("\166\x66\163\143\162\x69\x70\164", "\x6d\157\166\146\x76\x61\x72", array("\x73\151\164\x65\125\122\x4c" => wp_ajax_url(), "\157\x74\x70\x54\171\160\x65" => strcasecmp($this->_otpType, $this->_typePhoneTag), "\x66\157\162\155\x44\145\164\x61\151\154\x73" => $this->_formDetails, "\x62\x75\164\x74\157\x6e\164\145\x78\x74" => $this->_buttonText, "\x69\155\147\x55\122\x4c" => MOV_LOADER_URL, "\x66\x69\x65\x6c\x64\x54\x65\170\164" => mo_("\105\156\164\145\162\x20\117\x54\120\x20\x68\x65\162\145"), "\x67\x6e\157\x6e\x63\145" => wp_create_nonce($this->_nonce), "\x6e\157\x6e\x63\145\113\x65\171" => wp_create_nonce($this->_nonceKey), "\x76\156\x6f\x6e\143\x65" => wp_create_nonce($this->_nonce), "\147\141\143\164\151\157\156" => $this->_generateOTPAction, "\166\x61\x63\x74\151\157\156" => $this->_validateOTPAction));
        wp_enqueue_script("\166\x66\163\143\x72\151\x70\x74");
    }
    function _send_otp_vf_ajax()
    {
        $this->validateAjaxRequest();
        if ($this->_otpType == $this->_typePhoneTag) {
            goto x6;
        }
        $this->_send_vf_otp_to_email($_POST);
        goto Mb;
        x6:
        $this->_send_vf_otp_to_phone($_POST);
        Mb:
    }
    function _send_vf_otp_to_phone($tT)
    {
        if (!MoUtility::sanitizeCheck("\165\x73\145\162\x5f\x70\x68\157\156\x65", $tT)) {
            goto Hy;
        }
        $this->startOTPVerification(trim($tT["\x75\x73\145\x72\137\160\x68\157\156\x65"]), NULL, trim($tT["\x75\x73\x65\x72\x5f\x70\x68\x6f\156\x65"]), VerificationType::PHONE);
        goto so;
        Hy:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        so:
    }
    function _send_vf_otp_to_email($tT)
    {
        if (!MoUtility::sanitizeCheck("\x75\x73\x65\162\137\x65\155\x61\x69\154", $tT)) {
            goto q4;
        }
        $this->startOTPVerification($tT["\x75\x73\x65\x72\137\145\x6d\x61\151\x6c"], $tT["\x75\x73\145\x72\x5f\x65\155\x61\x69\154"], NULL, VerificationType::EMAIL);
        goto GH;
        q4:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        GH:
    }
    private function startOTPVerification($Jx, $W8, $ZI, $au)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if ($au === VerificationType::PHONE) {
            goto gL;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $Jx);
        goto rk;
        gL:
        SessionUtils::addPhoneVerified($this->_formSessionVar, $Jx);
        rk:
        $this->sendChallenge('', $W8, NULL, $ZI, $au);
    }
    function processFormAndValidateOTP()
    {
        $this->validateAjaxRequest();
        $this->checkIfVerificationNotStarted();
        $this->checkIntegrityAndValidateOTP($_POST);
    }
    function checkIfVerificationNotStarted()
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto Mh;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE), MoConstants::ERROR_JSON_TYPE));
        Mh:
    }
    private function checkIntegrityAndValidateOTP($post)
    {
        $this->checkIntegrity($post);
        $this->validateChallenge($this->getVerificationType(), NULL, $post["\157\164\160\x5f\x74\x6f\153\145\156"]);
    }
    private function checkIntegrity($post)
    {
        if ($this->isPhoneVerificationEnabled()) {
            goto Xp;
        }
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $post["\x73\x75\142\x5f\146\151\145\x6c\x64"])) {
            goto Jx;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::EMAIL_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        Jx:
        goto nK;
        Xp:
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $post["\163\x75\x62\x5f\x66\x69\145\154\144"])) {
            goto UI;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        UI:
        nK:
    }
    function handle_failed_verification($wE, $MQ, $TB, $au)
    {
        wp_send_json(MoUtility::createJson(MoUtility::_get_invalid_otp_method(), MoConstants::ERROR_JSON_TYPE));
    }
    function handle_post_verification($WE, $wE, $MQ, $eW, $TB, $HL, $au)
    {
        $this->unsetOTPSessionVariables();
        wp_send_json(MoUtility::createJson(MoConstants::SUCCESS, MoConstants::SUCCESS_JSON_TYPE));
    }
    function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($sq)
    {
        if (!($this->_isFormEnabled && $this->isPhoneVerificationEnabled())) {
            goto c_;
        }
        $sq = array_merge($sq, $this->_phoneFormId);
        c_:
        return $sq;
    }
    function isPhoneVerificationEnabled()
    {
        $CN = $this->getVerificationType();
        return $CN == VerificationType::PHONE || $CN === VerificationType::BOTH;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto Nm;
        }
        return;
        Nm:
        $form = $this->parseFormDetails();
        $this->_isFormEnabled = $this->sanitizeFormPOST("\166\151\x73\165\x61\x6c\x5f\x66\x6f\x72\155\137\145\x6e\x61\142\154\145");
        $this->_otpType = $this->sanitizeFormPOST("\x76\x69\163\x75\141\154\x5f\x66\x6f\x72\x6d\x5f\145\x6e\141\x62\x6c\x65\137\164\x79\160\145");
        $this->_formDetails = !empty($form) ? $form : '';
        $this->_buttonText = $this->sanitizeFormPOST("\166\x69\163\x75\x61\154\x5f\146\x6f\162\x6d\x5f\142\x75\164\164\157\156\x5f\164\145\170\x74");
        if (!$this->basicValidationCheck(BaseMessages::VISUAL_FORM_CHOOSE)) {
            goto xs;
        }
        update_mo_option("\x76\x69\x73\x75\141\154\x5f\146\157\x72\x6d\137\x62\x75\x74\164\x6f\156\137\x74\145\170\x74", $this->_buttonText);
        update_mo_option("\166\151\163\x75\x61\154\x5f\146\x6f\x72\x6d\x5f\x65\156\x61\142\x6c\145", $this->_isFormEnabled);
        update_mo_option("\x76\151\163\x75\141\x6c\137\x66\157\162\155\x5f\145\x6e\141\x62\154\145\x5f\164\x79\160\x65", $this->_otpType);
        update_mo_option("\166\x69\x73\x75\x61\154\137\x66\157\x72\x6d\x5f\x6f\164\160\137\145\x6e\141\x62\154\145\144", maybe_serialize($this->_formDetails));
        xs:
    }
    function parseFormDetails()
    {
        $form = array();
        if (array_key_exists("\166\151\163\x75\x61\154\x5f\146\157\162\155", $_POST)) {
            goto lk;
        }
        return array();
        lk:
        foreach (array_filter($_POST["\166\151\163\165\x61\x6c\x5f\x66\157\x72\x6d"]["\146\157\162\x6d"]) as $O5 => $Xd) {
            $form[$Xd] = array("\x65\x6d\141\x69\154\153\145\171" => $this->getFieldID($_POST["\x76\151\x73\x75\x61\x6c\x5f\146\157\162\x6d"]["\145\x6d\141\x69\x6c\x6b\145\x79"][$O5], $Xd), "\x70\x68\x6f\x6e\145\x6b\x65\x79" => $this->getFieldID($_POST["\x76\x69\163\165\x61\154\x5f\146\157\x72\155"]["\x70\150\157\x6e\x65\x6b\145\171"][$O5], $Xd), "\160\150\x6f\156\x65\137\163\150\x6f\x77" => $_POST["\166\151\163\x75\x61\x6c\x5f\x66\x6f\x72\x6d"]["\x70\x68\x6f\156\145\x6b\x65\x79"][$O5], "\x65\x6d\141\151\x6c\137\163\150\x6f\167" => $_POST["\x76\x69\163\165\141\x6c\137\146\157\x72\155"]["\x65\x6d\141\x69\154\x6b\x65\x79"][$O5]);
            Vr:
        }
        gq:
        return $form;
    }
    private function getFieldID($O5, $mA)
    {
        global $wpdb;
        $Zy = "\x53\x45\114\105\x43\124\x20\52\40\106\122\117\x4d\x20" . VFB_WP_FIELDS_TABLE_NAME . "\x20\167\x68\145\162\145\x20\146\151\145\x6c\x64\137\156\x61\x6d\145\40\x3d\x27" . $O5 . "\47\x61\156\144\x20\146\x6f\162\155\137\151\x64\x20\75\40\x27" . $mA . "\x27";
        $Qh = $wpdb->get_row($Zy);
        return !MoUtility::isBlank($Qh) ? "\166\146\142\x2d" . $Qh->field_id : '';
    }
}
