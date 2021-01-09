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
class ProfileBuilderRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::PB_DEFAULT_REG;
        $this->_typePhoneTag = "\x6d\157\137\160\x62\x5f\160\150\x6f\156\145\x5f\145\x6e\141\142\x6c\145";
        $this->_typeEmailTag = "\155\x6f\137\160\142\x5f\145\155\141\151\154\137\x65\156\x61\x62\x6c\145";
        $this->_typeBothTag = "\x6d\157\137\x70\142\137\142\x6f\164\150\x5f\145\x6e\141\142\154\x65";
        $this->_formKey = "\x50\x42\x5f\x44\x45\106\101\x55\x4c\x54\x5f\x46\x4f\122\115";
        $this->_formName = mo_("\x50\x72\157\x66\151\154\145\40\102\165\x69\154\x64\145\x72\x20\122\145\147\151\163\x74\162\141\x74\151\x6f\156\x20\106\157\162\155");
        $this->_isFormEnabled = get_mo_option("\x70\x62\137\144\145\146\141\x75\154\x74\x5f\x65\156\141\x62\x6c\x65");
        $this->_formDocuments = MoOTPDocs::PB_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x70\x62\137\x65\156\141\x62\154\145\x5f\164\x79\160\145");
        $this->_phoneKey = get_mo_option("\160\142\137\x70\150\157\156\x65\x5f\155\x65\x74\x61\137\153\145\171");
        $this->_phoneFormId = "\x69\156\160\165\x74\133\156\x61\155\145\75" . $this->_phoneKey . "\135";
        add_filter("\x77\160\160\x62\137\x6f\x75\x74\x70\165\x74\x5f\x66\151\145\x6c\x64\137\x65\x72\162\x6f\162\163\x5f\146\151\x6c\x74\x65\162", array($this, "\x66\x6f\162\x6d\142\x75\x69\x6c\144\x65\162\x5f\x73\151\164\145\x5f\162\145\147\x69\x73\x74\x72\141\x74\151\157\156\x5f\x65\162\162\157\x72\163"), 99, 4);
    }
    function isPhoneVerificationEnabled()
    {
        $CN = $this->getVerificationType();
        return $CN === VerificationType::PHONE || $CN === VerificationType::BOTH;
    }
    function formbuilder_site_registration_errors($d6, $EE, $s4, $qZ)
    {
        if (empty($d6)) {
            goto ru;
        }
        return $d6;
        ru:
        if (!($s4["\x61\x63\x74\x69\x6f\156"] == "\x72\145\147\x69\163\x74\x65\x72")) {
            goto Ig;
        }
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto PL;
        }
        $this->unsetOTPSessionVariables();
        return $d6;
        PL:
        return $this->startOTPVerificationProcess($d6, $s4);
        Ig:
        return $d6;
    }
    function startOTPVerificationProcess($d6, $tT)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        $Kc = $this->extractArgs($tT, $this->_phoneKey);
        $this->sendChallenge($Kc["\165\163\145\x72\x6e\141\x6d\x65"], $Kc["\x65\155\141\x69\x6c"], new WP_Error(), $Kc["\160\150\x6f\156\x65"], $this->getVerificationType(), $Kc["\x70\x61\x73\x73\x77\x31"], array());
    }
    private function extractArgs($Kc, $nT)
    {
        return array("\165\x73\145\x72\156\141\155\145" => $Kc["\x75\x73\145\162\x6e\141\155\145"], "\145\x6d\x61\x69\x6c" => $Kc["\145\x6d\x61\x69\154"], "\x70\141\x73\163\167\61" => $Kc["\160\x61\x73\163\167\61"], "\x70\150\157\156\145" => MoUtility::sanitizeCheck($nT, $Kc));
    }
    function handle_failed_verification($wE, $MQ, $TB, $au)
    {
        miniorange_site_otp_validation_form($wE, $MQ, $TB, MoUtility::_get_invalid_otp_method(), $this->getVerificationType(), FALSE);
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
            goto Vt;
        }
        array_push($sq, $this->_phoneFormId);
        Vt:
        return $sq;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto ZM;
        }
        return;
        ZM:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\160\142\x5f\144\145\146\141\x75\154\164\137\145\156\141\142\x6c\145");
        $this->_otpType = $this->sanitizeFormPOST("\x70\142\137\x65\156\x61\142\154\x65\x5f\x74\171\160\145");
        $this->_phoneKey = $this->sanitizeFormPOST("\160\x62\x5f\x70\150\157\x6e\x65\137\146\x69\x65\154\144\x5f\153\x65\171");
        update_mo_option("\x70\x62\137\x64\x65\x66\141\165\154\164\x5f\x65\x6e\141\x62\154\145", $this->_isFormEnabled);
        update_mo_option("\x70\142\137\145\156\141\142\x6c\145\137\x74\x79\x70\x65", $this->_otpType);
        update_mo_option("\x70\142\137\x70\x68\x6f\156\x65\137\x6d\x65\164\141\x5f\153\x65\x79", $this->_phoneKey);
    }
}
