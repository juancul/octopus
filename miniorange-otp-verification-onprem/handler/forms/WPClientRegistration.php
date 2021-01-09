<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
use WP_Error;
class WPClientRegistration extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::WP_CLIENT_REG;
        $this->_phoneKey = "\x77\x70\x5f\x63\x6f\156\x74\141\x63\164\x5f\x70\150\157\x6e\x65";
        $this->_phoneFormId = "\x23\x77\160\143\137\x63\x6f\x6e\x74\141\x63\x74\137\x70\150\157\156\145";
        $this->_formKey = "\x57\x50\x5f\x43\x4c\x49\105\116\x54\137\122\x45\x47";
        $this->_typePhoneTag = "\155\157\137\167\x70\x5f\143\154\x69\x65\156\x74\x5f\x70\150\157\x6e\x65\137\x65\x6e\141\x62\154\145";
        $this->_typeEmailTag = "\x6d\x6f\x5f\167\x70\137\143\x6c\x69\145\156\x74\x5f\x65\155\141\151\x6c\x5f\145\x6e\x61\x62\x6c\145";
        $this->_typeBothTag = "\x6d\x6f\137\167\160\x5f\x63\x6c\x69\x65\x6e\164\137\142\157\x74\x68\137\x65\156\x61\x62\x6c\145";
        $this->_formName = mo_("\x57\120\40\103\x6c\151\145\156\164\x20\122\145\x67\x69\x73\164\162\141\x74\x69\x6f\156\x20\106\x6f\162\155");
        $this->_isFormEnabled = get_mo_option("\x77\x70\137\x63\x6c\151\x65\156\x74\137\x65\x6e\141\x62\154\145");
        $this->_formDocuments = MoOTPDocs::WP_CLIENT_FORM;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\167\x70\137\x63\x6c\x69\145\x6e\164\x5f\145\x6e\141\x62\x6c\x65\137\x74\x79\x70\x65");
        $this->_restrictDuplicates = get_mo_option("\x77\x70\137\143\154\151\x65\x6e\164\x5f\x72\145\163\x74\x72\151\143\x74\137\144\165\160\x6c\151\x63\x61\164\145\x73");
        add_filter("\167\x70\x63\x5f\x63\154\151\x65\x6e\164\137\162\145\147\x69\x73\164\x72\141\164\x69\x6f\x6e\x5f\x66\x6f\x72\155\x5f\x76\x61\154\151\144\x61\x74\x69\x6f\156", array($this, "\x6d\x69\x6e\151\157\x72\141\x6e\147\x65\x5f\x63\154\x69\x65\156\x74\137\162\145\x67\x69\x73\164\162\141\164\x69\x6f\156\137\x76\145\162\151\x66\x79"), 99, 1);
    }
    function isPhoneVerificationEnabled()
    {
        $au = $this->getVerificationType();
        return $au === VerificationType::PHONE || $au === VerificationType::BOTH;
    }
    function miniorange_client_registration_verify($errors)
    {
        $au = $this->getVerificationType();
        $TB = MoUtility::sanitizeCheck("\x63\x6f\156\x74\141\x63\x74\x5f\160\x68\157\x6e\145", $_POST);
        $MQ = MoUtility::sanitizeCheck("\x63\157\x6e\x74\x61\143\x74\x5f\145\155\141\x69\x6c", $_POST);
        $Ls = MoUtility::sanitizeCheck("\x63\157\x6e\x74\x61\143\164\137\165\163\145\162\156\141\155\x65", $_POST);
        if (!($this->_restrictDuplicates && $this->isPhoneNumberAlreadyInUse($TB, $this->_phoneKey))) {
            goto B_;
        }
        $errors .= mo_("\x50\150\x6f\156\x65\x20\156\165\155\142\145\162\x20\x61\154\x72\145\x61\144\x79\40\x69\156\40\x75\x73\145\56\40\120\x6c\145\141\x73\x65\40\105\156\164\145\x72\x20\141\40\x64\x69\x66\146\x65\x72\145\x6e\x74\x20\120\x68\x6f\156\145\40\x6e\165\x6d\x62\145\162\56");
        B_:
        if (MoUtility::isBlank($errors)) {
            goto Hz;
        }
        return $errors;
        Hz:
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto Vw;
        }
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $au)) {
            goto KG;
        }
        goto MV;
        Vw:
        MoUtility::initialize_transaction($this->_formSessionVar);
        goto MV;
        KG:
        $this->unsetOTPSessionVariables();
        return $errors;
        MV:
        return $this->startOTPTransaction($Ls, $MQ, $errors, $TB);
    }
    function startOTPTransaction($Ls, $MQ, $errors, $TB)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0) {
            goto rp;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) === 0) {
            goto r6;
        }
        $this->sendChallenge($Ls, $MQ, $errors, $TB, VerificationType::EMAIL);
        goto Wz;
        r6:
        $this->sendChallenge($Ls, $MQ, $errors, $TB, VerificationType::BOTH);
        Wz:
        goto D5;
        rp:
        $this->sendChallenge($Ls, $MQ, $errors, $TB, VerificationType::PHONE);
        D5:
        return $errors;
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
    function isPhoneNumberAlreadyInUse($l1, $O5)
    {
        global $wpdb;
        $l1 = MoUtility::processPhoneNumber($l1);
        $KA = $wpdb->get_row("\x53\105\114\105\103\124\40\140\x75\x73\145\162\137\151\144\140\40\106\x52\x4f\x4d\x20\140{$wpdb->prefix}\165\163\x65\x72\155\145\164\x61\x60\x20\127\110\x45\122\105\40\140\155\145\164\141\137\x6b\145\171\x60\x20\x3d\40\47{$O5}\47\40\x41\x4e\x44\40\140\x6d\145\164\x61\137\166\141\x6c\x75\x65\140\x20\75\x20\40\47{$l1}\x27");
        return !MoUtility::isBlank($KA);
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($sq)
    {
        if (!($this->isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto nm;
        }
        array_push($sq, $this->_phoneFormId);
        nm:
        return $sq;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto aI;
        }
        return;
        aI:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\167\x70\x5f\x63\154\151\x65\x6e\x74\x5f\x65\x6e\x61\142\x6c\x65");
        $this->_otpType = $this->sanitizeFormPOST("\167\160\137\143\x6c\151\x65\x6e\164\137\145\156\141\x62\x6c\x65\x5f\164\171\160\x65");
        $this->_restrictDuplicates = $this->getVerificationType() === VerificationType::PHONE ? $this->sanitizeFormPOST("\x77\x70\137\x63\154\x69\145\x6e\164\137\x72\145\163\x74\162\151\x63\164\x5f\144\x75\x70\154\151\x63\141\164\x65\x73") : false;
        update_mo_option("\167\160\137\x63\x6c\151\x65\156\164\137\145\x6e\141\142\154\145", $this->_isFormEnabled);
        update_mo_option("\x77\x70\x5f\x63\x6c\x69\145\156\x74\137\x65\156\141\142\154\145\137\x74\x79\160\x65", $this->_otpType);
        update_mo_option("\167\160\137\x63\x6c\151\x65\156\164\137\162\x65\x73\164\162\x69\143\164\137\144\165\x70\154\151\143\141\164\x65\x73", $this->_restrictDuplicates);
    }
}
