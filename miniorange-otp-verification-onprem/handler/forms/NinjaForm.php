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
class NinjaForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::NINJA_FORM;
        $this->_typePhoneTag = "\155\157\137\156\151\156\x6a\x61\x5f\146\157\x72\x6d\137\x70\150\157\156\145\137\x65\156\x61\142\154\x65";
        $this->_typeEmailTag = "\155\157\x5f\156\x69\x6e\x6a\141\137\x66\157\162\155\x5f\x65\x6d\x61\151\154\x5f\145\156\x61\x62\154\x65";
        $this->_typeBothTag = "\x6d\157\137\156\x69\156\152\141\x5f\146\157\x72\x6d\x5f\142\x6f\x74\150\x5f\145\156\141\x62\x6c\x65";
        $this->_formKey = "\x4e\111\x4e\x4a\101\137\x46\117\122\x4d";
        $this->_formName = mo_("\x4e\151\x6e\x6a\x61\40\106\x6f\162\155\163\40\50\x20\102\145\x6c\157\x77\x20\166\x65\x72\163\x69\157\156\40\x33\x2e\60\x20\51");
        $this->_isFormEnabled = get_mo_option("\x6e\x69\x6e\152\x61\x5f\146\157\162\x6d\137\145\x6e\x61\x62\x6c\145");
        $this->_formDocuments = MoOTPDocs::NINJA_FORMS_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\156\x69\x6e\152\x61\x5f\146\x6f\x72\155\x5f\145\x6e\x61\142\x6c\x65\x5f\x74\171\160\x65");
        $this->_formDetails = maybe_unserialize(get_mo_option("\156\151\x6e\x6a\x61\137\x66\x6f\162\155\x5f\x6f\164\160\x5f\x65\x6e\141\x62\x6c\x65\144"));
        if (!empty($this->_formDetails)) {
            goto oj;
        }
        return;
        oj:
        foreach ($this->_formDetails as $O5 => $Xd) {
            array_push($this->_phoneFormId, "\151\x6e\x70\x75\164\133\x6e\x61\x6d\x65\75\156\x69\156\x6a\x61\x5f\x66\x6f\x72\155\x73\x5f\x66\x69\x65\x6c\x64\137" . $Xd["\160\150\x6f\x6e\145\153\145\x79"] . "\135");
            x3:
        }
        wX:
        if (!$this->checkIfOTPOptions()) {
            goto Kq;
        }
        return;
        Kq:
        if (!$this->checkIfNinjaFormSubmitted()) {
            goto fT;
        }
        $this->_handle_ninja_form_submit($_REQUEST);
        fT:
    }
    function checkIfOTPOptions()
    {
        return array_key_exists("\x6f\x70\164\x69\157\156", $_POST) && (strpos($_POST["\x6f\160\164\151\x6f\156"], "\x76\x65\162\151\146\x69\143\141\x74\151\157\156\x5f\x72\145\x73\x65\156\x64\137\157\x74\x70") || $_POST["\157\x70\164\151\x6f\x6e"] == "\155\151\x6e\151\x6f\162\x61\156\x67\145\55\x76\x61\x6c\x69\144\x61\164\x65\55\x6f\x74\x70\55\146\157\x72\x6d" || $_POST["\157\x70\164\151\157\x6e"] == "\x6d\151\156\151\x6f\x72\141\156\x67\x65\x2d\166\141\154\x69\144\x61\x74\x65\55\x6f\x74\x70\x2d\143\150\x6f\151\143\145\x2d\x66\x6f\162\155");
    }
    function checkIfNinjaFormSubmitted()
    {
        return array_key_exists("\x5f\156\x69\x6e\152\141\x5f\146\x6f\162\x6d\x73\x5f\x64\151\x73\160\x6c\x61\171\x5f\x73\165\142\x6d\151\x74", $_REQUEST) && array_key_exists("\137\146\x6f\x72\x6d\137\x69\x64", $_REQUEST);
    }
    function isPhoneVerificationEnabled()
    {
        $au = $this->getVerificationType();
        return $au === VerificationType::PHONE || $au === VerificationType::BOTH;
    }
    function isEmailVerificationEnabled()
    {
        $au = $this->getVerificationType();
        return $au === VerificationType::EMAIL || $au === VerificationType::BOTH;
    }
    function _handle_ninja_form_submit($gz)
    {
        if (array_key_exists($gz["\x5f\x66\157\x72\x6d\x5f\x69\144"], $this->_formDetails)) {
            goto Us;
        }
        return;
        Us:
        $p8 = $this->_formDetails[$gz["\137\x66\x6f\162\155\x5f\x69\x64"]];
        $Vy = $this->processEmail($p8, $gz);
        $l1 = $this->processPhone($p8, $gz);
        $this->miniorange_ninja_form_user($Vy, null, $l1);
    }
    function processPhone($p8, $gz)
    {
        if (!$this->isPhoneVerificationEnabled()) {
            goto Ic;
        }
        $DH = "\x6e\x69\156\x6a\141\x5f\146\x6f\162\155\163\137\146\151\x65\154\144\137" . $p8["\x70\150\157\x6e\x65\x6b\x65\171"];
        return array_key_exists($DH, $gz) ? $gz[$DH] : NULL;
        Ic:
        return null;
    }
    function processEmail($p8, $gz)
    {
        if (!$this->isEmailVerificationEnabled()) {
            goto z8;
        }
        $DH = "\156\x69\x6e\x6a\141\x5f\146\x6f\x72\x6d\163\x5f\x66\x69\x65\x6c\144\137" . $p8["\x65\155\x61\151\154\153\145\171"];
        return array_key_exists($DH, $gz) ? $gz[$DH] : NULL;
        z8:
        return null;
    }
    function miniorange_ninja_form_user($MQ, $uK, $TB)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        $errors = new WP_Error();
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto QH;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) == 0) {
            goto b0;
        }
        $this->sendChallenge($uK, $MQ, $errors, $TB, VerificationType::EMAIL);
        goto Dl;
        b0:
        $this->sendChallenge($uK, $MQ, $errors, $TB, VerificationType::BOTH);
        Dl:
        goto Cj;
        QH:
        $this->sendChallenge($uK, $MQ, $errors, $TB, VerificationType::PHONE);
        Cj:
    }
    function handle_failed_verification($wE, $MQ, $TB, $au)
    {
        $CN = $this->getVerificationType();
        $Ta = $CN === VerificationType::BOTH ? TRUE : FALSE;
        miniorange_site_otp_validation_form($wE, $MQ, $TB, MoUtility::_get_invalid_otp_method(), $CN, $Ta);
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
        if (!($this->isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto m0;
        }
        $sq = array_merge($sq, $this->_phoneFormId);
        m0:
        return $sq;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto Q7;
        }
        return;
        Q7:
        if (!isset($_POST["\x6d\x6f\x5f\x63\165\163\x74\157\x6d\145\162\137\166\x61\154\x69\144\x61\164\151\x6f\x6e\137\156\x6a\141\137\x65\156\141\x62\154\x65"])) {
            goto fh;
        }
        return;
        fh:
        $form = $this->parseFormDetails();
        $this->_isFormEnabled = $this->sanitizeFormPOST("\156\151\156\152\x61\137\x66\x6f\x72\155\137\x65\156\141\142\x6c\145");
        $this->_otpType = $this->sanitizeFormPOST("\156\x69\x6e\152\x61\x5f\146\x6f\x72\155\x5f\145\156\141\142\x6c\x65\x5f\164\171\x70\145");
        $this->_formDetails = !empty($form) ? $form : '';
        update_mo_option("\156\x69\156\152\141\x5f\x66\157\162\x6d\137\145\156\x61\x62\154\x65", $this->_isFormEnabled);
        update_mo_option("\x6e\x6a\141\137\x65\156\141\142\154\145", 0);
        update_mo_option("\156\x69\156\x6a\x61\137\146\157\x72\x6d\x5f\145\x6e\x61\142\x6c\x65\137\x74\x79\x70\x65", $this->_otpType);
        update_mo_option("\x6e\x69\x6e\152\141\137\x66\157\x72\155\x5f\157\164\160\x5f\145\156\x61\142\154\x65\144", maybe_serialize($this->_formDetails));
    }
    function parseFormDetails()
    {
        $form = array();
        if (array_key_exists("\x6e\x69\156\x6a\x61\x5f\x66\157\162\155", $_POST)) {
            goto n_;
        }
        return array();
        n_:
        foreach (array_filter($_POST["\156\151\x6e\152\x61\137\x66\x6f\162\x6d"]["\146\157\x72\155"]) as $O5 => $Xd) {
            $form[$Xd] = array("\x65\x6d\141\x69\x6c\x6b\145\x79" => $_POST["\156\x69\x6e\152\x61\x5f\146\x6f\162\155"]["\x65\155\x61\151\x6c\x6b\x65\x79"][$O5], "\x70\x68\157\x6e\x65\153\x65\171" => $_POST["\156\151\156\x6a\x61\137\x66\x6f\162\x6d"]["\x70\150\x6f\x6e\x65\x6b\x65\x79"][$O5]);
            Xn:
        }
        OX:
        return $form;
    }
}
