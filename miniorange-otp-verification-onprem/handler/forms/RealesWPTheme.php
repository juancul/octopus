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
class RealesWPTheme extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::REALESWP_REGISTER;
        $this->_typePhoneTag = "\155\x6f\x5f\x72\x65\141\x6c\x65\x73\x5f\x70\x68\157\x6e\145\137\145\x6e\141\142\154\x65";
        $this->_typeEmailTag = "\x6d\x6f\x5f\x72\145\x61\154\145\x73\x5f\x65\x6d\x61\x69\x6c\x5f\x65\x6e\141\142\154\x65";
        $this->_phoneFormId = "\x23\x70\x68\157\x6e\145\x53\x69\x67\x6e\165\x70";
        $this->_formKey = "\122\x45\101\x4c\x45\123\137\x52\x45\107\111\x53\124\x45\122";
        $this->_formName = mo_("\122\x65\141\x6c\145\x73\x20\127\x50\40\124\150\145\x6d\145\40\122\x65\x67\x69\x73\x74\162\x61\164\151\x6f\156\40\106\x6f\x72\155");
        $this->_isFormEnabled = get_mo_option("\x72\145\141\x6c\x65\x73\x5f\x65\x6e\x61\142\154\145");
        $this->_formDocuments = MoOTPDocs::REALES_THEME;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x72\x65\141\x6c\145\163\137\x65\x6e\141\142\x6c\145\137\x74\171\x70\x65");
        add_action("\x77\x70\137\x65\x6e\x71\x75\x65\165\x65\137\x73\x63\162\x69\x70\164\163", array($this, "\x65\156\161\165\145\165\145\x5f\x73\143\x72\x69\x70\164\137\x6f\156\x5f\160\141\x67\x65"));
        $this->routeData();
    }
    function routeData()
    {
        if (array_key_exists("\x6f\160\x74\151\x6f\156", $_GET)) {
            goto iz;
        }
        return;
        iz:
        switch (trim($_GET["\x6f\x70\x74\151\x6f\156"])) {
            case "\x6d\151\156\x69\157\x72\141\x6e\147\x65\55\x72\x65\141\x6c\x65\x73\167\x70\x2d\x76\x65\x72\x69\x66\171":
                $this->_send_otp_realeswp_verify($_POST);
                goto al;
            case "\x6d\x69\156\x69\157\x72\x61\156\x67\145\55\166\x61\154\151\144\x61\x74\145\55\162\145\141\154\x65\163\x77\x70\x2d\x6f\164\160":
                $this->_reales_validate_otp($_POST);
                goto al;
        }
        bT:
        al:
    }
    function enqueue_script_on_page()
    {
        wp_register_script("\x72\x65\141\x6c\145\163\x77\160\x53\143\162\151\160\164", MOV_URL . "\x69\x6e\143\x6c\x75\x64\145\x73\x2f\152\163\57\x72\145\x61\154\x65\163\x77\160\56\x6d\x69\156\x2e\x6a\163\x3f\166\145\x72\x73\151\157\x6e\75" . MOV_VERSION, array("\152\161\x75\145\x72\x79"));
        wp_localize_script("\x72\x65\141\x6c\x65\x73\x77\x70\x53\143\162\x69\x70\164", "\155\x6f\166\141\162\x73", array("\x69\x6d\x67\x55\122\114" => MOV_URL . "\151\156\x63\x6c\165\144\145\163\57\151\155\x61\x67\x65\x73\x2f\154\157\141\144\x65\162\56\x67\151\146", "\146\151\x65\154\144\x6e\x61\x6d\x65" => $this->_otpType == $this->_typePhoneTag ? "\x70\150\157\x6e\145\40\156\x75\155\142\145\162" : "\x65\155\141\x69\154", "\146\x69\145\x6c\144" => $this->_otpType == $this->_typePhoneTag ? "\160\x68\157\156\145\123\151\x67\x6e\x75\x70" : "\x65\155\141\x69\x6c\x53\x69\147\x6e\165\x70", "\163\151\164\145\x55\x52\114" => site_url(), "\x69\x6e\x73\145\162\164\101\146\x74\x65\x72" => $this->_otpType == $this->_typePhoneTag ? "\43\160\x68\x6f\x6e\145\x53\x69\147\156\165\x70" : "\x23\145\x6d\141\x69\154\123\x69\147\156\x75\x70", "\x70\x6c\141\143\x65\110\157\x6c\x64\145\x72" => mo_("\x4f\124\x50\40\103\x6f\x64\145"), "\x62\x75\x74\164\x6f\156\124\x65\170\164" => mo_("\x56\x61\x6c\x69\144\141\164\x65\x20\x61\x6e\x64\40\x53\x69\147\156\x20\125\160"), "\x61\x6a\141\170\165\x72\x6c" => wp_ajax_url()));
        wp_enqueue_script("\x72\x65\141\x6c\145\163\x77\160\123\x63\162\151\160\x74");
    }
    function _send_otp_realeswp_verify($tT)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto B6;
        }
        $this->_send_otp_to_email($tT);
        goto OC;
        B6:
        $this->_send_otp_to_phone($tT);
        OC:
    }
    function _send_otp_to_phone($tT)
    {
        if (array_key_exists("\x75\163\145\x72\137\160\150\157\x6e\x65", $tT) && !MoUtility::isBlank($tT["\x75\x73\x65\x72\137\x70\150\x6f\x6e\x65"])) {
            goto GP;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        goto re;
        GP:
        SessionUtils::addPhoneVerified($this->_formSessionVar, trim($tT["\x75\x73\x65\x72\137\x70\x68\x6f\x6e\145"]));
        $this->sendChallenge("\x74\145\x73\x74", '', null, trim($tT["\165\x73\145\162\137\160\150\157\x6e\x65"]), VerificationType::PHONE);
        re:
    }
    function _send_otp_to_email($tT)
    {
        if (array_key_exists("\x75\x73\x65\x72\137\x65\155\x61\x69\x6c", $tT) && !MoUtility::isBlank($tT["\165\x73\x65\x72\137\145\155\141\151\x6c"])) {
            goto DA;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        goto RP;
        DA:
        SessionUtils::addEmailVerified($this->_formSessionVar, $tT["\x75\x73\x65\162\137\x65\x6d\x61\x69\154"]);
        $this->sendChallenge("\x74\145\x73\164", $tT["\165\x73\145\x72\x5f\145\x6d\141\151\154"], null, $tT["\x75\x73\x65\162\x5f\145\x6d\141\151\x6c"], VerificationType::EMAIL);
        RP:
    }
    function _reales_validate_otp($tT)
    {
        $id = !isset($tT["\x6f\164\x70"]) ? sanitize_text_field($tT["\x6f\x74\160"]) : '';
        $this->checkIfOTPVerificationHasStarted();
        $this->validateSubmittedFields($tT);
        $this->validateChallenge(NULL, $id);
    }
    function validateSubmittedFields($tT)
    {
        $CN = $this->getVerificationType();
        if ($CN === VerificationType::EMAIL && !SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $tT["\x75\163\x65\x72\x5f\145\155\141\x69\154"])) {
            goto gS;
        }
        if ($CN === VerificationType::PHONE && !SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $tT["\x75\x73\x65\x72\x5f\x70\150\157\156\x65"])) {
            goto zW;
        }
        goto dA;
        gS:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::EMAIL_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        die;
        goto dA;
        zW:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        die;
        dA:
    }
    function checkIfOTPVerificationHasStarted()
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto Qu;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PLEASE_VALIDATE), MoConstants::ERROR_JSON_TYPE));
        die;
        Qu:
    }
    function handle_failed_verification($wE, $MQ, $TB, $au)
    {
        wp_send_json(MoUtility::createJson(MoUtility::_get_invalid_otp_method(), MoConstants::ERROR_JSON_TYPE));
        die;
    }
    function handle_post_verification($WE, $wE, $MQ, $eW, $TB, $HL, $au)
    {
        $this->unsetOTPSessionVariables();
        wp_send_json(MoUtility::createJson(MoMessages::REG_SUCCESS, MoConstants::SUCCESS_JSON_TYPE));
        die;
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($sq)
    {
        if (!($this->isFormEnabled() && $this->_otpType == $this->_typePhoneTag)) {
            goto sZ;
        }
        array_push($sq, $this->_phoneFormId);
        sZ:
        return $sq;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto Tw;
        }
        return;
        Tw:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x72\145\141\154\145\163\137\145\x6e\141\142\154\145");
        $this->_otpType = $this->sanitizeFormPOST("\x72\x65\141\x6c\145\163\137\145\156\x61\x62\154\145\x5f\x74\171\x70\145");
        update_mo_option("\x72\x65\x61\154\145\x73\x5f\145\x6e\141\x62\154\x65", $this->_isFormEnabled);
        update_mo_option("\x72\x65\141\x6c\145\163\x5f\145\156\141\x62\x6c\145\137\x74\x79\160\145", $this->_otpType);
    }
}
