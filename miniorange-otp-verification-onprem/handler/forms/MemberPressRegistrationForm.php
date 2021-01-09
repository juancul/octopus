<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\BaseMessages;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationLogic;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
use WP_Error;
class MemberPressRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::MEMBERPRESS_REG;
        $this->_typePhoneTag = "\155\x6f\x5f\x6d\x72\x70\137\160\x68\157\156\145\x5f\x65\x6e\x61\142\154\145";
        $this->_typeEmailTag = "\x6d\157\x5f\155\x72\160\x5f\145\155\141\151\x6c\137\145\156\x61\142\x6c\145";
        $this->_typeBothTag = "\x6d\157\x5f\155\162\160\137\142\x6f\x74\150\137\x65\x6e\x61\x62\154\x65";
        $this->_formName = mo_("\x4d\145\x6d\142\145\162\x50\x72\145\163\163\40\x52\x65\147\x69\163\164\x72\141\x74\151\157\156\x20\x46\x6f\x72\155");
        $this->_formKey = "\115\x45\115\x42\105\122\x50\x52\x45\x53\123";
        $this->_isFormEnabled = get_mo_option("\x6d\162\160\137\144\145\146\x61\165\x6c\164\x5f\x65\156\141\142\x6c\x65");
        $this->_formDocuments = MoOTPDocs::MRP_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_byPassLogin = get_mo_option("\155\x72\x70\x5f\x61\156\x6f\156\x5f\x6f\x6e\154\x79");
        $this->_phoneKey = get_mo_option("\x6d\162\160\137\160\x68\157\156\145\137\x6b\x65\x79");
        $this->_otpType = get_mo_option("\x6d\162\160\x5f\145\156\141\142\154\x65\x5f\164\x79\x70\x65");
        $this->_phoneFormId = "\151\156\160\x75\x74\133\156\x61\155\145\x3d" . $this->_phoneKey . "\x5d";
        add_filter("\155\x65\x70\x72\x2d\x76\x61\x6c\151\x64\x61\164\x65\55\x73\x69\147\x6e\165\160", array($this, "\155\x69\x6e\151\x6f\x72\x61\x6e\x67\145\x5f\163\151\164\x65\137\x72\x65\147\x69\x73\164\x65\162\137\146\157\x72\x6d"), 99, 1);
    }
    function miniorange_site_register_form($errors)
    {
        if (!($this->_byPassLogin && is_user_logged_in())) {
            goto kK_;
        }
        return $errors;
        kK_:
        $ZP = $_POST;
        $TB = '';
        if (!$this->isPhoneVerificationEnabled()) {
            goto xxa;
        }
        $TB = $_POST[$this->_phoneKey];
        $errors = $this->validatePhoneNumberField($errors);
        xxa:
        if (!(is_array($errors) && !empty($errors))) {
            goto TM4;
        }
        return $errors;
        TM4:
        if (!$this->checkIfVerificationIsComplete()) {
            goto zIX;
        }
        return $errors;
        zIX:
        MoUtility::initialize_transaction($this->_formSessionVar);
        $errors = new WP_Error();
        foreach ($_POST as $O5 => $Xd) {
            if ($O5 == "\165\x73\145\x72\137\146\x69\x72\x73\x74\x5f\x6e\141\x6d\x65") {
                goto MiJ;
            }
            if ($O5 == "\x75\x73\x65\162\137\x65\x6d\x61\151\x6c") {
                goto ClV;
            }
            if ($O5 == "\x6d\145\x70\x72\137\165\163\x65\162\x5f\160\141\163\x73\167\x6f\162\144") {
                goto wM2;
            }
            $HL[$O5] = $Xd;
            goto I0e;
            MiJ:
            $EN = $Xd;
            goto I0e;
            ClV:
            $Vy = $Xd;
            goto I0e;
            wM2:
            $eW = $Xd;
            I0e:
            C3H:
        }
        lIQ:
        $HL["\x75\x73\145\162\x6d\145\x74\141"] = $ZP;
        $this->startVerificationProcess($EN, $Vy, $errors, $TB, $eW, $HL);
        return $errors;
    }
    function validatePhoneNumberField($errors)
    {
        global $phoneLogic;
        if (!MoUtility::sanitizeCheck($this->_phoneKey, $_POST)) {
            goto Eii;
        }
        if (MoUtility::validatePhoneNumber($_POST[$this->_phoneKey])) {
            goto qXT;
        }
        $errors[] = $phoneLogic->_get_otp_invalid_format_message();
        qXT:
        goto Jyb;
        Eii:
        $errors[] = mo_("\120\x68\157\156\x65\40\x6e\x75\x6d\142\x65\x72\40\146\x69\145\154\144\x20\x63\141\x6e\x20\x6e\x6f\164\x20\x62\145\x20\142\154\x61\156\153");
        Jyb:
        return $errors;
    }
    function startVerificationProcess($EN, $Vy, $errors, $TB, $eW, $HL)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto uQq;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) == 0) {
            goto UDq;
        }
        $this->sendChallenge($EN, $Vy, $errors, $TB, VerificationType::EMAIL, $eW, $HL);
        goto Lmy;
        uQq:
        $this->sendChallenge($EN, $Vy, $errors, $TB, VerificationType::PHONE, $eW, $HL);
        goto Lmy;
        UDq:
        $this->sendChallenge($EN, $Vy, $errors, $TB, VerificationType::BOTH, $eW, $HL);
        Lmy:
    }
    function checkIfVerificationIsComplete()
    {
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto JpR;
        }
        $this->unsetOTPSessionVariables();
        return TRUE;
        JpR:
        return FALSE;
    }
    function moMRPgetphoneFieldId()
    {
        global $wpdb;
        return $wpdb->get_var("\x53\x45\x4c\x45\103\124\x20\151\144\x20\106\122\117\115\x20{$wpdb->prefix}\142\x70\137\170\160\x72\x6f\146\151\x6c\145\137\x66\151\x65\x6c\144\x73\x20\167\150\145\x72\x65\40\156\x61\x6d\145\x20\75\47" . $this->_phoneKey . "\x27");
    }
    function handle_post_verification($WE, $wE, $MQ, $eW, $TB, $HL, $au)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $au);
    }
    function handle_failed_verification($wE, $MQ, $TB, $au)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto Ru5;
        }
        return;
        Ru5:
        $CN = $this->getVerificationType();
        $Ta = $CN === VerificationType::BOTH ? TRUE : FALSE;
        miniorange_site_otp_validation_form($wE, $MQ, $TB, MoUtility::_get_invalid_otp_method(), $CN, $Ta);
    }
    public function getPhoneNumberSelector($sq)
    {
        if (!(self::isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto CNM;
        }
        array_push($sq, $this->_phoneFormId);
        CNM:
        return $sq;
    }
    function isPhoneVerificationEnabled()
    {
        $au = $this->getVerificationType();
        return $au === VerificationType::PHONE || $au === VerificationType::BOTH;
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto isQ;
        }
        return;
        isQ:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x6d\x72\x70\x5f\x64\x65\146\x61\165\154\164\x5f\145\156\x61\x62\154\x65");
        $this->_otpType = $this->sanitizeFormPOST("\155\x72\x70\137\145\156\x61\142\x6c\x65\137\x74\x79\x70\145");
        $this->_phoneKey = $this->sanitizeFormPOST("\x6d\x72\160\137\x70\x68\157\x6e\x65\x5f\146\x69\145\x6c\144\137\153\x65\x79");
        $this->_byPassLogin = $this->sanitizeFormPOST("\155\160\x72\x5f\x61\156\157\x6e\137\157\x6e\154\x79");
        if (!$this->basicValidationCheck(BaseMessages::MEMBERPRESS_CHOOSE)) {
            goto FR6;
        }
        update_mo_option("\x6d\x72\x70\x5f\x64\145\146\x61\x75\x6c\164\137\145\x6e\141\142\x6c\145", $this->_isFormEnabled);
        update_mo_option("\x6d\162\160\137\x65\x6e\141\142\x6c\x65\137\164\171\x70\x65", $this->_otpType);
        update_mo_option("\155\162\x70\137\160\150\157\156\145\137\153\145\171", $this->_phoneKey);
        update_mo_option("\x6d\162\x70\x5f\141\156\157\156\x5f\157\156\154\171", $this->_byPassLogin);
        FR6:
    }
}
