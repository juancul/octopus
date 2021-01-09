<?php


namespace OTP\Handler\Forms;

use mysql_xdevapi\Session;
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
use stdClass;
class SimplrRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::SIMPLR_REG;
        $this->_typePhoneTag = "\155\157\x5f\160\x68\x6f\156\145\x5f\145\x6e\x61\142\154\x65";
        $this->_typeEmailTag = "\x6d\157\137\145\155\x61\x69\x6c\x5f\145\156\141\142\154\145";
        $this->_typeBothTag = "\x6d\x6f\137\x62\x6f\x74\150\x5f\145\156\x61\142\154\x65";
        $this->_formKey = "\123\x49\115\120\114\122\x5f\106\117\x52\x4d";
        $this->_formName = mo_("\x53\151\155\160\154\x72\x20\125\163\x65\162\x20\122\x65\x67\x69\163\x74\x72\x61\164\x69\x6f\x6e\x20\106\x6f\162\x6d\x20\120\154\165\x73");
        $this->_isFormEnabled = get_mo_option("\163\151\155\x70\x6c\162\137\x64\x65\146\x61\165\154\164\137\145\x6e\x61\x62\154\145");
        $this->_formDocuments = MoOTPDocs::SIMPLR_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_formKey = get_mo_option("\163\151\x6d\160\154\162\137\x66\x69\145\x6c\144\137\x6b\145\171");
        $this->_otpType = get_mo_option("\x73\151\x6d\160\154\x72\x5f\x65\156\x61\x62\154\x65\x5f\x74\x79\x70\145");
        $this->_phoneFormId = "\x69\x6e\x70\x75\x74\x5b\156\x61\x6d\145\x3d" . $this->_formKey . "\x5d";
        add_filter("\x73\151\155\x70\x6c\162\x5f\x76\x61\x6c\151\x64\x61\164\x65\x5f\x66\x6f\162\155", array($this, "\163\151\x6d\x70\x6c\162\x5f\163\x69\164\145\x5f\162\145\x67\151\163\164\162\141\164\151\157\156\x5f\145\x72\162\157\x72\x73"), 10, 1);
    }
    function isPhoneVerificationEnabled()
    {
        $CN = $this->getVerificationType();
        return $CN === VerificationType::PHONE || $CN === VerificationType::BOTH;
    }
    function simplr_site_registration_errors($errors)
    {
        $eW = $TB = '';
        if (!(!empty($errors) || isset($_POST["\146\x62\165\163\x65\x72\137\x69\144"]))) {
            goto Vp;
        }
        return $errors;
        Vp:
        foreach ($_POST as $O5 => $Xd) {
            if ($O5 == "\165\163\145\162\156\x61\155\145") {
                goto Rn;
            }
            if ($O5 == "\x65\155\141\x69\154") {
                goto zh;
            }
            if ($O5 == "\160\x61\x73\x73\167\x6f\162\x64") {
                goto vE;
            }
            if ($O5 == $this->_formKey) {
                goto xg;
            }
            $HL[$O5] = $Xd;
            goto FL;
            Rn:
            $EN = $Xd;
            goto FL;
            zh:
            $Vy = $Xd;
            goto FL;
            vE:
            $eW = $Xd;
            goto FL;
            xg:
            $TB = $Xd;
            FL:
            pY:
        }
        LC:
        if (!(strcasecmp($this->_otpType, $this->_typePhoneTag) == 0 && !$this->processPhone($TB, $errors))) {
            goto UR;
        }
        return $errors;
        UR:
        $this->processAndStartOTPVerificationProcess($EN, $Vy, $errors, $TB, $eW, $HL);
        return $errors;
    }
    function processPhone($TB, &$errors)
    {
        if (MoUtility::validatePhoneNumber($TB)) {
            goto Ml;
        }
        global $phoneLogic;
        $errors[] .= str_replace("\x23\43\160\150\x6f\156\145\x23\43", $TB, $phoneLogic->_get_otp_invalid_format_message());
        add_filter($this->_formKey . "\x5f\x65\162\x72\x6f\x72\137\x63\x6c\x61\163\x73", "\137\x73\x72\x65\x67\137\x72\x65\164\x75\162\156\137\x65\x72\162\157\x72");
        return FALSE;
        Ml:
        return TRUE;
    }
    function processAndStartOTPVerificationProcess($EN, $Vy, $errors, $TB, $eW, $HL)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto Po;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) == 0) {
            goto YD;
        }
        $this->sendChallenge($EN, $Vy, $errors, $TB, VerificationType::EMAIL, $eW, $HL);
        goto rG;
        YD:
        $this->sendChallenge($EN, $Vy, $errors, $TB, VerificationType::BOTH, $eW, $HL);
        rG:
        goto Kd;
        Po:
        $this->sendChallenge($EN, $Vy, $errors, $TB, VerificationType::PHONE, $eW, $HL);
        Kd:
    }
    function register_simplr_user($wE, $MQ, $eW, $TB, $HL)
    {
        $tT = array();
        global $sreg;
        if ($sreg) {
            goto G5;
        }
        $sreg = new stdClass();
        G5:
        $tT["\165\163\x65\162\156\x61\x6d\x65"] = $wE;
        $tT["\145\x6d\x61\x69\154"] = $MQ;
        $tT["\160\141\x73\163\x77\x6f\x72\x64"] = $eW;
        if (!$this->_formKey) {
            goto HR;
        }
        $tT[$this->_formKey] = $TB;
        HR:
        $tT = array_merge($tT, $HL);
        $i2 = $HL["\x61\x74\x74\163"];
        $sreg->output = simplr_setup_user($i2, $tT);
        if (!MoUtility::isBlank($sreg->errors)) {
            goto g0;
        }
        $this->checkMessageAndRedirect($i2);
        g0:
    }
    function checkMessageAndRedirect($i2)
    {
        global $sreg, $simplr_options;
        $XD = isset($i2["\x74\150\x61\x6e\x6b\x73"]) ? get_permalink($i2["\x74\150\x61\156\x6b\x73"]) : (!MoUtility::isBlank($simplr_options->thank_you) ? get_permalink($simplr_options->thank_you) : '');
        if (MoUtility::isBlank($XD)) {
            goto aV;
        }
        wp_redirect($XD);
        die;
        goto BD;
        aV:
        $sreg->success = $sreg->output;
        BD:
    }
    function handle_failed_verification($wE, $MQ, $TB, $au)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto Wa;
        }
        return;
        Wa:
        $CN = $this->getVerificationType();
        $Ta = $CN === VerificationType::BOTH ? TRUE : FALSE;
        miniorange_site_otp_validation_form($wE, $MQ, $TB, MoUtility::_get_invalid_otp_method(), $CN, $Ta);
    }
    function handle_post_verification($WE, $wE, $MQ, $eW, $TB, $HL, $au)
    {
        $this->unsetOTPSessionVariables();
        $this->register_simplr_user($wE, $MQ, $eW, $TB, $HL);
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($sq)
    {
        if (!($this->isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto LR;
        }
        array_push($sq, $this->_phoneFormId);
        LR:
        return $sq;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto bS;
        }
        return;
        bS:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\163\x69\x6d\160\154\162\x5f\x64\145\x66\141\165\x6c\x74\137\145\x6e\141\x62\x6c\145");
        $this->_otpType = $this->sanitizeFormPOST("\x73\151\155\x70\x6c\x72\137\145\x6e\x61\x62\x6c\x65\137\164\171\x70\x65");
        $this->_phoneKey = $this->sanitizeFormPOST("\163\x69\x6d\x70\154\x72\137\160\150\x6f\156\145\x5f\x66\151\145\154\x64\137\x6b\x65\171");
        update_mo_option("\163\x69\x6d\160\x6c\x72\x5f\144\145\146\x61\165\x6c\164\137\145\156\x61\142\154\145", $this->_isFormEnabled);
        update_mo_option("\x73\x69\x6d\x70\154\x72\137\145\x6e\x61\x62\154\x65\137\164\x79\x70\145", $this->_otpType);
        update_mo_option("\x73\151\155\160\x6c\x72\137\146\151\145\x6c\144\x5f\153\145\x79", $this->_phoneKey);
    }
}
