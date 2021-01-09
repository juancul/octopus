<?php


namespace OTP\Handler\Forms;

use OTP\Handler\PhoneVerificationLogic;
use OTP\Helper\FormSessionVars;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\BaseMessages;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
use WP_Error;
use BP_Signup;
use WP_User;
class BuddyPressRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::BUDDYPRESS_REG;
        $this->_typePhoneTag = "\x6d\157\x5f\142\142\160\x5f\x70\150\x6f\156\x65\x5f\x65\x6e\x61\142\154\x65";
        $this->_typeEmailTag = "\x6d\x6f\x5f\142\142\160\137\145\x6d\141\151\x6c\x5f\145\156\141\x62\154\145";
        $this->_typeBothTag = "\155\x6f\137\142\x62\x70\x5f\x62\x6f\164\150\x5f\x65\x6e\x61\x62\154\145\144";
        $this->_formKey = "\x42\x50\137\104\x45\106\101\x55\x4c\124\x5f\106\117\122\x4d";
        $this->_formName = mo_("\x42\x75\x64\x64\171\120\x72\145\163\x73\40\122\145\x67\x69\163\164\x72\141\x74\x69\x6f\156\x20\106\x6f\162\x6d");
        $this->_isFormEnabled = get_mo_option("\x62\x62\x70\x5f\x64\x65\146\x61\x75\x6c\164\x5f\x65\156\141\x62\x6c\145");
        $this->_formDocuments = MoOTPDocs::BBP_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_phoneKey = get_mo_option("\x62\x62\160\137\x70\150\x6f\156\145\137\153\145\x79");
        $this->_otpType = get_mo_option("\x62\x62\160\x5f\x65\156\141\x62\154\145\137\x74\x79\160\145");
        $this->_disableAutoActivate = get_mo_option("\x62\142\160\137\x64\151\163\x61\x62\154\x65\137\141\x63\164\x69\x76\x61\164\151\157\x6e");
        $this->_phoneFormId = "\151\156\x70\165\x74\133\x6e\141\x6d\x65\x3d\x66\x69\x65\x6c\144\137" . $this->moBBPgetphoneFieldId() . "\x5d";
        $this->_restrictDuplicates = get_mo_option("\x62\x62\x70\137\x72\145\x73\x74\x72\x69\x63\x74\x5f\x64\x75\x70\154\151\143\x61\164\145\x73");
        add_filter("\142\160\137\162\x65\x67\151\163\164\162\141\164\151\157\156\x5f\156\145\x65\x64\163\x5f\x61\x63\x74\x69\x76\x61\164\151\x6f\156", array($this, "\x66\151\170\x5f\x73\151\147\156\x75\x70\137\146\157\x72\155\x5f\166\x61\x6c\151\144\141\164\151\157\x6e\x5f\x74\x65\x78\164"));
        add_filter("\x62\x70\x5f\143\x6f\162\x65\137\x73\151\147\156\x75\160\137\163\145\x6e\x64\137\141\143\164\151\166\141\164\x69\x6f\x6e\137\x6b\x65\171", array($this, "\x64\x69\163\x61\x62\154\x65\137\x61\143\x74\x69\x76\141\164\x69\x6f\x6e\x5f\x65\x6d\x61\x69\x6c"));
        add_filter("\x62\x70\137\x73\x69\147\x6e\x75\160\137\x75\163\x65\x72\x6d\145\164\x61", array($this, "\155\x69\x6e\151\x6f\x72\x61\x6e\x67\145\137\142\160\137\165\163\x65\162\x5f\162\x65\x67\151\163\164\162\141\164\x69\x6f\x6e"), 1, 1);
        add_action("\142\x70\x5f\163\151\x67\156\165\160\x5f\166\x61\154\x69\x64\141\x74\x65", array($this, "\x76\x61\x6c\x69\x64\141\164\x65\117\124\120\x52\145\x71\x75\145\163\x74"), 99, 0);
        if (!$this->_disableAutoActivate) {
            goto Qh1;
        }
        add_action("\142\160\x5f\x63\157\x72\x65\137\163\x69\147\x6e\165\x70\x5f\x75\163\145\x72", array($this, "\155\x6f\x5f\141\x63\164\x69\x76\x61\x74\x65\137\142\142\160\x5f\x75\163\x65\162"), 1, 5);
        Qh1:
    }
    function fix_signup_form_validation_text()
    {
        return $this->_disableAutoActivate ? FALSE : TRUE;
    }
    function disable_activation_email()
    {
        return $this->_disableAutoActivate ? FALSE : TRUE;
    }
    function isPhoneVerificationEnabled()
    {
        $au = $this->getVerificationType();
        return $au === VerificationType::PHONE || $au === VerificationType::BOTH;
    }
    function validateOTPRequest()
    {
        global $bp, $phoneLogic;
        $m_ = "\x66\151\145\154\144\x5f" . $this->moBBPgetphoneFieldId();
        if (isset($_POST[$m_]) && !MoUtility::validatePhoneNumber($_POST[$m_])) {
            goto Ey0;
        }
        if (!$this->isPhoneNumberAlreadyInUse($_POST[$m_])) {
            goto l8m;
        }
        $bp->signup->errors[$m_] = mo_("\120\150\x6f\x6e\x65\x20\x6e\165\155\142\x65\x72\x20\141\x6c\162\145\x61\x64\x79\x20\151\x6e\x20\165\163\x65\56\x20\x50\154\145\x61\x73\145\x20\x45\x6e\164\145\162\40\x61\x20\144\151\146\x66\145\162\x65\x6e\164\x20\120\150\x6f\156\145\40\x6e\165\x6d\x62\x65\x72\56");
        l8m:
        goto iVF;
        Ey0:
        $bp->signup->errors[$m_] = str_replace("\x23\43\160\x68\157\156\145\43\43", $_POST[$m_], $phoneLogic->_get_otp_invalid_format_message());
        iVF:
    }
    function isPhoneNumberAlreadyInUse($l1)
    {
        if (!$this->_restrictDuplicates) {
            goto rrg;
        }
        global $wpdb;
        $l1 = MoUtility::processPhoneNumber($l1);
        $m_ = $this->moBBPgetphoneFieldId();
        $KA = $wpdb->get_row("\123\105\x4c\x45\103\x54\x20\x60\x75\163\145\162\x5f\x69\144\140\40\x46\x52\117\x4d\40\x60{$wpdb->prefix}\x62\x70\137\170\x70\x72\x6f\146\151\154\145\137\144\x61\x74\141\x60\40\127\x48\x45\122\105\40\140\x66\151\145\x6c\x64\137\x69\x64\140\x20\75\40\47{$m_}\x27\x20\x41\116\x44\40\x60\166\141\154\x75\145\140\40\x3d\40\x20\x27{$l1}\x27");
        return !MoUtility::isBlank($KA);
        rrg:
        return false;
    }
    function checkIfVerificationIsComplete()
    {
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto iWs;
        }
        $this->unsetOTPSessionVariables();
        return TRUE;
        iWs:
        return FALSE;
    }
    function handle_failed_verification($wE, $MQ, $TB, $au)
    {
        $CN = $this->getVerificationType();
        $Ta = VerificationType::BOTH === $CN ? TRUE : FALSE;
        miniorange_site_otp_validation_form($wE, $MQ, $TB, MoUtility::_get_invalid_otp_method(), $CN, $Ta);
    }
    function handle_post_verification($WE, $wE, $MQ, $eW, $TB, $HL, $au)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $au);
    }
    function miniorange_bp_user_registration($ZP)
    {
        if (!$this->checkIfVerificationIsComplete()) {
            goto xlv;
        }
        return $ZP;
        xlv:
        MoUtility::initialize_transaction($this->_formSessionVar);
        $errors = new WP_Error();
        $TB = NULL;
        foreach ($_POST as $O5 => $Xd) {
            if ($O5 === "\x73\x69\x67\156\x75\160\137\x75\163\145\x72\156\x61\x6d\145") {
                goto q0Z;
            }
            if ($O5 === "\163\151\147\x6e\x75\160\137\x65\155\x61\151\x6c") {
                goto StD;
            }
            if ($O5 === "\163\151\147\x6e\165\x70\137\160\141\x73\163\x77\157\162\144") {
                goto Gr1;
            }
            $HL[$O5] = $Xd;
            goto V_U;
            q0Z:
            $EN = $Xd;
            goto V_U;
            StD:
            $Vy = $Xd;
            goto V_U;
            Gr1:
            $eW = $Xd;
            V_U:
            USa:
        }
        y5m:
        $Hn = $this->moBBPgetphoneFieldId();
        if (!isset($_POST["\x66\151\145\154\x64\x5f" . $Hn])) {
            goto gGD;
        }
        $TB = $_POST["\146\151\145\154\x64\137" . $Hn];
        gGD:
        $HL["\165\163\145\x72\x6d\145\164\x61"] = $ZP;
        $this->startVerificationProcess($EN, $Vy, $errors, $TB, $eW, $HL);
        return $ZP;
    }
    function startVerificationProcess($EN, $Vy, $errors, $TB, $eW, $HL)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0) {
            goto XOx;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) === 0) {
            goto o8R;
        }
        $this->sendChallenge($EN, $Vy, $errors, $TB, VerificationType::EMAIL, $eW, $HL);
        goto TBo;
        o8R:
        $this->sendChallenge($EN, $Vy, $errors, $TB, VerificationType::BOTH, $eW, $HL);
        TBo:
        goto pk8;
        XOx:
        $this->sendChallenge($EN, $Vy, $errors, $TB, VerificationType::PHONE, $eW, $HL);
        pk8:
    }
    function mo_activate_bbp_user($Oe, $wE)
    {
        $T_ = $this->moBBPgetActivationKey($wE);
        bp_core_activate_signup($T_);
        BP_Signup::validate($T_);
        $X9 = new WP_User($Oe);
        $X9->add_role("\x73\165\142\x73\143\162\x69\142\x65\x72");
        return;
    }
    function moBBPgetActivationKey($wE)
    {
        global $wpdb;
        return $wpdb->get_var("\123\x45\114\x45\103\124\x20\x61\x63\164\x69\166\x61\164\151\x6f\x6e\x5f\x6b\x65\171\40\x46\x52\117\x4d\40{$wpdb->prefix}\163\151\147\156\x75\160\163\40\x57\x48\x45\x52\105\x20\141\143\164\151\166\x65\40\x3d\x20\x27\60\x27\40\x41\116\104\x20\165\x73\145\162\137\x6c\x6f\147\151\x6e\x20\x3d\x20\x27" . $wE . "\x27");
    }
    function moBBPgetphoneFieldId()
    {
        global $wpdb;
        return $wpdb->get_var("\x53\x45\x4c\105\103\124\x20\x69\144\x20\x46\122\117\x4d\40{$wpdb->prefix}\x62\x70\x5f\170\x70\x72\x6f\x66\151\x6c\145\x5f\x66\151\145\154\144\163\x20\167\x68\145\x72\145\x20\156\141\x6d\x65\40\75\x27" . $this->_phoneKey . "\x27");
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_formSessionVar, $this->_txSessionId));
    }
    public function getPhoneNumberSelector($sq)
    {
        if (!($this->isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto eot;
        }
        array_push($sq, $this->_phoneFormId);
        eot:
        return $sq;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto kH_;
        }
        return;
        kH_:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\142\142\160\x5f\144\145\146\x61\x75\154\164\x5f\145\156\141\142\x6c\145");
        $this->_disableAutoActivate = $this->sanitizeFormPOST("\142\x62\160\x5f\144\151\x73\141\x62\x6c\x65\137\141\143\164\x69\166\x61\164\x69\x6f\x6e");
        $this->_otpType = $this->sanitizeFormPOST("\x62\142\160\137\145\x6e\141\x62\154\x65\137\x74\x79\160\145");
        $this->_phoneKey = $this->sanitizeFormPOST("\x62\x62\x70\x5f\160\x68\157\156\145\137\153\x65\x79");
        $this->_restrictDuplicates = $this->sanitizeFormPOST("\x62\142\160\137\162\145\163\164\162\151\143\164\x5f\x64\165\160\x6c\x69\143\141\164\x65\163");
        if (!$this->basicValidationCheck(BaseMessages::BP_CHOOSE)) {
            goto z28;
        }
        update_mo_option("\142\142\160\x5f\144\145\x66\x61\x75\x6c\164\137\x65\156\141\x62\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\142\142\x70\137\144\151\x73\x61\x62\154\x65\137\x61\143\x74\x69\166\x61\164\151\x6f\156", $this->_disableAutoActivate);
        update_mo_option("\142\x62\160\x5f\145\156\141\142\154\145\137\x74\x79\160\x65", $this->_otpType);
        update_mo_option("\x62\x62\x70\137\162\145\163\164\x72\151\x63\164\137\144\x75\160\x6c\x69\143\141\164\145\163", $this->_restrictDuplicates);
        update_mo_option("\142\x62\160\x5f\160\x68\157\x6e\145\x5f\153\145\x79", $this->_phoneKey);
        z28:
    }
}
