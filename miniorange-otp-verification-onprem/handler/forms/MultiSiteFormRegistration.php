<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoPHPSessions;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
use WP_Error;
class MultiSiteFormRegistration extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::MULTISITE;
        $this->_phoneFormId = "\x69\156\x70\165\164\x5b\x6e\x61\x6d\145\x3d\x6d\165\154\164\151\163\151\164\x65\x5f\x75\163\x65\162\x5f\x70\x68\x6f\x6e\x65\x5f\155\151\x6e\151\x6f\162\x61\156\x67\145\x5d";
        $this->_typePhoneTag = "\155\x6f\x5f\x6d\165\154\164\x69\x73\x69\x74\x65\x5f\x63\x6f\x6e\164\x61\x63\x74\137\x70\x68\x6f\156\145\x5f\145\x6e\141\x62\154\145";
        $this->_typeEmailTag = "\155\157\x5f\155\x75\154\x74\151\x73\151\164\x65\137\143\157\x6e\x74\x61\143\164\x5f\x65\x6d\141\x69\x6c\137\x65\156\x61\142\154\x65";
        $this->_formKey = "\x57\120\137\123\111\107\x4e\125\120\137\x46\117\122\115";
        $this->_formName = mo_("\x57\157\x72\144\120\162\x65\163\163\x20\x4d\x75\x6c\x74\x69\163\151\164\145\x20\123\151\147\x6e\125\160\40\x46\x6f\x72\x6d");
        $this->_isFormEnabled = get_mo_option("\155\x75\x6c\x74\x69\x73\x69\164\145\x5f\x65\156\141\x62\x6c\x65");
        $this->_phoneKey = "\164\x65\154\x65\x70\150\x6f\156\x65";
        $this->_formDocuments = MoOTPDocs::MULTISITE_REG_FORM;
        parent::__construct();
    }
    public function handleForm()
    {
        add_action("\167\160\137\145\156\161\x75\145\165\x65\137\163\x63\162\151\160\x74\163", array($this, "\141\144\x64\x50\x68\157\x6e\x65\x46\x69\x65\154\x64\123\x63\x72\151\160\164"));
        add_action("\x75\x73\x65\x72\x5f\x72\x65\x67\x69\x73\164\x65\162", array($this, "\x5f\x73\x61\166\x65\x50\150\x6f\156\145\x4e\165\x6d\142\145\x72"), 10, 1);
        $this->_otpType = get_mo_option("\x6d\x75\154\x74\151\163\x69\x74\145\x5f\157\164\160\x5f\x74\171\x70\145");
        if (array_key_exists("\x6f\160\x74\151\157\x6e", $_POST)) {
            goto zd;
        }
        return;
        zd:
        switch (trim($_POST["\157\x70\x74\x69\x6f\156"])) {
            case "\x6d\165\x6c\x74\x69\x73\151\164\x65\137\162\145\x67\x69\x73\x74\x65\x72":
                $this->_sanitizeAndRouteData($_POST);
                goto vL;
            case "\155\151\x6e\151\157\x72\141\x6e\x67\x65\x2d\x76\x61\x6c\x69\144\141\164\145\55\157\x74\160\55\146\x6f\162\x6d":
                $this->_startValidation();
                goto vL;
        }
        l3:
        vL:
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function handle_post_verification($WE, $wE, $MQ, $eW, $TB, $HL, $au)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $au);
        $this->unsetOTPSessionVariables();
    }
    public function _savePhoneNumber($wc)
    {
        $ZI = MoPHPSessions::getSessionVar("\160\150\157\156\145\x5f\156\x75\x6d\142\x65\162\x5f\x6d\157");
        if (!$ZI) {
            goto g8;
        }
        update_user_meta($wc, $this->_phoneKey, $ZI);
        g8:
    }
    public function handle_failed_verification($wE, $MQ, $TB, $au)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto KS;
        }
        return;
        KS:
        $CN = $this->getVerificationType();
        $Ta = $CN === VerificationType::BOTH ? TRUE : FALSE;
        miniorange_site_otp_validation_form($wE, $MQ, $TB, MoUtility::_get_invalid_otp_method(), $CN, $Ta);
    }
    function _sanitizeAndRouteData($QV)
    {
        $Qh = wpmu_validate_user_signup($_POST["\x75\x73\145\162\x5f\156\x61\155\x65"], $_POST["\x75\163\145\x72\137\x65\x6d\141\151\x6c"]);
        $errors = $Qh["\x65\162\162\157\162\163"];
        if (!$errors->get_error_code()) {
            goto uj;
        }
        return false;
        uj:
        Moutility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto qs;
        }
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) == 0)) {
            goto QM;
        }
        $this->_processEmail($QV);
        QM:
        goto nT;
        qs:
        $this->_processPhone($QV);
        nT:
        return false;
    }
    private function _startValidation()
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto Uz;
        }
        return;
        Uz:
        $CN = $this->getVerificationType();
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $CN)) {
            goto s0;
        }
        return;
        s0:
        $this->validateChallenge($CN);
    }
    public function addPhoneFieldScript()
    {
        wp_enqueue_script("\x6d\x75\x6c\x74\x69\x73\151\164\x65\x73\143\x72\151\160\164", MOV_URL . "\x69\156\143\154\165\144\x65\163\x2f\152\x73\57\155\165\154\164\x69\163\151\x74\145\56\x6d\151\x6e\56\152\163\x3f\x76\x65\162\x73\151\x6f\156\x3d" . MOV_VERSION, array("\152\161\165\145\162\x79"));
    }
    private function _processPhone($QV)
    {
        if (isset($QV["\x6d\x75\x6c\x74\x69\163\151\x74\145\x5f\165\163\145\x72\x5f\x70\x68\157\x6e\145\x5f\155\151\156\151\x6f\162\141\x6e\x67\x65"])) {
            goto DF;
        }
        return;
        DF:
        $this->sendChallenge('', '', null, trim($QV["\x6d\165\x6c\164\151\163\151\164\145\137\x75\x73\145\162\x5f\160\150\157\x6e\x65\137\155\x69\x6e\x69\x6f\162\141\156\x67\145"]), VerificationType::PHONE);
    }
    private function _processEmail($QV)
    {
        if (isset($QV["\x75\x73\145\x72\x5f\x65\155\x61\x69\154"])) {
            goto Hn;
        }
        return;
        Hn:
        $this->sendChallenge('', $QV["\165\x73\145\x72\x5f\x65\155\x61\x69\x6c"], null, null, VerificationType::EMAIL, '');
    }
    public function getPhoneNumberSelector($sq)
    {
        if (!self::isFormEnabled()) {
            goto Nc;
        }
        array_push($sq, $this->_phoneFormId);
        Nc:
        return $sq;
    }
    public function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto px;
        }
        return;
        px:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\155\165\154\x74\151\x73\151\x74\x65\x5f\x65\156\141\x62\154\145");
        $this->_otpType = $this->sanitizeFormPOST("\x6d\x75\x6c\x74\151\x73\x69\164\145\137\x63\x6f\156\164\141\143\164\137\164\x79\160\145");
        update_mo_option("\x6d\165\154\164\151\163\x69\164\x65\x5f\145\x6e\x61\x62\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\x6d\x75\x6c\164\x69\x73\x69\164\145\137\157\x74\160\x5f\x74\x79\x70\x65", $this->_otpType);
    }
}
