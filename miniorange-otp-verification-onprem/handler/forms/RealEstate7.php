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
class RealEstate7 extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::REALESTATE_7;
        $this->_phoneFormId = "\151\156\x70\x75\x74\133\156\x61\x6d\x65\75\143\x74\137\x75\x73\x65\x72\137\160\x68\x6f\x6e\x65\137\x6d\x69\x6e\151\157\x72\x61\x6e\x67\145\x5d";
        $this->_formKey = "\122\105\101\x4c\137\x45\123\124\101\x54\105\137\67";
        $this->_typePhoneTag = "\x6d\157\x5f\162\x65\x61\x6c\x65\x73\164\x61\164\x65\137\143\157\156\164\141\143\164\x5f\160\150\157\156\145\x5f\145\156\141\142\x6c\x65";
        $this->_typeEmailTag = "\x6d\x6f\137\x72\145\x61\154\145\163\x74\141\164\145\137\x63\157\x6e\x74\141\143\164\x5f\145\155\x61\x69\x6c\137\145\156\x61\142\x6c\145";
        $this->_formName = mo_("\122\145\141\x6c\x20\x45\163\x74\141\x74\145\x20\67\40\x50\x72\x6f\40\124\x68\145\155\145");
        $this->_isFormEnabled = get_mo_option("\162\145\141\x6c\145\x73\x74\141\x74\145\137\x65\x6e\141\x62\154\145");
        $this->_formDocuments = MoOTPDocs::REALESTATE7_THEME_LINK;
        parent::__construct();
    }
    public function handleForm()
    {
        $this->_otpType = get_mo_option("\x72\x65\x61\154\145\x73\x74\x61\x74\x65\137\x6f\164\160\x5f\164\171\160\145");
        add_action("\x77\x70\x5f\145\x6e\x71\165\x65\165\145\137\x73\143\x72\151\160\x74\x73", array($this, "\141\144\144\120\x68\157\156\x65\106\151\145\154\x64\x53\143\162\151\160\x74"));
        add_action("\165\163\x65\162\x5f\x72\x65\147\151\x73\x74\x65\162", array($this, "\x6d\151\156\151\x6f\x72\141\x6e\x67\145\x5f\x72\145\x67\x69\163\164\162\141\164\x69\x6f\156\137\x73\141\x76\x65"), 10, 1);
        if (array_key_exists("\x6f\160\164\151\x6f\x6e", $_POST)) {
            goto eX;
        }
        return;
        eX:
        switch ($_POST["\157\x70\164\151\x6f\156"]) {
            case "\x72\145\141\154\x65\163\x74\141\x74\x65\137\162\145\147\151\163\x74\145\x72":
                if (!$this->sanitizeData($_POST)) {
                    goto NU;
                }
                $this->routeData($_POST);
                NU:
                goto La;
            case "\155\151\156\151\x6f\x72\x61\156\x67\145\x2d\x76\141\154\151\144\x61\x74\145\x2d\x6f\164\x70\55\146\x6f\162\x6d":
                $this->_startValidation();
                goto La;
        }
        xP:
        La:
    }
    public function unsetOTPSessionVariables()
    {
        Sessionutils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function handle_post_verification($WE, $wE, $MQ, $eW, $TB, $HL, $au)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $au);
        $this->unsetOTPSessionVariables();
    }
    public function handle_failed_verification($wE, $MQ, $TB, $au)
    {
        $CN = $this->getVerificationType();
        $Ta = $CN === VerificationType::BOTH ? TRUE : FALSE;
        miniorange_site_otp_validation_form($wE, $MQ, $TB, MoUtility::_get_invalid_otp_method(), $CN, $Ta);
    }
    public function sanitizeData($Ir)
    {
        if (!(isset($Ir["\143\164\x5f\165\x73\x65\x72\137\x6c\157\147\151\156"]) && wp_verify_nonce($Ir["\x63\164\137\x72\x65\147\x69\x73\164\x65\x72\137\x6e\x6f\156\143\x65"], "\143\164\x2d\162\145\147\151\163\164\145\162\55\156\x6f\x6e\143\145"))) {
            goto KO;
        }
        $wE = $Ir["\143\x74\137\165\163\x65\x72\x5f\154\157\147\x69\x6e"];
        $MQ = $Ir["\x63\164\137\165\163\145\x72\x5f\x65\x6d\x61\151\x6c"];
        $Jt = $Ir["\x63\x74\137\165\x73\145\x72\137\146\151\162\x73\x74"];
        $iO = $Ir["\x63\164\x5f\x75\163\x65\162\137\x6c\141\x73\x74"];
        $hP = $Ir["\143\164\137\165\x73\x65\162\x5f\160\x61\x73\163"];
        $xu = $Ir["\x63\x74\137\x75\163\x65\x72\137\160\141\x73\x73\137\143\x6f\156\x66\151\162\x6d"];
        if (!(username_exists($wE) || !validate_username($wE) || $wE == '' || !is_email($MQ) || email_exists($MQ) || $hP == '' || $hP != $xu)) {
            goto ey;
        }
        return false;
        ey:
        return true;
        KO:
        return false;
    }
    public function miniorange_registration_save($wc)
    {
        $au = $this->getVerificationType();
        $l1 = MoPHPSessions::getSessionVar("\160\150\157\x6e\x65\137\156\165\155\x62\145\x72\137\155\x6f");
        if (!($au === VerificationType::PHONE && $l1)) {
            goto Iz;
        }
        add_user_meta($wc, "\x70\x68\157\156\145", $l1);
        Iz:
    }
    private function _startValidation()
    {
        $au = $this->getVerificationType();
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto z9;
        }
        return;
        z9:
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $au)) {
            goto XT;
        }
        return;
        XT:
        $this->validateChallenge($au);
    }
    public function routeData($Ir)
    {
        Moutility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto Ck;
        }
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) == 0)) {
            goto Yr;
        }
        $this->_processEmail($Ir);
        Yr:
        goto Tx;
        Ck:
        $this->_processPhone($Ir);
        Tx:
    }
    private function _processPhone($Ir)
    {
        if (!(!array_key_exists("\143\164\x5f\x75\x73\145\x72\x5f\x70\150\157\156\145\x5f\x6d\x69\156\151\157\x72\141\156\x67\x65", $Ir) || !isset($Ir["\x63\164\x5f\x75\163\145\162\137\x70\150\157\156\x65\137\155\151\x6e\151\x6f\x72\x61\x6e\147\x65"]))) {
            goto WH;
        }
        return;
        WH:
        $this->sendChallenge('', '', null, trim($Ir["\x63\164\137\165\x73\x65\162\x5f\x70\x68\157\x6e\145\x5f\155\151\x6e\151\157\162\x61\156\147\x65"]), VerificationType::PHONE);
    }
    private function _processEmail($Ir)
    {
        if (!(!array_key_exists("\x63\x74\137\165\x73\145\162\x5f\x65\155\141\151\154", $Ir) || !isset($Ir["\x63\164\x5f\165\163\145\x72\137\x65\x6d\x61\x69\154"]))) {
            goto Hp;
        }
        return;
        Hp:
        $this->sendChallenge('', $Ir["\143\x74\137\165\x73\x65\162\137\145\155\x61\151\154"], null, null, VerificationType::EMAIL, '');
    }
    public function addPhoneFieldScript()
    {
        wp_enqueue_script("\x72\x65\141\154\x45\x73\164\141\x74\145\x37\123\143\162\x69\x70\x74", MOV_URL . "\151\156\143\x6c\165\144\145\163\57\x6a\163\57\162\x65\x61\154\105\163\164\141\164\x65\67\x2e\155\x69\x6e\56\x6a\x73\x3f\x76\x65\162\163\x69\157\x6e\x3d" . MOV_VERSION, array("\152\x71\x75\x65\x72\x79"));
    }
    public function getPhoneNumberSelector($sq)
    {
        if (!(self::isFormEnabled() && $this->_otpType == $this->_typePhoneTag)) {
            goto j1;
        }
        array_push($sq, $this->_phoneFormId);
        j1:
        return $sq;
    }
    public function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto VH;
        }
        return;
        VH:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\162\x65\x61\x6c\x65\163\164\x61\x74\x65\137\x65\156\x61\142\x6c\145");
        $this->_otpType = $this->sanitizeFormPOST("\162\x65\141\x6c\x65\x73\164\141\x74\x65\x5f\143\157\156\x74\x61\143\164\137\x74\x79\160\x65");
        update_mo_option("\162\145\x61\x6c\x65\x73\164\x61\164\x65\137\145\156\x61\142\154\x65", $this->_isFormEnabled);
        update_mo_option("\162\145\x61\x6c\x65\x73\x74\141\164\145\x5f\157\x74\x70\137\164\171\160\145", $this->_otpType);
    }
}
