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
use WPCF7_FormTag;
use WPCF7_Validation;
class ContactForm7 extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::CF7_FORMS;
        $this->_typePhoneTag = "\155\x6f\x5f\x63\x66\x37\137\143\x6f\x6e\x74\x61\143\164\x5f\160\x68\157\x6e\x65\137\x65\156\x61\142\x6c\x65";
        $this->_typeEmailTag = "\155\x6f\137\x63\x66\x37\137\x63\157\x6e\164\x61\x63\164\x5f\145\x6d\x61\151\154\x5f\x65\156\141\x62\x6c\145";
        $this->_formKey = "\x43\106\x37\137\106\x4f\x52\115";
        $this->_formName = mo_("\103\157\x6e\x74\141\143\x74\x20\x46\157\162\155\x20\x37\x20\55\40\103\157\x6e\164\x61\x63\x74\x20\106\x6f\162\x6d");
        $this->_isFormEnabled = get_mo_option("\x63\x66\x37\137\x63\157\x6e\164\141\143\x74\x5f\145\156\x61\x62\x6c\x65");
        $this->_generateOTPAction = "\x6d\151\156\151\157\x72\x61\x6e\147\x65\55\143\x66\x37\55\x63\157\x6e\164\x61\x63\x74";
        $this->_formDocuments = MoOTPDocs::CF7_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x63\146\67\137\143\x6f\156\164\141\x63\x74\x5f\x74\171\x70\145");
        $this->_emailKey = get_mo_option("\143\x66\x37\x5f\145\x6d\141\x69\x6c\137\153\x65\x79");
        $this->_phoneKey = "\155\157\137\160\x68\x6f\x6e\x65";
        $this->_phoneFormId = array("\56\143\154\141\x73\163\137" . $this->_phoneKey, "\x69\x6e\160\x75\x74\x5b\156\141\x6d\145\x3d" . $this->_phoneKey . "\135");
        add_filter("\167\160\x63\146\67\x5f\x76\141\154\x69\144\141\164\145\137\164\x65\170\x74\52", array($this, "\x76\x61\154\x69\144\141\x74\145\x46\157\x72\x6d\x50\x6f\163\x74"), 1, 2);
        add_filter("\167\x70\x63\x66\67\137\166\x61\x6c\x69\144\x61\x74\145\x5f\145\x6d\x61\x69\x6c\x2a", array($this, "\x76\141\x6c\x69\x64\x61\x74\145\x46\x6f\x72\x6d\120\x6f\x73\164"), 1, 2);
        add_filter("\167\x70\143\x66\67\x5f\x76\141\154\151\x64\141\164\145\137\x65\155\141\x69\154", array($this, "\x76\x61\154\151\x64\x61\x74\x65\x46\157\x72\155\120\x6f\x73\x74"), 1, 2);
        add_filter("\167\160\143\146\67\137\166\x61\154\151\144\141\x74\145\x5f\x74\145\x6c\x2a", array($this, "\x76\x61\154\151\144\x61\164\145\x46\x6f\162\x6d\x50\x6f\163\x74"), 1, 2);
        add_shortcode("\155\157\x5f\166\145\162\151\x66\171\137\145\x6d\141\x69\154", array($this, "\137\x63\146\67\x5f\x65\x6d\x61\x69\154\137\x73\x68\x6f\x72\x74\143\157\x64\145"));
        add_shortcode("\x6d\x6f\x5f\x76\x65\162\151\146\x79\x5f\x70\x68\157\x6e\145", array($this, "\137\143\146\67\137\160\150\x6f\156\145\x5f\163\150\x6f\162\x74\x63\x6f\144\145"));
        add_action("\x77\160\x5f\x61\x6a\141\x78\x5f\x6e\x6f\160\162\x69\166\137{$this->_generateOTPAction}", array($this, "\x5f\x68\x61\x6e\x64\x6c\x65\x5f\143\146\x37\137\x63\x6f\156\x74\x61\143\x74\137\146\x6f\162\x6d"));
        add_action("\167\x70\137\141\152\141\x78\137{$this->_generateOTPAction}", array($this, "\137\x68\141\x6e\x64\154\x65\137\x63\x66\x37\137\143\x6f\x6e\x74\141\143\164\x5f\x66\157\x72\155"));
    }
    function _handle_cf7_contact_form()
    {
        $tT = $_POST;
        $this->validateAjaxRequest();
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (MoUtility::sanitizeCheck("\x75\163\x65\x72\x5f\x65\155\141\x69\x6c", $tT)) {
            goto R3v;
        }
        if (MoUtility::sanitizeCheck("\165\163\x65\162\x5f\160\x68\x6f\156\x65", $tT)) {
            goto R43;
        }
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto LSb;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        goto vKb;
        LSb:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        vKb:
        goto Gg2;
        R43:
        SessionUtils::addPhoneVerified($this->_formSessionVar, trim($tT["\165\163\x65\x72\137\x70\150\x6f\x6e\x65"]));
        $this->sendChallenge("\164\x65\163\x74", '', null, trim($tT["\165\163\145\162\x5f\160\150\x6f\156\x65"]), VerificationType::PHONE);
        Gg2:
        goto wOD;
        R3v:
        SessionUtils::addEmailVerified($this->_formSessionVar, $tT["\x75\x73\145\162\x5f\x65\x6d\x61\151\154"]);
        $this->sendChallenge("\x74\x65\x73\164", $tT["\x75\163\145\162\x5f\145\155\141\x69\154"], null, $tT["\x75\163\145\162\x5f\x65\x6d\141\x69\154"], VerificationType::EMAIL);
        wOD:
    }
    function validateFormPost($Qh, $Xr)
    {
        $Xr = new WPCF7_FormTag($Xr);
        $uE = $Xr->name;
        $Xd = isset($_POST[$uE]) ? trim(wp_unslash(strtr((string) $_POST[$uE], "\xa", "\x20"))) : '';
        if (!("\x65\155\141\151\154" == $Xr->basetype && $uE == $this->_emailKey && strcasecmp($this->_otpType, $this->_typeEmailTag) == 0)) {
            goto jTE;
        }
        SessionUtils::addEmailSubmitted($this->_formSessionVar, $Xd);
        jTE:
        if (!("\164\145\x6c" == $Xr->basetype && $uE == $this->_phoneKey && strcasecmp($this->_otpType, $this->_typePhoneTag) == 0)) {
            goto YqI;
        }
        SessionUtils::addPhoneSubmitted($this->_formSessionVar, $Xd);
        YqI:
        if (!("\x74\145\x78\164" == $Xr->basetype && $uE == "\x65\155\x61\x69\154\x5f\166\145\x72\x69\x66\171" || "\x74\145\x78\x74" == $Xr->basetype && $uE == "\x70\x68\157\156\145\137\166\x65\x72\151\x66\x79")) {
            goto BJ0;
        }
        $this->checkIfVerificationCodeNotEntered($uE, $Qh, $Xr);
        $this->checkIfVerificationNotStarted($Qh, $Xr);
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) == 0)) {
            goto SDV;
        }
        $this->processEmail($Qh, $Xr);
        SDV:
        if (!(strcasecmp($this->_otpType, $this->_typePhoneTag) == 0)) {
            goto hWA;
        }
        $this->processPhoneNumber($Qh, $Xr);
        hWA:
        if (!empty($Qh->get_invalid_fields())) {
            goto Eb2;
        }
        if (!$this->processOTPEntered($uE)) {
            goto foW;
        }
        $this->unsetOTPSessionVariables();
        goto bX4;
        foW:
        $Qh->invalidate($Xr, MoUtility::_get_invalid_otp_method());
        bX4:
        Eb2:
        BJ0:
        return $Qh;
    }
    function handle_failed_verification($wE, $MQ, $TB, $au)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VERIFICATION_FAILED, $au);
    }
    function handle_post_verification($WE, $wE, $MQ, $eW, $TB, $HL, $au)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $au);
    }
    function processOTPEntered($uE)
    {
        $CN = $this->getVerificationType();
        $this->validateChallenge($CN, $uE, NULL);
        return SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $CN);
    }
    function processEmail(&$Qh, $Xr)
    {
        if (SessionUtils::isEmailSubmittedAndVerifiedMatch($this->_formSessionVar)) {
            goto xeM;
        }
        $Qh->invalidate($Xr, mo_(MoMessages::showMessage(MoMessages::EMAIL_MISMATCH)));
        xeM:
    }
    function processPhoneNumber(&$Qh, $Xr)
    {
        if (Sessionutils::isPhoneSubmittedAndVerifiedMatch($this->_formSessionVar)) {
            goto HbJ;
        }
        $Qh->invalidate($Xr, mo_(MoMessages::showMessage(MoMessages::PHONE_MISMATCH)));
        HbJ:
    }
    function checkIfVerificationNotStarted(&$Qh, $Xr)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto uq_;
        }
        $Qh->invalidate($Xr, mo_(MoMessages::showMessage(MoMessages::PLEASE_VALIDATE)));
        uq_:
    }
    function checkIfVerificationCodeNotEntered($uE, &$Qh, $Xr)
    {
        if (MoUtility::sanitizeCheck($uE, $_REQUEST)) {
            goto vc6;
        }
        $Qh->invalidate($Xr, wpcf7_get_message("\x69\x6e\166\x61\x6c\x69\144\137\x72\145\x71\165\151\162\x65\x64"));
        vc6:
    }
    function _cf7_email_shortcode($QH)
    {
        $a4 = MoUtility::sanitizeCheck("\153\x65\x79", $QH);
        $It = MoUtility::sanitizeCheck("\142\x75\164\x74\x6f\156\x69\x64", $QH);
        $cN = MoUtility::sanitizeCheck("\155\145\163\163\141\x67\x65\x64\x69\166", $QH);
        $a4 = $a4 ? "\43" . $a4 : "\x69\x6e\160\x75\x74\133\156\x61\155\145\x3d\x27" . $this->_emailKey . "\x27\x5d";
        $It = $It ? $It : "\x6d\x69\x6e\151\x6f\162\x61\156\147\145\137\x6f\164\x70\x5f\164\157\153\145\x6e\x5f\163\x75\142\155\151\164";
        $cN = $cN ? $cN : "\155\157\137\x6d\x65\163\163\x61\147\x65";
        $G0 = "\74\144\151\166\40\163\x74\171\154\x65\75\47\x64\x69\x73\x70\x6c\141\171\72\x74\x61\x62\154\145\x3b\x74\145\170\x74\55\141\x6c\151\147\x6e\72\143\145\156\164\x65\x72\73\x27\x3e" . "\74\151\155\x67\x20\x73\162\x63\75\47" . MOV_URL . "\x69\156\143\x6c\x75\144\145\x73\x2f\x69\155\x61\147\145\163\57\154\x6f\x61\x64\145\162\56\147\x69\x66\x27\76" . "\74\57\x64\x69\x76\x3e";
        $YE = "\74\x73\143\x72\151\x70\164\76" . "\x6a\121\165\145\162\x79\x28\144\x6f\143\165\155\x65\x6e\164\x29\x2e\x72\145\141\144\171\x28\x66\165\x6e\143\x74\x69\157\x6e\x28\51\x7b" . "\x24\x6d\x6f\x3d\x6a\x51\165\145\162\x79\x3b" . "\44\x6d\x6f\50\x20\42\43" . $It . "\42\40\x29\x2e\145\x61\x63\x68\50\x66\x75\x6e\x63\x74\x69\x6f\156\50\151\156\x64\145\x78\51\x20\173" . "\x24\x6d\157\x28\164\150\x69\x73\x29\x2e\x6f\156\50\x22\143\x6c\x69\x63\153\42\x2c\40\x66\165\156\143\164\151\x6f\x6e\x28\51\173" . "\x76\141\162\40\x74\40\75\x20\x24\155\157\x28\164\x68\151\163\x29\56\x63\x6c\157\x73\x65\163\164\x28\x22\x66\157\162\155\x22\x29\73" . "\166\x61\x72\x20\x65\40\x3d\x20\x74\x2e\x66\x69\x6e\144\x28\x22" . $a4 . "\x22\51\56\x76\141\x6c\50\51\x3b" . "\166\x61\x72\x20\x6e\40\75\40\x74\56\146\x69\x6e\144\50\x22\151\156\160\165\x74\133\156\141\x6d\x65\75\47\145\x6d\141\151\154\137\166\145\162\151\x66\171\x27\135\x22\51\73" . "\x76\x61\162\40\x64\x20\75\40\164\56\x66\x69\x6e\x64\x28\42\43" . $cN . "\x22\x29\73" . "\x64\x2e\x65\155\x70\x74\x79\x28\51\x3b" . "\x64\56\x61\160\160\x65\156\x64\x28\x22" . $G0 . "\x22\x29\73" . "\x64\x2e\x73\150\x6f\167\50\x29\73" . "\x24\x6d\x6f\x2e\141\152\141\170\x28\x7b" . "\x75\162\x6c\x3a\x22" . wp_ajax_url() . "\x22\54" . "\164\171\160\145\72\42\x50\x4f\123\124\x22\54" . "\x64\x61\x74\x61\x3a\x7b" . "\165\x73\145\162\137\x65\x6d\141\x69\x6c\x3a\x65\54" . "\141\x63\164\151\x6f\x6e\72\42" . $this->_generateOTPAction . "\x22\x2c" . $this->_nonceKey . "\x3a\x22" . wp_create_nonce($this->_nonce) . "\42" . "\x7d\54" . "\143\x72\x6f\x73\163\104\157\155\141\151\x6e\x3a\41\x30\54" . "\x64\141\x74\141\x54\x79\x70\145\72\42\x6a\x73\x6f\156\42\54" . "\x73\165\x63\x63\x65\163\x73\72\x66\x75\x6e\143\x74\151\157\156\x28\157\x29\x7b\x20" . "\151\x66\50\x6f\x2e\162\x65\163\165\x6c\x74\x3d\75\42\x73\165\x63\143\x65\163\x73\42\51\173" . "\x64\x2e\x65\155\160\x74\x79\50\51\x2c" . "\x64\x2e\141\x70\x70\x65\156\144\50\157\x2e\x6d\x65\x73\163\141\147\x65\51\x2c" . "\144\x2e\143\x73\163\50\42\x62\157\x72\x64\145\162\55\164\x6f\x70\42\x2c\x22\63\160\x78\x20\163\x6f\x6c\x69\x64\40\x67\x72\x65\x65\156\x22\51\54" . "\156\x2e\146\157\143\165\163\50\x29" . "\175\145\154\163\x65\173" . "\x64\x2e\145\x6d\160\164\x79\x28\51\54" . "\x64\x2e\141\x70\160\x65\x6e\144\50\x6f\56\155\x65\163\163\x61\x67\x65\51\54" . "\144\56\143\163\x73\x28\42\142\157\162\144\145\x72\55\x74\x6f\x70\42\x2c\x22\x33\160\170\x20\163\157\x6c\x69\144\x20\162\x65\x64\42\x29" . "\175" . "\x7d\54" . "\145\x72\162\x6f\x72\72\x66\x75\x6e\143\x74\x69\x6f\156\50\x6f\54\x65\x2c\x6e\x29\x7b\x7d" . "\x7d\x29" . "\175\x29\73" . "\175\51\x3b" . "\175\51\x3b" . "\74\x2f\163\x63\162\x69\x70\x74\x3e";
        return $YE;
    }
    function _cf7_phone_shortcode($QH)
    {
        $rT = MoUtility::sanitizeCheck("\153\145\x79", $QH);
        $It = MoUtility::sanitizeCheck("\142\x75\x74\164\x6f\156\151\x64", $QH);
        $cN = MoUtility::sanitizeCheck("\155\145\163\x73\x61\x67\145\x64\x69\x76", $QH);
        $rT = $rT ? "\x23" . $rT : "\151\156\x70\165\x74\133\156\141\x6d\x65\x3d\x27" . $this->_phoneKey . "\47\135";
        $It = $It ? $It : "\155\151\x6e\x69\157\x72\141\x6e\147\x65\x5f\157\x74\160\x5f\164\x6f\153\145\x6e\x5f\163\x75\142\x6d\x69\164";
        $cN = $cN ? $cN : "\x6d\x6f\137\x6d\x65\x73\163\141\147\145";
        $G0 = "\x3c\x64\x69\166\40\x73\164\171\x6c\145\75\47\144\x69\x73\x70\x6c\141\171\x3a\164\141\142\154\x65\73\x74\145\170\x74\x2d\x61\x6c\151\x67\156\72\x63\145\x6e\x74\x65\x72\73\x27\x3e" . "\x3c\x69\155\x67\x20\163\162\143\x3d\x27" . MOV_URL . "\151\x6e\143\154\x75\x64\x65\163\x2f\151\155\141\147\x65\x73\x2f\154\x6f\x61\x64\145\x72\56\147\x69\x66\47\x3e" . "\74\x2f\x64\x69\x76\76";
        $YE = "\74\x73\x63\162\x69\160\164\76" . "\x6a\121\165\x65\162\171\x28\x64\x6f\x63\165\155\x65\x6e\164\51\56\x72\x65\141\144\171\x28\146\165\x6e\x63\x74\151\157\156\50\51\173" . "\44\155\x6f\x3d\152\x51\165\x65\162\171\73\x24\x6d\x6f\x28\x20\42\x23" . $It . "\42\x20\x29\56\x65\x61\x63\150\50\x66\165\156\x63\x74\x69\x6f\x6e\50\x69\156\x64\x65\x78\51\x20\173" . "\x24\x6d\x6f\50\x74\x68\x69\x73\51\x2e\157\156\x28\x22\143\x6c\x69\143\x6b\x22\54\x20\x66\165\156\143\x74\x69\157\x6e\50\x29\173" . "\x76\141\162\40\164\x20\75\40\x24\x6d\157\50\x74\150\151\163\51\x2e\143\154\157\163\x65\163\x74\50\42\146\157\x72\155\42\x29\x3b" . "\166\x61\x72\40\x65\40\75\x20\164\x2e\x66\151\156\144\x28\x22" . $rT . "\42\x29\x2e\x76\141\x6c\50\x29\73" . "\x76\141\162\x20\156\x20\x3d\40\164\56\x66\x69\156\144\x28\42\151\x6e\160\165\164\x5b\156\x61\x6d\145\x3d\x27\x70\x68\x6f\x6e\145\x5f\166\145\162\x69\x66\171\x27\x5d\x22\51\73" . "\x76\x61\x72\40\x64\40\x3d\40\x74\x2e\x66\151\156\x64\50\42\x23" . $cN . "\x22\x29\x3b" . "\144\56\x65\x6d\x70\x74\171\x28\51\x3b" . "\x64\56\141\x70\x70\x65\x6e\144\50\42" . $G0 . "\42\51\x3b" . "\144\x2e\163\150\x6f\x77\x28\51\73" . "\x24\155\x6f\56\x61\x6a\141\170\50\x7b" . "\165\162\x6c\72\42" . wp_ajax_url() . "\42\x2c" . "\x74\171\160\x65\72\x22\x50\x4f\x53\124\x22\54" . "\x64\x61\164\x61\x3a\x7b" . "\x75\x73\145\x72\137\160\150\x6f\x6e\x65\x3a\145\x2c" . "\141\x63\164\x69\x6f\x6e\72\42" . $this->_generateOTPAction . "\x22\x2c" . $this->_nonceKey . "\x3a\42" . wp_create_nonce($this->_nonce) . "\x22" . "\x7d\54" . "\x63\162\157\x73\163\x44\157\155\141\x69\156\72\x21\60\x2c" . "\144\x61\x74\x61\x54\x79\160\x65\x3a\42\x6a\163\x6f\x6e\42\x2c" . "\163\165\143\143\145\x73\x73\x3a\146\x75\x6e\x63\164\x69\x6f\156\x28\x6f\51\x7b\40" . "\x69\146\50\x6f\x2e\162\145\163\x75\x6c\x74\75\x3d\x22\x73\165\x63\x63\x65\163\x73\42\51\x7b" . "\x64\56\145\x6d\x70\x74\x79\50\51\54" . "\144\x2e\141\x70\x70\145\156\x64\x28\157\56\x6d\x65\x73\x73\x61\147\x65\51\x2c" . "\144\x2e\x63\163\163\50\x22\142\157\x72\x64\145\162\55\x74\157\x70\x22\x2c\x22\x33\x70\170\x20\x73\x6f\x6c\151\x64\40\x67\x72\145\145\156\42\51\54" . "\x6e\x2e\x66\157\143\x75\x73\50\51" . "\175\x65\x6c\163\x65\x7b" . "\144\56\145\155\160\164\x79\x28\51\54" . "\x64\56\x61\160\160\145\156\144\x28\157\56\155\x65\x73\163\x61\x67\145\x29\x2c" . "\144\x2e\x63\163\x73\x28\x22\142\157\x72\x64\x65\162\55\x74\x6f\x70\42\54\x22\63\x70\x78\40\163\x6f\154\x69\x64\x20\x72\x65\144\42\x29" . "\x7d" . "\x7d\54" . "\x65\162\162\x6f\x72\x3a\x66\165\x6e\143\x74\x69\x6f\x6e\x28\x6f\54\x65\54\x6e\51\173\175" . "\x7d\51" . "\x7d\51\73" . "\x7d\x29\x3b" . "\175\x29\73" . "\74\57\163\143\x72\151\160\164\76";
        return $YE;
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($sq)
    {
        if (!($this->_isFormEnabled && $this->_otpType == $this->_typePhoneTag)) {
            goto iQz;
        }
        $sq = array_merge($sq, $this->_phoneFormId);
        iQz:
        return $sq;
    }
    private function emailKeyValidationCheck()
    {
        if (!($this->_otpType === $this->_typeEmailTag && MoUtility::isBlank($this->_emailKey))) {
            goto nEx;
        }
        do_action("\x6d\x6f\137\162\145\147\151\163\164\x72\x61\x74\151\157\x6e\x5f\x73\x68\157\x77\137\x6d\x65\163\163\141\147\145", MoMessages::showMessage(BaseMessages::CF7_PROVIDE_EMAIL_KEY), MoConstants::ERROR);
        return false;
        nEx:
        return true;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto Src;
        }
        return;
        Src:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x63\146\67\137\143\x6f\156\x74\141\x63\164\137\145\x6e\141\142\154\x65");
        $this->_otpType = $this->sanitizeFormPOST("\143\x66\67\x5f\x63\157\x6e\x74\x61\143\164\137\x74\x79\160\145");
        $this->_emailKey = $this->sanitizeFormPOST("\143\x66\67\x5f\x65\155\141\151\x6c\x5f\x66\151\x65\x6c\x64\x5f\x6b\x65\171");
        if (!($this->basicValidationCheck(BaseMessages::CF7_CHOOSE) && $this->emailKeyValidationCheck())) {
            goto eKr;
        }
        update_mo_option("\143\x66\x37\137\x63\x6f\156\x74\141\x63\x74\137\x65\x6e\x61\x62\154\x65", $this->_isFormEnabled);
        update_mo_option("\143\x66\67\x5f\x63\157\156\164\141\x63\164\137\164\x79\x70\145", $this->_otpType);
        update_mo_option("\143\x66\67\137\x65\x6d\141\x69\x6c\x5f\x6b\145\171", $this->_emailKey);
        eKr:
    }
}
