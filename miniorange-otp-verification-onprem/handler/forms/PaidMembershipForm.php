<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationLogic;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
class PaidMembershipForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::PMPRO_REGISTRATION;
        $this->_formKey = "\x50\115\x5f\120\x52\x4f\137\x46\x4f\122\115";
        $this->_formName = mo_("\x50\x61\151\144\40\x4d\145\155\x62\145\162\x53\150\x69\x70\40\x50\162\x6f\40\x52\x65\x67\x69\163\x74\x72\141\164\151\157\x6e\40\106\157\162\x6d");
        $this->_phoneFormId = "\x69\x6e\160\x75\x74\133\x6e\141\155\x65\x3d\160\x68\x6f\x6e\145\137\160\141\x69\x64\x6d\x65\x6d\142\x65\x72\163\150\151\x70\x5d";
        $this->_typePhoneTag = "\x70\155\x70\x72\157\x5f\x70\150\x6f\x6e\x65\137\145\156\141\142\x6c\x65";
        $this->_typeEmailTag = "\x70\155\x70\x72\x6f\137\x65\x6d\141\151\154\x5f\x65\156\141\142\154\145";
        $this->_isFormEnabled = get_mo_option("\160\x6d\x70\x72\x6f\x5f\x65\156\x61\x62\x6c\x65");
        $this->_formDocuments = MoOTPDocs::PAID_MEMBERSHIP_PRO;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x70\155\160\162\x6f\x5f\x6f\164\160\x5f\x74\171\160\145");
        add_action("\x77\160\x5f\x65\156\161\165\x65\x75\145\x5f\163\x63\x72\151\160\x74\163", array($this, "\x5f\163\150\x6f\x77\x5f\x70\x68\157\x6e\x65\137\146\151\x65\x6c\x64\x5f\x6f\x6e\x5f\x70\141\x67\x65"));
        add_filter("\x70\x6d\160\162\x6f\137\143\x68\x65\x63\153\157\x75\164\137\x62\145\x66\x6f\162\x65\137\160\162\157\x63\145\163\163\151\x6e\x67", array($this, "\x5f\x70\x61\x69\144\115\145\x6d\x62\145\162\x73\150\151\x70\x50\162\157\x52\x65\x67\x69\x73\x74\x72\141\x74\151\157\156\x43\x68\x65\x63\153"), 1, 1);
        add_filter("\160\155\x70\x72\157\137\143\150\145\x63\x6b\x6f\165\x74\137\x63\x6f\x6e\146\x69\162\x6d\145\x64", array($this, "\151\x73\126\141\154\x69\x64\141\164\x65\x64"), 99, 2);
    }
    public function isValidated($ij, $vA)
    {
        global $xv;
        return $xv == "\x70\x6d\x70\x72\x6f\137\x65\x72\162\x6f\x72" ? false : $ij;
    }
    public function _paidMembershipProRegistrationCheck()
    {
        global $xv;
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto i9;
        }
        $this->unsetOTPSessionVariables();
        return;
        i9:
        $this->validatePhone($_POST);
        if (!($xv != "\x70\x6d\x70\162\x6f\137\145\x72\162\x6f\162")) {
            goto jz;
        }
        MoUtility::initialize_transaction($this->_formSessionVar);
        $this->startOTPVerificationProcess($_POST);
        jz:
    }
    private function startOTPVerificationProcess($tT)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto yx;
        }
        if (strcasecmp($this->_otpType, $this->_typeEmailTag) == 0) {
            goto J8;
        }
        goto aJ;
        yx:
        $this->sendChallenge('', '', null, trim($tT["\160\x68\x6f\x6e\145\x5f\x70\141\151\144\x6d\x65\155\x62\145\162\163\x68\151\x70"]), "\x70\x68\x6f\x6e\145");
        goto aJ;
        J8:
        $this->sendChallenge('', $tT["\x62\145\x6d\x61\151\154"], null, $tT["\x62\x65\155\141\x69\154"], "\x65\155\141\151\x6c");
        aJ:
    }
    public function validatePhone($tT)
    {
        if (!($this->getVerificationType() != VerificationType::PHONE)) {
            goto fc;
        }
        return;
        fc:
        global $th, $xv, $phoneLogic, $lg;
        if (!($xv == "\x70\x6d\160\x72\x6f\137\x65\x72\x72\x6f\162")) {
            goto xI;
        }
        return;
        xI:
        $M7 = $tT["\x70\x68\x6f\x6e\x65\137\160\x61\151\x64\155\145\155\x62\145\x72\x73\x68\x69\x70"];
        if (MoUtility::validatePhoneNumber($M7)) {
            goto ql;
        }
        $Tg = str_replace("\43\x23\x70\x68\x6f\156\x65\43\x23", $M7, $phoneLogic->_get_otp_invalid_format_message());
        $xv = "\x70\x6d\x70\162\157\x5f\145\x72\162\x6f\162";
        $lg = false;
        $th = apply_filters("\x70\x6d\160\162\x6f\137\x73\x65\164\137\x6d\145\x73\x73\x61\x67\x65", $Tg, $xv);
        ql:
    }
    function _show_phone_field_on_page()
    {
        if (!(strcasecmp($this->_otpType, $this->_typePhoneTag) == 0)) {
            goto nQ;
        }
        wp_enqueue_script("\x70\x61\x69\x64\x6d\145\155\142\x65\x72\163\x68\x69\160\x73\x63\162\x69\x70\164", MOV_URL . "\151\x6e\x63\x6c\x75\144\145\163\x2f\152\x73\57\x70\x61\151\x64\155\145\155\x62\x65\162\x73\150\x69\160\x70\162\x6f\56\x6d\x69\x6e\56\152\x73\77\166\x65\162\163\x69\157\x6e\x3d" . MOV_VERSION, array("\152\161\165\145\162\171"));
        nQ:
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
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($sq)
    {
        if (!(self::isFormEnabled() && $this->_otpType == $this->_typePhoneTag)) {
            goto Uc;
        }
        array_push($sq, $this->_phoneFormId);
        Uc:
        return $sq;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto zi;
        }
        return;
        zi:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x70\155\x70\x72\x6f\x5f\x65\156\x61\142\x6c\x65");
        $this->_otpType = $this->sanitizeFormPOST("\x70\155\160\162\x6f\x5f\143\x6f\156\164\x61\x63\x74\x5f\x74\x79\x70\145");
        update_mo_option("\x70\155\160\x72\x6f\137\x65\156\x61\x62\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\x70\x6d\x70\x72\157\x5f\x6f\164\160\x5f\164\x79\160\145", $this->_otpType);
    }
}
