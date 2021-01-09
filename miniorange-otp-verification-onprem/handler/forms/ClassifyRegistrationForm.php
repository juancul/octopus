<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoPHPSessions;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Traits\Instance;
use ReflectionException;
class ClassifyRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::CLASSIFY_REGISTER;
        $this->_typePhoneTag = "\143\x6c\141\163\163\151\146\x79\137\160\x68\157\x6e\x65\x5f\145\156\x61\x62\154\145";
        $this->_typeEmailTag = "\143\154\x61\x73\163\x69\146\x79\137\145\x6d\x61\x69\x6c\137\145\156\x61\142\154\145";
        $this->_formKey = "\x43\x4c\x41\123\123\x49\106\x59\x5f\x52\x45\x47\x49\123\124\105\x52";
        $this->_formName = mo_("\x43\x6c\x61\163\x73\x69\146\171\x20\x54\150\x65\x6d\145\40\x52\x65\x67\151\x73\164\162\x61\x74\151\x6f\156\40\x46\x6f\162\155");
        $this->_isFormEnabled = get_mo_option("\143\x6c\141\x73\x73\151\x66\x79\137\145\x6e\141\142\154\x65");
        $this->_phoneFormId = "\151\156\x70\165\164\133\156\x61\155\145\x3d\x70\150\157\x6e\x65\x5d";
        $this->_formDocuments = MoOTPDocs::CLASSIFY_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\143\154\x61\x73\163\x69\x66\171\x5f\x74\x79\x70\145");
        add_action("\167\160\x5f\145\x6e\161\165\x65\x75\145\137\x73\143\162\x69\160\x74\163", array($this, "\137\163\150\157\x77\x5f\160\150\157\x6e\145\137\146\151\x65\x6c\144\137\x6f\156\x5f\x70\x61\147\145"));
        add_action("\x75\163\x65\162\137\162\x65\147\151\163\164\x65\162", array($this, "\x73\141\x76\x65\x5f\x70\x68\157\156\x65\137\x6e\x75\155\142\x65\162"), 10, 1);
        $this->routeData();
    }
    function routeData()
    {
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto TZ;
        }
        if (!(MoUtility::sanitizeCheck("\157\160\x74\151\x6f\156", $_POST) === "\166\x65\x72\x69\146\x79\137\165\x73\145\x72\137\143\x6c\x61\163\163\151\146\171")) {
            goto vv;
        }
        $this->_handle_classify_theme_form_post($_POST);
        vv:
        goto e8;
        TZ:
        $this->unsetOTPSessionVariables();
        e8:
    }
    function _show_phone_field_on_page()
    {
        wp_enqueue_script("\x63\x6c\141\x73\x73\151\146\171\163\143\162\x69\160\x74", MOV_URL . "\x69\156\x63\x6c\165\x64\145\163\x2f\x6a\x73\57\143\154\141\163\x73\151\x66\x79\x2e\x6d\x69\156\x2e\x6a\163\77\x76\145\162\163\x69\x6f\156\x3d" . MOV_VERSION, array("\152\x71\165\145\x72\171"));
    }
    function _handle_classify_theme_form_post($tT)
    {
        $EN = $tT["\165\x73\145\x72\x6e\141\155\145"];
        $EZ = $tT["\x65\x6d\x61\x69\154"];
        $l1 = $tT["\x70\150\157\156\145"];
        if (!(username_exists($EN) != FALSE)) {
            goto rg;
        }
        return;
        rg:
        if (!(email_exists($EZ) != FALSE)) {
            goto mw;
        }
        return;
        mw:
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0) {
            goto cT;
        }
        if (strcasecmp($this->_otpType, $this->_typeEmailTag) === 0) {
            goto oc;
        }
        $this->sendChallenge($_POST["\x75\x73\x65\x72\x6e\141\x6d\145"], $EZ, null, $l1, "\x62\x6f\164\x68", null, null);
        goto sm;
        oc:
        $this->sendChallenge($_POST["\x75\x73\x65\x72\x6e\x61\x6d\145"], $EZ, null, null, "\145\155\x61\x69\x6c", null, null);
        sm:
        goto MJ;
        cT:
        $this->sendChallenge($_POST["\x75\x73\145\x72\156\x61\x6d\145"], $EZ, null, $l1, "\160\x68\x6f\156\x65", null, null);
        MJ:
    }
    function save_phone_number($wc)
    {
        $ZI = MoPHPSessions::getSessionVar("\160\150\x6f\x6e\x65\x5f\x6e\x75\155\x62\x65\162\137\155\157");
        if (!$ZI) {
            goto J2;
        }
        update_user_meta($wc, "\160\x68\x6f\156\x65", $ZI);
        J2:
    }
    function handle_failed_verification($wE, $MQ, $TB, $au)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto U7;
        }
        return;
        U7:
        $CN = strcasecmp($this->_otpType, $this->_typePhoneTag) === 0 ? "\160\150\x6f\156\x65" : (strcasecmp($this->_otpType, $this->_typeEmailTag) === 0 ? "\x65\155\x61\151\154" : "\x62\157\164\x68");
        $Ta = strcasecmp($CN, "\x62\x6f\164\150") === 0 ? TRUE : FALSE;
        miniorange_site_otp_validation_form($wE, $MQ, $TB, MoUtility::_get_invalid_otp_method(), $CN, $Ta);
    }
    function handle_post_verification($WE, $wE, $MQ, $eW, $TB, $HL, $au)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $au);
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_formSessionVar, $this->_txSessionId));
    }
    public function getPhoneNumberSelector($sq)
    {
        if (!($this->isFormEnabled() && $this->_otpType === $this->_typePhoneTag)) {
            goto HT;
        }
        array_push($sq, $this->_phoneFormId);
        HT:
        return $sq;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto lw;
        }
        return;
        lw:
        $this->_otpType = $this->sanitizeFormPOST("\143\x6c\x61\x73\163\151\146\x79\x5f\x74\x79\x70\145");
        $this->_isFormEnabled = $this->sanitizeFormPOST("\143\x6c\141\163\163\x69\146\x79\137\x65\x6e\141\142\x6c\x65");
        update_mo_option("\143\x6c\x61\163\163\151\146\x79\137\x65\156\x61\142\154\145", $this->_isFormEnabled);
        update_mo_option("\x63\154\x61\163\163\151\146\171\137\164\x79\160\x65", $this->_otpType);
    }
}
