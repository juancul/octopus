<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoPHPSessions;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationLogic;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
class UserProfileMadeEasyRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::UPME_REG;
        $this->_typePhoneTag = "\x6d\157\137\x75\x70\x6d\145\x5f\160\150\157\x6e\x65\137\x65\x6e\141\142\x6c\x65";
        $this->_typeEmailTag = "\155\x6f\137\165\160\x6d\145\137\x65\x6d\141\151\154\x5f\x65\x6e\x61\x62\x6c\x65";
        $this->_typeBothTag = "\155\x6f\x5f\165\160\x6d\145\x5f\142\157\164\x68\137\x65\x6e\x61\142\x6c\x65";
        $this->_formKey = "\125\120\115\105\x5f\106\x4f\122\115";
        $this->_formName = mo_("\x55\163\145\162\120\x72\157\146\x69\x6c\145\x20\115\x61\x64\145\40\x45\x61\x73\171\40\122\x65\x67\x69\x73\x74\x72\141\164\151\x6f\x6e\40\106\157\162\155");
        $this->_isFormEnabled = get_mo_option("\165\160\155\145\137\144\145\x66\141\165\154\x74\137\145\156\141\142\154\x65");
        $this->_formDocuments = MoOTPDocs::UPME_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\165\160\155\x65\137\x65\156\141\x62\x6c\145\x5f\164\x79\160\145");
        $this->_phoneKey = get_mo_option("\x75\160\155\145\137\x70\150\x6f\156\145\137\153\145\171");
        $this->_phoneFormId = "\x69\156\x70\x75\x74\x5b\x6e\x61\155\x65\75" . $this->_phoneKey . "\135";
        add_filter("\151\156\163\x65\x72\164\x5f\x75\x73\x65\x72\x5f\155\x65\164\x61", array($this, "\x6d\x69\156\151\x6f\x72\141\x6e\147\x65\137\x75\160\155\145\x5f\151\156\x73\x65\162\x74\137\x75\x73\x65\162"), 1, 3);
        add_filter("\x75\x70\x6d\x65\x5f\x72\145\x67\x69\163\164\162\141\x74\151\x6f\x6e\x5f\143\165\163\164\157\x6d\137\146\151\x65\x6c\144\137\164\x79\x70\145\x5f\x72\145\x73\x74\162\151\143\x74\151\157\156\163", array($this, "\x6d\151\156\x69\x6f\162\x61\156\x67\x65\x5f\x75\160\x6d\x65\x5f\x63\150\145\x63\x6b\x5f\160\150\157\x6e\145"), 1, 2);
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto Vg;
        }
        if (array_key_exists("\x75\x70\x6d\145\x2d\162\x65\147\x69\163\164\x65\162\55\x66\x6f\x72\x6d", $_POST) && !SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto yK;
        }
        goto DO1;
        Vg:
        $this->unsetOTPSessionVariables();
        goto DO1;
        yK:
        $this->_handle_upme_form_submit($_POST);
        DO1:
    }
    function isPhoneVerificationEnabled()
    {
        $CN = $this->getVerificationType();
        return $CN === VerificationType::PHONE || $CN === VerificationType::BOTH;
    }
    function _handle_upme_form_submit($xN)
    {
        $Pn = '';
        foreach ($xN as $O5 => $Xd) {
            if (!($O5 == $this->_phoneKey)) {
                goto w0;
            }
            $Pn = $Xd;
            goto d5;
            w0:
            vS:
        }
        d5:
        $this->miniorange_upme_user($_POST["\165\163\x65\162\x5f\154\x6f\147\151\156"], $_POST["\x75\163\145\162\137\145\155\141\x69\154"], $Pn);
    }
    function miniorange_upme_insert_user($M5, $user, $Bx)
    {
        $iM = MoPHPSessions::getSessionVar("\x66\x69\154\x65\x5f\x75\160\154\157\141\x64");
        if (!(!SessionUtils::isOTPInitialized($this->_formSessionVar) || !$iM)) {
            goto Gz;
        }
        return $M5;
        Gz:
        foreach ($iM as $O5 => $Xd) {
            $PC = get_user_meta($user->ID, $O5, true);
            if (!('' != $PC)) {
                goto vt;
            }
            upme_delete_uploads_folder_files($PC);
            vt:
            update_user_meta($user->ID, $O5, $Xd);
            Dn:
        }
        Ba:
        return $M5;
    }
    function miniorange_upme_check_phone($errors, $K_)
    {
        global $phoneLogic;
        if (!empty($errors)) {
            goto mx;
        }
        if (!($K_["\x6d\145\x74\141"] == $this->_phoneKey)) {
            goto J7;
        }
        if (MoUtility::validatePhoneNumber($K_["\166\141\154\x75\145"])) {
            goto M3;
        }
        $errors[] = str_replace("\43\43\x70\x68\x6f\x6e\x65\x23\43", $K_["\166\x61\154\165\x65"], $phoneLogic->_get_otp_invalid_format_message());
        M3:
        J7:
        mx:
        return $errors;
    }
    function miniorange_upme_user($uK, $MQ, $TB)
    {
        global $upme_register;
        $upme_register->prepare($_POST);
        $upme_register->handle();
        $iM = array();
        if (MoUtility::isBlank($upme_register->errors)) {
            goto xA;
        }
        return;
        xA:
        MoUtility::initialize_transaction($this->_formSessionVar);
        $this->processFileUpload($iM);
        MoPHPSessions::addSessionVar("\146\151\x6c\x65\137\165\x70\x6c\157\x61\144", $iM);
        $this->processAndStartOTPVerification($uK, $MQ, $TB);
    }
    function processFileUpload(&$iM)
    {
        if (!empty($_FILES)) {
            goto q7;
        }
        return;
        q7:
        $xd = wp_upload_dir();
        $aS = $xd["\142\141\x73\x65\144\151\x72"] . "\x2f\x75\x70\155\145\x2f";
        if (is_dir($aS)) {
            goto EJ;
        }
        mkdir($aS, 511);
        EJ:
        foreach ($_FILES as $O5 => $Dv) {
            $oj = sanitize_file_name(basename($Dv["\x6e\x61\x6d\145"]));
            $aS = $aS . time() . "\x5f" . $oj;
            $A0 = $xd["\142\x61\163\x65\x75\162\154"] . "\57\165\x70\x6d\145\x2f";
            $A0 = $A0 . time() . "\x5f" . $oj;
            move_uploaded_file($Dv["\164\155\160\x5f\x6e\141\x6d\x65"], $aS);
            $iM[$O5] = $A0;
            Ym:
        }
        lM:
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($sq)
    {
        if (!($this->isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto S0;
        }
        array_push($sq, $this->_phoneFormId);
        S0:
        return $sq;
    }
    function handle_failed_verification($wE, $MQ, $TB, $au)
    {
        $CN = $this->getVerificationType();
        $Ta = $CN === VerificationType::BOTH ? TRUE : FALSE;
        miniorange_site_otp_validation_form($wE, $MQ, $TB, MoUtility::_get_invalid_otp_method(), $CN, $Ta);
    }
    function handle_post_verification($WE, $wE, $MQ, $eW, $TB, $HL, $au)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $au);
    }
    function processAndStartOTPVerification($uK, $MQ, $TB)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto iH;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) == 0) {
            goto Fq;
        }
        $this->sendChallenge($uK, $MQ, null, $TB, VerificationType::EMAIL);
        goto fS;
        Fq:
        $this->sendChallenge($uK, $MQ, null, $TB, VerificationType::BOTH);
        fS:
        goto f6;
        iH:
        $this->sendChallenge($uK, $MQ, null, $TB, VerificationType::PHONE);
        f6:
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto Ip;
        }
        return;
        Ip:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x75\x70\x6d\145\x5f\x64\x65\146\141\165\x6c\x74\137\x65\x6e\141\x62\x6c\145");
        $this->_otpType = $this->sanitizeFormPOST("\165\160\155\145\137\x65\x6e\x61\x62\154\x65\x5f\x74\171\x70\145");
        $this->_phoneKey = $this->sanitizeFormPOST("\x75\x70\x6d\x65\x5f\160\x68\x6f\156\145\x5f\x66\151\x65\x6c\144\137\x6b\145\x79");
        update_mo_option("\x75\160\x6d\145\137\x64\x65\146\x61\x75\154\164\137\x65\x6e\x61\x62\154\145", $this->_isFormEnabled);
        update_mo_option("\165\160\155\145\137\145\156\141\x62\154\145\137\164\x79\x70\x65", $this->_otpType);
        update_mo_option("\x75\160\x6d\145\x5f\160\x68\x6f\156\x65\137\x6b\x65\x79", $this->_phoneKey);
    }
}
