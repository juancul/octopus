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
class DocDirectThemeRegistration extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::DOCDIRECT_REG;
        $this->_typePhoneTag = "\x6d\157\x5f\x64\x6f\143\144\151\162\x65\x63\164\x5f\x70\150\x6f\x6e\x65\137\x65\x6e\141\142\x6c\x65";
        $this->_typeEmailTag = "\155\x6f\x5f\x64\157\143\x64\x69\x72\145\143\x74\137\x65\x6d\x61\x69\x6c\x5f\145\156\x61\142\x6c\x65";
        $this->_formKey = "\x44\x4f\x43\x44\x49\122\105\x43\x54\137\x54\x48\x45\x4d\x45";
        $this->_formName = mo_("\104\157\143\40\104\151\x72\145\143\164\40\124\150\145\x6d\145\40\142\x79\40\124\150\145\155\157\107\x72\x61\160\150\151\143\x73");
        $this->_isFormEnabled = get_mo_option("\144\x6f\x63\x64\151\x72\x65\143\164\137\x65\156\x61\x62\154\x65");
        $this->_phoneFormId = "\151\x6e\x70\x75\164\x5b\x6e\x61\x6d\x65\75\x70\x68\157\x6e\145\x5f\x6e\165\155\142\145\x72\135";
        $this->_formDocuments = MoOTPDocs::DOCDIRECT_THEME;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\144\157\x63\x64\151\162\145\143\x74\137\x65\x6e\141\x62\154\145\137\x74\x79\160\145");
        add_action("\x77\x70\137\x65\x6e\161\165\x65\165\x65\137\163\143\x72\151\x70\164\163", array($this, "\x61\144\144\x53\143\x72\151\x70\164\x54\x6f\122\145\x67\x69\x73\x74\162\x61\164\x69\x6f\156\x50\141\x67\145"));
        add_action("\167\x70\x5f\x61\152\141\170\137\144\x6f\x63\144\x69\162\145\143\x74\x5f\165\x73\145\162\137\x72\145\x67\x69\163\164\162\141\x74\151\x6f\x6e", array($this, "\155\x6f\137\x76\141\x6c\x69\x64\141\164\x65\x5f\x64\x6f\x63\144\151\x72\x65\x63\x74\x5f\x75\x73\x65\162\x5f\162\x65\147\151\x73\x74\x72\141\164\x69\x6f\156"), 1);
        add_action("\167\160\x5f\141\x6a\141\x78\137\x6e\x6f\160\x72\151\x76\x5f\144\157\143\x64\x69\162\x65\x63\164\137\165\x73\x65\162\137\x72\x65\147\151\x73\164\162\141\x74\x69\157\156", array($this, "\155\157\137\166\141\154\x69\144\141\x74\x65\137\x64\x6f\x63\x64\x69\162\145\x63\164\137\165\163\145\162\137\x72\145\x67\x69\x73\x74\x72\x61\164\x69\157\x6e"), 1);
        $this->routeData();
    }
    function routeData()
    {
        if (array_key_exists("\x6f\160\164\151\157\x6e", $_GET)) {
            goto i_;
        }
        return;
        i_:
        switch (trim($_GET["\x6f\160\x74\151\157\156"])) {
            case "\155\x69\156\x69\x6f\162\141\x6e\x67\145\55\144\x6f\x63\x64\151\162\x65\143\164\x2d\166\145\x72\151\x66\x79":
                $this->startOTPVerificationProcess($_POST);
                goto V7;
        }
        pP:
        V7:
    }
    function addScriptToRegistrationPage()
    {
        wp_register_script("\144\157\143\144\151\162\x65\143\x74", MOV_URL . "\x69\x6e\143\x6c\x75\x64\145\x73\57\x6a\x73\57\x64\157\x63\144\151\x72\145\143\164\x2e\x6d\x69\x6e\56\x6a\x73\77\x76\x65\162\163\x69\x6f\x6e\x3d" . MOV_VERSION, array("\x6a\161\x75\x65\x72\x79"), MOV_VERSION, true);
        wp_localize_script("\x64\157\143\x64\x69\x72\145\x63\164", "\155\157\144\157\143\x64\x69\x72\x65\x63\x74", array("\x69\x6d\x67\125\122\x4c" => MOV_URL . "\x69\x6e\x63\154\165\144\x65\163\x2f\x69\155\x61\147\x65\x73\57\154\157\141\x64\145\x72\x2e\147\151\146", "\x62\x75\x74\x74\157\x6e\x54\145\x78\164" => mo_("\103\154\151\x63\x6b\x20\110\x65\162\x65\40\x74\x6f\40\126\145\x72\x69\x66\x79\40\131\x6f\x75\x72\163\145\154\146"), "\151\x6e\163\145\x72\x74\x41\146\164\145\162" => strcasecmp($this->_otpType, $this->_typePhoneTag) === 0 ? "\x69\156\x70\165\x74\x5b\x6e\x61\x6d\x65\x3d\x70\150\x6f\156\x65\137\156\x75\155\142\x65\x72\x5d" : "\x69\156\x70\165\x74\x5b\156\141\155\x65\x3d\x65\x6d\141\x69\154\135", "\160\154\141\x63\145\x48\x6f\x6c\x64\145\162" => mo_("\x4f\x54\x50\40\103\x6f\144\x65"), "\x73\x69\x74\x65\x55\122\114" => site_url()));
        wp_enqueue_script("\x64\x6f\x63\144\x69\162\x65\x63\164");
    }
    function startOtpVerificationProcess($tT)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0) {
            goto QJ;
        }
        $this->_send_otp_to_email($tT);
        goto Ne;
        QJ:
        $this->_send_otp_to_phone($tT);
        Ne:
    }
    function _send_otp_to_phone($tT)
    {
        if (array_key_exists("\x75\163\x65\162\x5f\160\x68\157\x6e\x65", $tT) && !MoUtility::isBlank($tT["\165\x73\x65\x72\137\160\150\x6f\x6e\x65"])) {
            goto Zk;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        goto Pp;
        Zk:
        SessionUtils::addPhoneVerified($this->_formSessionVar, trim($tT["\165\x73\x65\x72\x5f\160\x68\x6f\156\x65"]));
        $this->sendChallenge("\164\145\163\x74", '', null, trim($tT["\165\163\145\162\x5f\x70\150\x6f\x6e\145"]), VerificationType::PHONE);
        Pp:
    }
    function _send_otp_to_email($tT)
    {
        if (array_key_exists("\165\x73\145\162\x5f\x65\155\x61\151\154", $tT) && !MoUtility::isBlank($tT["\x75\x73\145\162\137\145\x6d\x61\x69\x6c"])) {
            goto DY;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        goto t7;
        DY:
        SessionUtils::addEmailVerified($this->_formSessionVar, $tT["\x75\163\145\x72\137\x65\x6d\141\x69\x6c"]);
        $this->sendChallenge("\x74\x65\163\164", $tT["\x75\x73\145\162\137\145\x6d\141\x69\x6c"], null, $tT["\165\163\x65\x72\137\145\x6d\141\151\x6c"], VerificationType::EMAIL);
        t7:
    }
    function mo_validate_docdirect_user_registration()
    {
        $this->checkIfVerificationNotStarted();
        $this->checkIfVerificationCodeNotEntered();
        $this->handle_otp_token_submitted();
    }
    function checkIfVerificationNotStarted()
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto of;
        }
        echo json_encode(array("\164\x79\160\x65" => "\x65\162\162\x6f\162", "\x6d\145\163\x73\141\x67\145" => MoMessages::showMessage(MoMessages::DOC_DIRECT_VERIFY)));
        die;
        of:
    }
    function checkIfVerificationCodeNotEntered()
    {
        if (!(!array_key_exists("\x6d\x6f\x5f\x76\x65\x72\x69\146\x79", $_POST) || MoUtility::isBlank($_POST["\x6d\157\137\166\145\x72\151\146\x79"]))) {
            goto fB;
        }
        echo json_encode(array("\x74\x79\x70\x65" => "\145\162\x72\x6f\162", "\155\x65\163\x73\x61\x67\145" => MoMessages::showMessage(MoMessages::DCD_ENTER_VERIFY_CODE)));
        die;
        fB:
    }
    function handle_otp_token_submitted()
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0) {
            goto NL;
        }
        $this->processEmail();
        goto Bt;
        NL:
        $this->processPhoneNumber();
        Bt:
        $this->validateChallenge($this->getVerificationType(), "\155\157\x5f\166\x65\x72\x69\x66\x79", NULL);
    }
    function processPhoneNumber()
    {
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $_POST["\160\150\x6f\x6e\x65\x5f\156\165\x6d\x62\145\x72"])) {
            goto iB;
        }
        echo json_encode(array("\164\x79\160\x65" => "\145\162\162\x6f\162", "\155\145\x73\163\x61\x67\145" => MoMessages::showMessage(MoMessages::PHONE_MISMATCH)));
        die;
        iB:
    }
    function processEmail()
    {
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $_POST["\x65\155\141\151\154"])) {
            goto Wx;
        }
        echo json_encode(array("\164\x79\x70\x65" => "\x65\162\x72\x6f\162", "\155\x65\x73\x73\141\x67\x65" => MoMessages::showMessage(MoMessages::EMAIL_MISMATCH)));
        die;
        Wx:
    }
    function handle_failed_verification($wE, $MQ, $TB, $au)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto gF;
        }
        return;
        gF:
        echo json_encode(array("\x74\171\x70\145" => "\x65\x72\x72\157\162", "\x6d\145\163\163\141\x67\145" => MoUtility::_get_invalid_otp_method()));
        die;
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
        if (!($this->isFormEnabled() && $this->_otpType === $this->_typePhoneTag)) {
            goto c5;
        }
        array_push($sq, $this->_phoneFormId);
        c5:
        return $sq;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto qY;
        }
        return;
        qY:
        $this->_otpType = $this->sanitizeFormPOST("\x64\157\143\144\x69\x72\x65\x63\164\x5f\x65\156\141\142\x6c\145\x5f\x74\x79\x70\145");
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x64\157\x63\x64\151\162\145\143\164\x5f\145\156\141\142\154\145");
        update_mo_option("\144\157\143\144\x69\x72\145\143\x74\137\x65\156\x61\142\154\x65", $this->_isFormEnabled);
        update_mo_option("\x64\x6f\143\x64\151\162\x65\x63\164\137\x65\x6e\141\142\154\x65\x5f\164\x79\160\145", $this->_otpType);
    }
}
