<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoConstants;
use OTP\Helper\MoException;
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
class WooCommerceRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    private $_redirectToPage;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_formSessionVar = FormSessionVars::WC_DEFAULT_REG;
        $this->_typePhoneTag = "\x6d\157\x5f\167\x63\137\x70\150\x6f\x6e\x65\x5f\x65\156\x61\x62\154\145";
        $this->_typeEmailTag = "\155\x6f\x5f\x77\143\x5f\145\155\x61\x69\154\x5f\145\x6e\141\x62\x6c\145";
        $this->_typeBothTag = "\155\x6f\137\x77\x63\x5f\x62\x6f\164\150\137\x65\x6e\x61\142\x6c\x65";
        $this->_phoneFormId = "\43\162\145\147\137\x62\x69\154\x6c\151\156\147\137\x70\x68\157\156\x65";
        $this->_formKey = "\x57\x43\x5f\x52\x45\x47\x5f\106\x4f\x52\115";
        $this->_formName = mo_("\127\x6f\157\143\157\x6d\155\145\x72\x63\145\x20\x52\145\x67\151\163\x74\x72\x61\164\x69\x6f\156\40\106\157\162\x6d");
        $this->_isFormEnabled = get_mo_option("\167\143\137\x64\x65\146\x61\x75\154\164\137\x65\x6e\141\142\x6c\145");
        $this->_buttonText = get_mo_option("\167\143\137\142\165\x74\164\x6f\x6e\x5f\164\145\170\x74");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\103\154\151\x63\x6b\x20\x48\145\x72\x65\x20\x74\157\x20\x73\x65\156\x64\40\x4f\x54\120");
        $this->_formDocuments = MoOTPDocs::WC_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_isAjaxForm = get_mo_option("\167\x63\137\151\x73\137\x61\152\141\170\137\146\157\162\155");
        $this->_otpType = get_mo_option("\167\143\x5f\x65\x6e\141\x62\x6c\145\x5f\x74\x79\160\x65");
        $this->_redirectToPage = get_mo_option("\x77\143\137\162\x65\144\x69\162\x65\143\164");
        $this->_restrictDuplicates = get_mo_option("\167\x63\137\x72\x65\163\164\x72\x69\143\x74\x5f\x64\x75\160\154\x69\143\141\164\x65\163");
        add_filter("\167\157\x6f\x63\x6f\x6d\155\x65\x72\x63\145\137\160\162\157\x63\145\163\x73\x5f\x72\x65\x67\151\x73\x74\162\x61\164\x69\157\156\x5f\145\162\162\157\162\x73", array($this, "\167\x6f\157\143\157\x6d\155\145\162\x63\x65\x5f\163\151\164\x65\x5f\162\x65\x67\x69\163\164\x72\x61\x74\151\157\x6e\x5f\x65\x72\162\157\x72\163"), 99, 4);
        add_action("\167\157\157\143\x6f\x6d\155\145\162\143\x65\137\x63\x72\x65\141\x74\145\144\x5f\143\x75\163\x74\x6f\x6d\x65\x72", array($this, "\162\x65\x67\x69\x73\164\145\162\x5f\x77\157\157\143\x6f\x6d\x6d\145\162\x63\145\137\x75\x73\x65\x72"), 1, 3);
        add_filter("\x77\x6f\x6f\x63\x6f\155\x6d\x65\162\143\145\x5f\x72\x65\147\151\163\x74\x72\x61\164\151\157\x6e\137\162\145\x64\x69\x72\145\143\164", array($this, "\143\x75\x73\164\157\x6d\137\162\x65\147\x69\x73\x74\162\141\x74\x69\157\x6e\137\162\145\144\151\162\145\143\164"), 99, 1);
        if (!$this->isPhoneVerificationEnabled()) {
            goto hx;
        }
        add_action("\167\x6f\157\x63\x6f\155\155\x65\x72\x63\x65\137\162\145\147\x69\x73\x74\145\162\137\x66\x6f\162\x6d", array($this, "\155\157\137\141\144\144\x5f\x70\150\x6f\156\x65\x5f\x66\151\x65\154\x64"), 1);
        add_action("\x77\143\x6d\x70\x5f\x76\145\156\x64\157\162\x5f\162\145\x67\151\x73\x74\x65\162\137\146\157\x72\x6d", array($this, "\x6d\x6f\137\141\x64\144\137\x70\150\x6f\156\x65\x5f\146\x69\145\154\x64"), 1);
        hx:
        if (!($this->_isAjaxForm && $this->_otpType != $this->_typeBothTag)) {
            goto tL;
        }
        add_action("\167\157\x6f\x63\x6f\x6d\155\x65\162\143\145\137\x72\145\x67\151\x73\164\145\162\x5f\146\157\162\x6d", array($this, "\x6d\157\137\141\x64\x64\x5f\166\145\x72\x69\x66\151\143\x61\x74\151\x6f\156\137\146\x69\x65\x6c\x64"), 1);
        add_action("\167\143\x6d\160\137\166\x65\x6e\x64\x6f\162\x5f\x72\x65\x67\x69\x73\164\145\x72\137\x66\157\x72\155", array($this, "\155\157\x5f\141\144\x64\137\166\145\x72\151\146\x69\143\x61\x74\151\157\x6e\x5f\146\x69\145\x6c\144"), 1);
        add_action("\167\x70\x5f\145\156\161\x75\145\165\145\137\163\143\162\151\160\x74\x73", array($this, "\155\151\x6e\151\157\162\x61\156\x67\145\x5f\162\x65\147\x69\x73\x74\x65\162\x5f\x77\143\137\163\143\x72\151\160\164"));
        $this->routeData();
        tL:
    }
    private function routeData()
    {
        if (array_key_exists("\x6f\160\x74\x69\157\156", $_GET)) {
            goto i0;
        }
        return;
        i0:
        switch (trim($_GET["\x6f\160\x74\151\157\x6e"])) {
            case "\x6d\x69\156\151\x6f\x72\x61\156\x67\145\55\167\x63\x2d\x72\x65\147\55\x76\145\x72\x69\x66\171":
                $this->sendAjaxOTPRequest();
                goto MP;
        }
        P9:
        MP:
    }
    private function sendAjaxOTPRequest()
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        $this->validateAjaxRequest();
        $Pn = MoUtility::sanitizeCheck("\x75\x73\x65\162\137\160\150\x6f\x6e\145", $_POST);
        $MQ = MoUtility::sanitizeCheck("\165\163\x65\x72\137\145\155\141\x69\x6c", $_POST);
        if ($this->_otpType === $this->_typePhoneTag) {
            goto R1;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $MQ);
        goto Ic1;
        R1:
        SessionUtils::addPhoneVerified($this->_formSessionVar, MoUtility::processPhoneNumber($Pn));
        Ic1:
        $zu = $this->processFormFields(null, $MQ, new WP_Error(), null, $Pn);
        if (!$zu->get_error_code()) {
            goto gfE;
        }
        wp_send_json(MoUtility::createJson($zu->get_error_message(), MoConstants::ERROR_JSON_TYPE));
        gfE:
    }
    function miniorange_register_wc_script()
    {
        wp_register_script("\155\x6f\167\143\162\145\147", MOV_URL . "\151\156\143\x6c\165\x64\x65\x73\57\152\163\57\167\143\x72\145\x67\x2e\155\151\x6e\56\x6a\163", array("\152\161\x75\x65\x72\x79"));
        wp_localize_script("\x6d\157\x77\x63\162\x65\x67", "\155\x6f\167\143\162\145\147", array("\x73\x69\164\145\x55\122\114" => site_url(), "\x6f\x74\160\124\x79\160\145" => $this->_otpType, "\x6e\x6f\x6e\x63\x65" => wp_create_nonce($this->_nonce), "\x62\x75\164\164\x6f\x6e\x74\x65\170\x74" => mo_($this->_buttonText), "\146\151\x65\x6c\144" => $this->_otpType === $this->_typePhoneTag ? "\x72\145\x67\x5f\142\x69\x6c\x6c\x69\x6e\147\137\x70\x68\x6f\x6e\145" : "\162\145\x67\137\x65\x6d\141\x69\154", "\151\x6d\x67\125\x52\114" => MOV_LOADER_URL));
        wp_enqueue_script("\155\157\x77\x63\162\145\147");
    }
    function custom_registration_redirect($h8)
    {
        return MoUtility::isBlank($h8) ? get_permalink(get_page_by_title($this->_redirectToPage)->ID) : $h8;
    }
    function isPhoneVerificationEnabled()
    {
        $CN = $this->getVerificationType();
        return $CN === VerificationType::BOTH || $CN === VerificationType::PHONE;
    }
    function woocommerce_site_registration_errors(WP_Error $errors, $EN, $eW, $Vy)
    {
        if (MoUtility::isBlank(array_filter($errors->errors))) {
            goto HN2;
        }
        return $errors;
        HN2:
        if ($this->_isAjaxForm) {
            goto mgJ;
        }
        return $this->processFormAndSendOTP($EN, $eW, $Vy, $errors);
        goto j8p;
        mgJ:
        $this->assertOTPField($errors, $_POST);
        $this->checkIfOTPWasSent($errors);
        return $this->checkIntegrityAndValidateOTP($_POST, $errors);
        j8p:
    }
    private function assertOTPField(&$errors, $Qd)
    {
        if (MoUtility::sanitizeCheck("\155\157\x76\145\162\151\146\171", $Qd)) {
            goto JZ_;
        }
        $errors = new WP_Error("\x72\145\147\x69\163\x74\x72\141\x74\151\157\156\55\x65\162\162\157\162\55\157\164\160\x2d\x6e\145\x65\x64\x65\x64", MoMessages::showMessage(MoMessages::REQUIRED_OTP));
        JZ_:
    }
    private function checkIfOTPWasSent(&$errors)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto EwP;
        }
        $errors = new WP_Error("\162\x65\x67\151\163\x74\162\x61\164\x69\x6f\x6e\55\145\x72\x72\x6f\x72\55\x6e\145\x65\x64\55\166\141\x6c\151\144\x61\x74\x69\x6f\156", MoMessages::showMessage(MoMessages::PLEASE_VALIDATE));
        EwP:
    }
    private function checkIntegrityAndValidateOTP($tT, WP_Error $errors)
    {
        if (empty($errors->errors)) {
            goto Wyr;
        }
        return $errors;
        Wyr:
        $tT["\142\151\154\x6c\151\x6e\x67\x5f\160\x68\x6f\156\145"] = MoUtility::processPhoneNumber($tT["\x62\x69\x6c\154\x69\x6e\147\x5f\160\150\157\156\145"]);
        $errors = $this->checkIntegrity($tT, $errors);
        if (empty($errors->errors)) {
            goto KoQ;
        }
        return $errors;
        KoQ:
        $CN = $this->getVerificationType();
        $this->validateChallenge($CN, NULL, $tT["\155\x6f\166\145\x72\151\x66\171"]);
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $CN)) {
            goto N3p;
        }
        return new WP_Error("\162\145\x67\151\x73\164\x72\x61\164\x69\x6f\156\x2d\x65\x72\x72\x6f\162\55\151\x6e\x76\141\x6c\151\x64\55\x6f\x74\160", MoUtility::_get_invalid_otp_method());
        goto agI;
        N3p:
        $this->unsetOTPSessionVariables();
        agI:
        return $errors;
    }
    private function checkIntegrity($tT, WP_Error $errors)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto wu5;
        }
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) == 0)) {
            goto xN8;
        }
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $tT["\145\155\141\x69\154"])) {
            goto IF6;
        }
        return new WP_Error("\162\145\x67\151\163\164\x72\141\164\x69\157\156\55\145\162\x72\157\162\55\151\x6e\x76\x61\x6c\x69\144\x2d\145\x6d\x61\151\154", MoMessages::showMessage(MoMessages::EMAIL_MISMATCH));
        IF6:
        xN8:
        goto l0G;
        wu5:
        if (Sessionutils::isPhoneVerifiedMatch($this->_formSessionVar, $tT["\x62\x69\154\154\151\x6e\147\137\x70\x68\157\156\x65"])) {
            goto NAG;
        }
        return new WP_Error("\x62\x69\x6c\x6c\151\156\147\137\160\x68\x6f\156\145\x5f\x65\162\x72\x6f\162", MoMessages::showMessage(MoMessages::PHONE_MISMATCH));
        NAG:
        l0G:
        return $errors;
    }
    private function processFormAndSendOTP($EN, $eW, $Vy, WP_Error $errors)
    {
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto cdM;
        }
        $this->unsetOTPSessionVariables();
        return $errors;
        cdM:
        MoUtility::initialize_transaction($this->_formSessionVar);
        try {
            $this->assertUserName($EN);
            $this->assertPassword($eW);
            $this->assertEmail($Vy);
        } catch (MoException $LN) {
            return new WP_Error($LN->getMoCode(), $LN->getMessage());
        }
        do_action("\167\x6f\157\x63\157\x6d\x6d\145\x72\x63\145\137\x72\145\147\151\163\164\145\162\137\x70\x6f\163\x74", $EN, $Vy, $errors);
        return $errors->get_error_code() ? $errors : $this->processFormFields($EN, $Vy, $errors, $eW, $_POST["\x62\151\154\154\x69\x6e\147\137\160\x68\x6f\156\145"]);
    }
    private function assertPassword($eW)
    {
        if (!(get_mo_option("\167\157\157\x63\x6f\x6d\x6d\145\x72\143\x65\137\162\x65\x67\151\x73\x74\x72\141\164\151\x6f\156\137\x67\x65\156\145\162\x61\164\x65\x5f\160\141\163\x73\x77\x6f\x72\144", '') === "\156\157")) {
            goto AIM;
        }
        if (!MoUtility::isBlank($eW)) {
            goto A1X;
        }
        throw new MoException("\x72\x65\147\151\x73\x74\x72\141\x74\x69\157\x6e\x2d\145\162\x72\157\162\55\x69\x6e\166\141\154\x69\144\x2d\160\141\x73\163\167\157\x72\144", mo_("\x50\x6c\x65\141\163\145\40\x65\156\164\145\162\40\x61\x20\x76\141\x6c\x69\x64\x20\x61\143\143\x6f\165\x6e\x74\x20\160\x61\x73\x73\167\157\162\144\x2e"), 204);
        A1X:
        AIM:
    }
    private function assertEmail($Vy)
    {
        if (!(MoUtility::isBlank($Vy) || !is_email($Vy))) {
            goto DT3;
        }
        throw new MoException("\162\145\147\151\x73\164\x72\x61\164\x69\x6f\156\55\x65\x72\x72\x6f\162\x2d\x69\156\166\x61\x6c\151\x64\x2d\x65\155\x61\151\x6c", mo_("\x50\154\x65\141\x73\x65\x20\x65\156\x74\145\162\40\141\x20\166\x61\x6c\x69\x64\x20\145\155\x61\x69\154\x20\141\x64\144\162\145\x73\163\56"), 202);
        DT3:
        if (!email_exists($Vy)) {
            goto ckM;
        }
        throw new MoException("\x72\145\147\x69\163\164\x72\141\164\x69\x6f\x6e\55\x65\x72\162\x6f\162\55\145\x6d\x61\x69\154\55\145\170\x69\163\164\x73", mo_("\101\x6e\x20\x61\x63\x63\157\x75\156\x74\x20\151\x73\x20\141\x6c\162\145\141\x64\x79\x20\162\145\x67\151\x73\164\x65\x72\x65\x64\40\x77\151\164\150\x20\171\x6f\165\162\40\x65\x6d\141\x69\x6c\40\141\x64\144\162\145\163\163\56\x20\x50\154\145\141\x73\x65\40\x6c\x6f\147\151\x6e\56"), 203);
        ckM:
    }
    private function assertUserName($EN)
    {
        if (!(get_mo_option("\167\157\157\143\157\155\155\145\x72\x63\145\x5f\x72\145\x67\x69\x73\x74\162\141\x74\151\157\156\x5f\147\x65\x6e\145\162\141\x74\x65\x5f\x75\x73\145\162\156\141\155\x65", '') === "\156\157")) {
            goto g1n;
        }
        if (!(MoUtility::isBlank($EN) || !validate_username($EN))) {
            goto AJD;
        }
        throw new MoException("\x72\145\147\x69\163\x74\162\141\x74\151\x6f\x6e\55\145\162\x72\x6f\162\55\x69\x6e\x76\x61\154\x69\144\55\x75\163\x65\162\156\141\155\145", mo_("\x50\154\x65\141\163\x65\x20\145\156\164\145\162\x20\x61\x20\166\x61\x6c\x69\x64\x20\x61\143\x63\157\x75\156\164\40\165\163\x65\162\156\x61\x6d\x65\x2e"), 200);
        AJD:
        if (!username_exists($EN)) {
            goto kEN;
        }
        throw new MoException("\162\x65\147\151\x73\x74\162\141\164\151\157\x6e\55\145\162\162\157\162\x2d\x75\x73\x65\x72\156\141\x6d\145\x2d\145\x78\x69\163\164\x73", mo_("\101\156\x20\x61\143\143\x6f\165\156\164\x20\151\x73\x20\x61\x6c\x72\145\141\144\x79\40\162\x65\x67\x69\x73\164\145\162\145\144\40\167\x69\x74\x68\40\164\x68\141\x74\40\165\x73\145\162\x6e\141\155\x65\x2e\x20\120\154\x65\x61\x73\145\x20\143\150\x6f\157\163\x65\40\141\156\157\164\x68\145\x72\x2e"), 201);
        kEN:
        g1n:
    }
    function processFormFields($EN, $Vy, $errors, $eW, $l1)
    {
        global $phoneLogic;
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0) {
            goto vHw;
        }
        if (strcasecmp($this->_otpType, $this->_typeEmailTag) === 0) {
            goto oBd;
        }
        if (!(strcasecmp($this->_otpType, $this->_typeBothTag) === 0)) {
            goto J19;
        }
        if (!(!isset($l1) || !MoUtility::validatePhoneNumber($l1))) {
            goto q1f;
        }
        return new WP_Error("\x62\151\154\x6c\151\156\x67\137\160\x68\x6f\156\x65\x5f\145\162\162\x6f\x72", str_replace("\x23\x23\x70\150\x6f\x6e\145\x23\43", $_POST["\x62\x69\154\x6c\x69\156\147\137\160\x68\157\x6e\145"], $phoneLogic->_get_otp_invalid_format_message()));
        q1f:
        $this->sendChallenge($EN, $Vy, $errors, $_POST["\x62\151\x6c\154\151\x6e\x67\x5f\160\x68\x6f\156\x65"], VerificationType::BOTH, $eW);
        J19:
        goto gYX;
        oBd:
        $l1 = isset($l1) ? $l1 : '';
        $this->sendChallenge($EN, $Vy, $errors, $l1, VerificationType::EMAIL, $eW);
        gYX:
        goto gjC;
        vHw:
        if (!isset($l1) || !MoUtility::validatePhoneNumber($l1)) {
            goto b2U;
        }
        if ($this->_restrictDuplicates && $this->isPhoneNumberAlreadyInUse($l1, "\x62\x69\154\154\151\156\147\137\160\x68\157\x6e\145")) {
            goto Cah;
        }
        goto fYO;
        b2U:
        return new WP_Error("\x62\x69\154\x6c\151\156\147\x5f\x70\x68\x6f\156\145\137\x65\x72\162\x6f\x72", str_replace("\43\x23\160\150\x6f\156\x65\43\x23", $l1, $phoneLogic->_get_otp_invalid_format_message()));
        goto fYO;
        Cah:
        return new WP_Error("\142\x69\x6c\x6c\151\x6e\x67\137\x70\x68\x6f\x6e\x65\137\x65\x72\162\x6f\x72", MoMessages::showMessage(MoMessages::PHONE_EXISTS));
        fYO:
        $this->sendChallenge($EN, $Vy, $errors, $l1, VerificationType::PHONE, $eW);
        gjC:
        return $errors;
    }
    public function register_woocommerce_user($Op, $sH, $up)
    {
        if (!isset($_POST["\x62\151\154\x6c\x69\156\x67\x5f\160\150\157\x6e\x65"])) {
            goto Q3h;
        }
        $l1 = MoUtility::sanitizeCheck("\142\151\154\154\x69\x6e\x67\137\160\x68\157\156\x65", $_POST);
        update_user_meta($Op, "\x62\151\154\154\151\x6e\147\137\x70\x68\x6f\x6e\145", MoUtility::processPhoneNumber($l1));
        Q3h:
    }
    function mo_add_phone_field()
    {
        if (!(!did_action("\167\157\157\143\x6f\155\155\x65\x72\143\145\x5f\162\x65\147\151\163\164\145\162\x5f\146\157\x72\x6d") || !did_action("\167\x63\155\x70\137\x76\x65\x6e\144\157\x72\137\x72\145\147\151\163\164\145\162\x5f\146\157\x72\155"))) {
            goto ghO;
        }
        echo "\x3c\x70\40\143\x6c\141\x73\163\x3d\x22\146\x6f\x72\x6d\x2d\162\157\x77\40\146\157\x72\155\55\162\x6f\167\55\x77\x69\x64\x65\x22\76\xa\40\x20\x20\40\40\40\40\40\40\x20\40\x20\x20\x20\x20\x20\74\154\x61\142\145\x6c\40\146\x6f\x72\75\42\x72\x65\147\x5f\x62\x69\x6c\x6c\151\x6e\x67\x5f\x70\150\x6f\x6e\145\x22\x3e\xa\40\x20\x20\40\40\40\x20\40\x20\40\40\x20\40\40\x20\40\40\x20\40\x20" . mo_("\x50\150\157\x6e\145") . "\12\40\40\40\40\40\40\40\40\40\40\40\x20\40\40\x20\40\x20\40\x20\x20\x3c\x73\160\141\x6e\40\143\x6c\x61\163\x73\75\x22\x72\145\x71\x75\151\x72\x65\144\42\x3e\x2a\74\57\163\160\141\156\76\12\x20\40\40\40\x20\x20\x20\40\40\x20\40\x20\40\40\40\40\74\57\x6c\x61\x62\145\x6c\76\xa\40\x20\40\40\x20\x20\x20\x20\x20\40\x20\x20\x20\x20\40\40\74\x69\x6e\x70\x75\x74\x20\x74\171\160\145\x3d\x22\164\x65\x78\164\x22\x20\x63\154\x61\x73\163\x3d\x22\151\156\160\165\164\55\164\145\x78\164\x22\40\12\x20\x20\x20\x20\x20\40\40\40\x20\40\40\40\40\x20\40\40\40\x20\x20\x20\40\x20\x20\40\156\x61\x6d\x65\75\x22\142\151\x6c\x6c\151\156\x67\x5f\160\150\x6f\156\x65\42\40\151\x64\x3d\x22\x72\x65\147\x5f\x62\151\154\x6c\151\156\x67\x5f\x70\150\157\156\x65\42\x20\xa\40\40\40\40\x20\x20\40\40\x20\40\x20\40\x20\40\x20\40\40\40\x20\x20\40\x20\40\x20\166\141\x6c\x75\x65\x3d\x22" . (!empty($_POST["\142\x69\x6c\x6c\151\x6e\x67\x5f\x70\x68\x6f\x6e\x65"]) ? $_POST["\x62\151\154\x6c\151\x6e\147\137\x70\x68\157\156\145"] : '') . "\x22\x20\x2f\x3e\12\x20\40\x20\40\x20\x20\40\x20\x20\x20\40\x20\40\x20\74\57\160\76";
        ghO:
    }
    function mo_add_verification_field()
    {
        echo "\74\160\x20\143\154\x61\163\163\75\42\146\157\x72\155\55\162\x6f\167\40\x66\x6f\162\155\x2d\x72\157\167\55\167\151\144\145\42\76\12\x20\40\x20\40\40\x20\40\40\x20\x20\40\40\40\x20\40\x20\74\x6c\x61\142\x65\x6c\x20\x66\x6f\162\x3d\42\162\x65\147\137\x76\145\162\x69\146\x69\143\x61\164\151\x6f\x6e\x5f\160\x68\157\x6e\x65\x22\76\xa\40\x20\40\x20\40\x20\40\40\40\40\40\40\40\40\40\40\x20\x20\x20\40" . mo_("\x45\x6e\164\145\x72\40\103\157\144\x65") . "\xa\x20\40\x20\x20\40\x20\x20\40\40\40\x20\40\x20\x20\40\40\40\x20\x20\x20\74\163\160\141\156\40\143\x6c\x61\x73\x73\x3d\42\x72\145\161\165\151\x72\x65\x64\42\76\x2a\x3c\x2f\x73\x70\x61\156\x3e\xa\x20\x20\x20\40\40\40\40\40\40\40\x20\40\40\40\x20\40\74\x2f\x6c\141\142\145\154\x3e\xa\40\x20\40\40\40\40\40\x20\40\40\40\40\x20\x20\40\40\74\x69\156\x70\x75\164\40\164\171\x70\145\x3d\x22\x74\x65\x78\x74\x22\40\x63\x6c\141\163\163\75\42\x69\156\160\165\x74\55\164\145\x78\x74\x22\40\x6e\141\155\145\75\x22\155\157\166\145\162\151\146\171\x22\40\xa\x20\x20\x20\40\x20\x20\40\40\40\40\x20\40\x20\x20\40\x20\x20\x20\40\x20\x20\40\40\x20\x69\144\75\42\x72\x65\x67\x5f\166\145\x72\151\146\151\x63\141\x74\x69\x6f\156\137\x66\x69\x65\154\144\42\40\xa\40\40\x20\40\40\x20\x20\40\x20\x20\x20\40\x20\40\x20\40\x20\40\x20\x20\x20\x20\40\x20\x76\141\154\x75\x65\75\x22\x22\40\57\76\12\x20\40\x20\40\x20\x20\x20\40\40\x20\40\40\x20\40\74\57\160\x3e";
    }
    function handle_failed_verification($wE, $MQ, $TB, $au)
    {
        if ($this->_isAjaxForm) {
            goto TbK;
        }
        $CN = $this->getVerificationType();
        $Ta = $CN === VerificationType::BOTH ? TRUE : FALSE;
        miniorange_site_otp_validation_form($wE, $MQ, $TB, MoUtility::_get_invalid_otp_method(), $CN, $Ta);
        goto dd7;
        TbK:
        SessionUtils::addStatus($this->_formSessionVar, self::VERIFICATION_FAILED, $au);
        dd7:
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
            goto CuU;
        }
        array_push($sq, $this->_phoneFormId);
        CuU:
        return $sq;
    }
    function isPhoneNumberAlreadyInUse($l1, $O5)
    {
        global $wpdb;
        $l1 = MoUtility::processPhoneNumber($l1);
        $KA = $wpdb->get_row("\123\105\114\105\x43\124\x20\x60\x75\163\x65\x72\137\151\x64\140\x20\106\122\117\x4d\x20\x60{$wpdb->prefix}\165\x73\x65\162\155\x65\164\141\x60\40\x57\x48\105\x52\105\x20\140\155\145\164\141\137\153\145\x79\x60\40\x3d\x20\x27{$O5}\x27\40\101\116\x44\x20\x60\155\x65\164\141\137\x76\141\154\165\x65\x60\x20\75\40\x20\47{$l1}\47");
        return !MoUtility::isBlank($KA);
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto NkT;
        }
        return;
        NkT:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x77\x63\x5f\144\145\x66\141\165\154\164\137\x65\x6e\141\x62\154\145");
        $this->_otpType = $this->sanitizeFormPOST("\167\143\x5f\145\x6e\141\x62\x6c\145\137\x74\171\160\145");
        $this->_restrictDuplicates = $this->sanitizeFormPOST("\167\x63\137\x72\x65\163\164\x72\151\x63\x74\x5f\x64\165\x70\154\151\143\141\x74\145\x73");
        $this->_redirectToPage = isset($_POST["\x70\141\x67\145\x5f\x69\144"]) ? get_the_title($_POST["\160\x61\x67\145\x5f\x69\x64"]) : "\115\171\x20\x41\143\x63\157\165\156\164";
        $this->_isAjaxForm = $this->sanitizeFormPOST("\167\143\137\x69\x73\137\x61\152\141\170\137\146\x6f\162\155");
        $this->_buttonText = $this->sanitizeFormPOST("\167\143\137\142\165\164\x74\157\156\137\x74\145\x78\x74");
        update_mo_option("\x77\x63\x5f\x64\x65\x66\x61\165\154\x74\x5f\x65\156\141\x62\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\167\x63\137\145\156\x61\142\x6c\x65\x5f\x74\171\x70\x65", $this->_otpType);
        update_mo_option("\167\x63\137\x72\x65\x73\x74\162\x69\143\x74\x5f\144\165\160\x6c\x69\143\x61\x74\145\163", $this->_restrictDuplicates);
        update_mo_option("\167\x63\137\162\145\x64\x69\162\x65\x63\x74", $this->_redirectToPage);
        update_mo_option("\167\x63\x5f\x69\163\x5f\x61\152\141\x78\x5f\146\x6f\x72\155", $this->_isAjaxForm);
        update_mo_option("\167\x63\x5f\142\x75\164\164\157\156\137\164\x65\x78\x74", $this->_buttonText);
    }
    public function redirectToPage()
    {
        return $this->_redirectToPage;
    }
}
