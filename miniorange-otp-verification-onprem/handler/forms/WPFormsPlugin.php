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
class WPFormsPlugin extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::WPFORM;
        $this->_phoneFormId = array();
        $this->_formKey = "\x57\120\x46\x4f\122\115\123";
        $this->_typePhoneTag = "\155\x6f\x5f\x77\160\146\x6f\162\x6d\137\x70\150\157\x6e\x65\x5f\145\156\141\x62\x6c\x65";
        $this->_typeEmailTag = "\155\x6f\x5f\167\160\146\x6f\162\x6d\x5f\x65\x6d\x61\x69\154\x5f\x65\x6e\x61\142\x6c\x65";
        $this->_typeBothTag = "\x6d\x6f\137\x77\160\146\x6f\x72\155\137\142\x6f\164\x68\137\145\156\141\142\154\x65";
        $this->_formName = mo_("\x57\x50\x46\157\162\x6d\x73");
        $this->_isFormEnabled = get_mo_option("\167\x70\x66\157\162\155\x5f\x65\x6e\141\142\x6c\x65");
        $this->_buttonText = get_mo_option("\x77\x70\x66\x6f\x72\155\163\x5f\x62\x75\x74\x74\157\156\137\164\145\x78\x74");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\x53\x65\156\144\40\x4f\124\x50");
        $this->_generateOTPAction = "\x6d\x69\x6e\151\x6f\x72\x61\156\x67\x65\x2d\x77\x70\x66\157\x72\x6d\55\163\145\156\144\55\x6f\164\x70";
        $this->_validateOTPAction = "\x6d\151\156\x69\x6f\x72\141\156\x67\x65\55\x77\x70\x66\157\x72\155\x2d\166\145\x72\151\x66\171\x2d\143\x6f\x64\x65";
        $this->_formDocuments = MoOTPDocs::WP_FORMS_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x77\160\x66\157\162\155\x5f\x65\x6e\141\142\154\x65\137\164\x79\x70\145");
        $this->_formDetails = maybe_unserialize(get_mo_option("\167\160\146\x6f\x72\155\137\x66\x6f\162\x6d\x73"));
        if (!empty($this->_formDetails)) {
            goto SS;
        }
        return;
        SS:
        if (!($this->_otpType === $this->_typePhoneTag || $this->_otpType === $this->_typeBothTag)) {
            goto X2;
        }
        foreach ($this->_formDetails as $O5 => $Xd) {
            array_push($this->_phoneFormId, "\43\167\160\146\157\162\155\163\55" . $O5 . "\55\x66\151\145\154\x64\137" . $Xd["\x70\150\x6f\x6e\145\153\x65\x79"]);
            Tu:
        }
        vH:
        X2:
        add_filter("\x77\x70\146\x6f\x72\155\163\x5f\160\x72\x6f\143\x65\163\x73\x5f\151\156\x69\164\151\141\154\x5f\145\x72\x72\157\162\x73", array($this, "\166\141\x6c\x69\144\141\x74\145\106\157\162\155"), 1, 2);
        add_action("\x77\160\x5f\145\156\161\x75\145\165\145\137\163\x63\162\151\x70\x74\163", array($this, "\155\x6f\137\145\x6e\x71\x75\145\x75\145\137\x77\160\146\157\162\x6d\x73"));
        add_action("\x77\x70\x5f\141\x6a\141\x78\137{$this->_generateOTPAction}", array($this, "\x5f\x73\145\x6e\144\137\x6f\164\160"));
        add_action("\x77\160\x5f\141\152\x61\170\x5f\156\157\x70\162\151\x76\137{$this->_generateOTPAction}", array($this, "\x5f\x73\x65\x6e\x64\137\x6f\164\x70"));
        add_action("\x77\160\x5f\x61\152\141\170\x5f{$this->_validateOTPAction}", array($this, "\160\x72\157\x63\145\x73\163\106\157\x72\x6d\101\156\144\x56\141\x6c\151\x64\141\x74\145\117\124\120"));
        add_action("\167\x70\137\141\x6a\x61\170\137\x6e\157\x70\162\151\166\137{$this->_validateOTPAction}", array($this, "\x70\x72\157\x63\x65\x73\x73\106\157\162\155\101\x6e\x64\126\x61\x6c\x69\144\x61\x74\x65\117\x54\x50"));
    }
    function mo_enqueue_wpforms()
    {
        wp_register_script("\155\157\167\160\x66\157\162\x6d\163", MOV_URL . "\151\156\143\x6c\x75\144\x65\163\57\152\x73\57\x6d\157\x77\x70\146\157\162\x6d\163\x2e\x6d\x69\156\x2e\152\163", array("\152\161\x75\145\x72\x79"));
        wp_localize_script("\x6d\157\x77\x70\x66\x6f\x72\155\x73", "\155\x6f\x77\x70\x66\x6f\162\x6d\x73", array("\163\151\x74\145\x55\122\x4c" => wp_ajax_url(), "\x6f\x74\x70\x54\171\160\145" => $this->ajaxProcessingFields(), "\x66\157\x72\x6d\x44\145\x74\x61\151\x6c\163" => $this->_formDetails, "\142\x75\x74\x74\157\x6e\x74\x65\x78\164" => $this->_buttonText, "\166\x61\154\151\144\x61\164\145\144" => $this->getSessionDetails(), "\x69\155\147\x55\122\114" => MOV_LOADER_URL, "\x66\x69\145\x6c\x64\124\x65\170\x74" => mo_("\105\x6e\164\145\x72\40\117\x54\x50\x20\x68\x65\x72\x65"), "\147\x6e\x6f\x6e\143\x65" => wp_create_nonce($this->_nonce), "\x6e\x6f\x6e\x63\145\113\x65\x79" => wp_create_nonce($this->_nonceKey), "\166\156\157\156\x63\x65" => wp_create_nonce($this->_nonce), "\147\x61\x63\164\x69\x6f\x6e" => $this->_generateOTPAction, "\166\x61\143\164\x69\157\156" => $this->_validateOTPAction));
        wp_enqueue_script("\155\157\167\x70\x66\x6f\x72\155\x73");
    }
    function getSessionDetails()
    {
        return array(VerificationType::EMAIL => SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, VerificationType::EMAIL), VerificationType::PHONE => SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, VerificationType::PHONE));
    }
    function _send_otp()
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if ("\x6d\x6f\137\x77\160\x66\x6f\162\x6d\137" . $_POST["\157\164\x70\124\171\160\145"] . "\x5f\145\156\141\142\154\145" === $this->_typePhoneTag) {
            goto T5;
        }
        $this->_processEmailAndSendOTP($_POST);
        goto lE;
        T5:
        $this->_processPhoneAndSendOTP($_POST);
        lE:
    }
    private function _processEmailAndSendOTP($tT)
    {
        if (!MoUtility::sanitizeCheck("\x75\x73\145\162\x5f\145\x6d\141\x69\x6c", $tT)) {
            goto LL;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $tT["\165\163\x65\162\x5f\x65\x6d\x61\x69\154"]);
        $this->sendChallenge('', $tT["\165\x73\x65\x72\x5f\145\x6d\x61\151\154"], NULL, NULL, VerificationType::EMAIL);
        goto hb;
        LL:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        hb:
    }
    private function _processPhoneAndSendOTP($tT)
    {
        if (!MoUtility::sanitizeCheck("\165\163\x65\162\x5f\x70\150\157\156\x65", $tT)) {
            goto kh;
        }
        SessionUtils::addPhoneVerified($this->_formSessionVar, $tT["\165\x73\x65\162\137\160\150\x6f\156\145"]);
        $this->sendChallenge('', NULL, NULL, $tT["\x75\163\x65\x72\x5f\160\x68\157\x6e\145"], VerificationType::PHONE);
        goto iw;
        kh:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        iw:
    }
    function processFormAndValidateOTP()
    {
        $this->validateAjaxRequest();
        $this->checkIfOTPSent();
        $this->checkIntegrityAndValidateOTP($_POST);
    }
    function checkIfOTPSent()
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto rY;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE), MoConstants::ERROR_JSON_TYPE));
        rY:
    }
    private function checkIntegrityAndValidateOTP($tT)
    {
        $this->checkIntegrity($tT);
        $this->validateChallenge($tT["\157\164\x70\x54\171\160\x65"], NULL, $tT["\x6f\x74\160\x5f\164\x6f\153\145\156"]);
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $tT["\157\x74\160\124\x79\x70\145"])) {
            goto bQ;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::INVALID_OTP), MoConstants::ERROR_JSON_TYPE));
        goto rx;
        bQ:
        wp_send_json(MoUtility::createJson(MoConstants::SUCCESS_JSON_TYPE, MoConstants::SUCCESS_JSON_TYPE));
        rx:
    }
    private function checkIntegrity($tT)
    {
        if ($tT["\x6f\x74\x70\124\171\x70\145"] === "\160\x68\157\x6e\145") {
            goto Hw;
        }
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $tT["\x75\x73\145\x72\x5f\x65\155\x61\151\154"])) {
            goto LT;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::EMAIL_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        LT:
        goto oy;
        Hw:
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $tT["\x75\x73\145\162\137\160\150\157\x6e\x65"])) {
            goto gp;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        gp:
        oy:
    }
    public function validateForm($errors, $p8)
    {
        $HI = $p8["\x69\144"];
        if (array_key_exists($HI, $this->_formDetails)) {
            goto KW;
        }
        return $errors;
        KW:
        $p8 = $this->_formDetails[$HI];
        if (empty($errors)) {
            goto Pa;
        }
        return $errors;
        Pa:
        if (!($this->_otpType === $this->_typeEmailTag || $this->_otpType === $this->_typeBothTag)) {
            goto ju;
        }
        $errors = $this->processEmail($p8, $errors, $HI);
        ju:
        if (!($this->_otpType === $this->_typePhoneTag || $this->_otpType === $this->_typeBothTag)) {
            goto IZ;
        }
        $errors = $this->processPhone($p8, $errors, $HI);
        IZ:
        if (!empty($errors)) {
            goto G6;
        }
        $this->unsetOTPSessionVariables();
        G6:
        return $errors;
    }
    function processEmail($p8, $errors, $HI)
    {
        $B1 = $p8["\145\x6d\x61\151\154\x6b\x65\x79"];
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, VerificationType::EMAIL)) {
            goto Ew;
        }
        $errors[$HI][$B1] = MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE);
        Ew:
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $_POST["\x77\x70\146\x6f\x72\155\163"]["\x66\151\145\x6c\144\x73"][$B1])) {
            goto BW;
        }
        $errors[$HI][$B1] = MoMessages::showMessage(MoMessages::EMAIL_MISMATCH);
        BW:
        return $errors;
    }
    function processPhone($p8, $errors, $HI)
    {
        $B1 = $p8["\x70\150\157\156\145\153\145\171"];
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, VerificationType::PHONE)) {
            goto UJ;
        }
        $errors[$HI][$B1] = MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE);
        UJ:
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $_POST["\167\x70\146\157\x72\155\163"]["\x66\x69\x65\x6c\x64\163"][$B1])) {
            goto rX;
        }
        $errors[$HI][$B1] = MoMessages::showMessage(MoMessages::PHONE_MISMATCH);
        rX:
        return $errors;
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
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($sq)
    {
        if (!($this->_isFormEnabled && ($this->_otpType === $this->_typePhoneTag || $this->_otpType === $this->_typeBothTag))) {
            goto hz;
        }
        $sq = array_merge($sq, $this->_phoneFormId);
        hz:
        return $sq;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto oz;
        }
        return;
        oz:
        $form = $this->parseFormDetails();
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x77\160\146\x6f\x72\x6d\x5f\145\156\x61\x62\154\x65");
        $this->_otpType = $this->sanitizeFormPOST("\167\x70\x66\x6f\x72\x6d\x5f\145\x6e\x61\142\154\145\137\164\171\160\145");
        $this->_buttonText = $this->sanitizeFormPOST("\167\x70\x66\157\162\155\x73\x5f\x62\x75\164\x74\x6f\x6e\x5f\164\145\170\164");
        $this->_formDetails = !empty($form) ? $form : '';
        update_mo_option("\167\160\x66\157\x72\x6d\x5f\145\x6e\x61\142\x6c\145", $this->_isFormEnabled);
        update_mo_option("\167\x70\146\x6f\162\155\137\x65\x6e\141\142\154\145\x5f\164\x79\160\x65", $this->_otpType);
        update_mo_option("\167\x70\x66\157\x72\x6d\163\137\x62\x75\164\164\x6f\x6e\137\x74\145\170\x74", $this->_buttonText);
        update_mo_option("\167\160\x66\157\162\155\137\x66\157\x72\155\163", maybe_serialize($this->_formDetails));
    }
    function parseFormDetails()
    {
        $form = array();
        if (array_key_exists("\167\x70\146\157\x72\155\137\146\157\162\x6d", $_POST)) {
            goto jD;
        }
        return $form;
        jD:
        foreach (array_filter($_POST["\x77\160\146\157\162\155\137\x66\x6f\162\155"]["\146\x6f\x72\x6d"]) as $O5 => $Xd) {
            $p8 = $this->getFormDataFromID($Xd);
            if (!MoUtility::isBlank($p8)) {
                goto N5;
            }
            goto Ue;
            N5:
            $Xv = $this->getFieldIDs($_POST, $O5, $p8);
            $form[$Xd] = array("\x65\x6d\141\x69\x6c\153\145\x79" => $Xv["\x65\155\141\x69\x6c\x4b\x65\x79"], "\160\150\x6f\156\x65\x6b\x65\x79" => $Xv["\160\x68\x6f\x6e\x65\113\145\171"], "\x76\x65\162\151\146\x79\113\145\x79" => $Xv["\x76\x65\162\151\146\x79\x4b\145\x79"], "\160\x68\157\156\x65\x5f\x73\x68\157\167" => $_POST["\x77\x70\146\157\162\x6d\137\x66\x6f\162\x6d"]["\160\150\157\156\x65\153\x65\171"][$O5], "\x65\155\141\x69\x6c\x5f\163\150\x6f\x77" => $_POST["\x77\x70\x66\157\x72\x6d\137\146\157\x72\155"]["\x65\155\141\x69\154\153\x65\171"][$O5], "\166\145\162\x69\x66\x79\137\163\x68\157\167" => $_POST["\x77\160\146\x6f\x72\x6d\137\x66\x6f\162\x6d"]["\166\x65\x72\x69\x66\171\113\145\171"][$O5]);
            Ue:
        }
        Os:
        return $form;
    }
    private function getFormDataFromID($HI)
    {
        if (!Moutility::isBlank($HI)) {
            goto bO;
        }
        return '';
        bO:
        $form = get_post(absint($HI));
        if (!MoUtility::isBlank($HI)) {
            goto xS;
        }
        return '';
        xS:
        return wp_unslash(json_decode($form->post_content));
    }
    private function getFieldIDs($tT, $O5, $p8)
    {
        $Xv = array("\145\x6d\141\x69\154\x4b\145\x79" => '', "\x70\x68\157\156\145\113\x65\x79" => '', "\x76\145\162\x69\x66\x79\x4b\x65\171" => '');
        if (!empty($tT)) {
            goto jO;
        }
        return $Xv;
        jO:
        foreach ($p8->fields as $DH) {
            if (property_exists($DH, "\154\141\142\145\154")) {
                goto z1;
            }
            goto Qe;
            z1:
            if (!(strcasecmp($DH->label, $tT["\167\160\x66\x6f\162\x6d\137\146\157\x72\x6d"]["\x65\155\141\151\x6c\x6b\145\171"][$O5]) === 0)) {
                goto ZI;
            }
            $Xv["\145\155\141\151\154\x4b\145\171"] = $DH->id;
            ZI:
            if (!(strcasecmp($DH->label, $tT["\167\x70\x66\x6f\x72\x6d\x5f\x66\157\162\x6d"]["\x70\x68\157\156\x65\153\x65\x79"][$O5]) === 0)) {
                goto sJ;
            }
            $Xv["\160\x68\x6f\x6e\145\x4b\145\x79"] = $DH->id;
            sJ:
            if (!(strcasecmp($DH->label, $tT["\167\x70\146\x6f\x72\x6d\x5f\146\x6f\162\x6d"]["\x76\x65\162\151\x66\x79\113\145\171"][$O5]) === 0)) {
                goto gV;
            }
            $Xv["\166\x65\x72\151\x66\x79\113\145\171"] = $DH->id;
            gV:
            Qe:
        }
        ZK:
        return $Xv;
    }
}
