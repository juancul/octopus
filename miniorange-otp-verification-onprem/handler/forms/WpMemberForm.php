<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\BaseMessages;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
class WpMemberForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::WPMEMBER_REG;
        $this->_emailKey = "\x75\163\145\x72\x5f\145\x6d\141\x69\x6c";
        $this->_phoneKey = get_mo_option("\x77\x70\137\155\145\x6d\142\145\x72\x5f\162\145\147\x5f\x70\150\x6f\156\x65\137\x66\151\145\154\x64\137\153\x65\x79");
        $this->_phoneFormId = "\x69\156\x70\x75\164\133\156\141\155\x65\x3d{$this->_phoneKey}\135";
        $this->_formKey = "\127\120\x5f\x4d\105\x4d\102\105\122\137\x46\x4f\122\115";
        $this->_typePhoneTag = "\x6d\x6f\137\167\x70\155\145\x6d\142\x65\x72\137\x72\x65\147\137\160\x68\157\156\145\137\145\156\x61\x62\154\x65";
        $this->_typeEmailTag = "\155\x6f\x5f\167\x70\x6d\145\155\142\145\162\137\162\x65\147\137\x65\x6d\x61\x69\x6c\x5f\x65\156\x61\142\154\145";
        $this->_formName = mo_("\x57\x50\55\x4d\x65\x6d\x62\x65\x72\163");
        $this->_isFormEnabled = get_mo_option("\x77\160\x5f\x6d\x65\155\142\x65\x72\x5f\162\145\x67\x5f\145\x6e\x61\x62\x6c\145");
        $this->_formDocuments = MoOTPDocs::WP_MEMBER_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x77\x70\137\155\x65\x6d\142\145\x72\137\162\145\x67\x5f\x65\156\x61\x62\x6c\x65\137\164\171\160\145");
        add_filter("\x77\x70\x6d\145\155\x5f\x72\145\147\151\x73\164\x65\162\x5f\146\157\x72\x6d\x5f\162\x6f\x77\163", array($this, "\x77\x70\x6d\145\x6d\x62\x65\162\x5f\141\x64\144\137\142\x75\x74\x74\x6f\x6e"), 99, 2);
        add_action("\167\160\155\x65\155\x5f\160\162\x65\137\162\x65\x67\x69\163\x74\145\162\137\144\x61\x74\141", array($this, "\x76\x61\154\x69\144\141\x74\145\x5f\167\x70\x6d\145\155\x62\x65\x72\x5f\163\165\142\155\151\x74"), 99, 1);
        $this->routeData();
    }
    function routeData()
    {
        if (array_key_exists("\157\x70\164\x69\x6f\x6e", $_REQUEST)) {
            goto ipt;
        }
        return;
        ipt:
        switch (trim($_REQUEST["\157\160\x74\x69\157\x6e"])) {
            case "\155\x69\x6e\151\157\x72\141\156\x67\x65\x2d\167\x70\x6d\x65\x6d\142\x65\x72\55\146\x6f\x72\155":
                $this->_handle_wp_member_form($_POST);
                goto yOn;
        }
        O35:
        yOn:
    }
    function _handle_wp_member_form($tT)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (!($this->_otpType === $this->_typeEmailTag)) {
            goto FoS;
        }
        $this->processEmailAndStartOTPVerificationProcess($tT);
        FoS:
        if (!($this->_otpType === $this->_typePhoneTag)) {
            goto B0B;
        }
        $this->processPhoneAndStartOTPVerificationProcess($tT);
        B0B:
    }
    function processEmailAndStartOTPVerificationProcess($tT)
    {
        if (MoUtility::sanitizeCheck("\165\163\x65\162\137\145\x6d\141\151\x6c", $tT)) {
            goto kR4;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        goto cJF;
        kR4:
        SessionUtils::addEmailVerified($this->_formSessionVar, $tT["\x75\x73\145\162\137\x65\155\x61\151\x6c"]);
        $this->sendChallenge(null, $tT["\x75\163\145\162\x5f\x65\155\141\151\x6c"], null, '', VerificationType::EMAIL, null, null, false);
        cJF:
    }
    function processPhoneAndStartOTPVerificationProcess($tT)
    {
        if (MoUtility::sanitizeCheck("\165\163\145\x72\137\160\150\x6f\x6e\x65", $tT)) {
            goto PGN;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        goto JEK;
        PGN:
        SessionUtils::addPhoneVerified($this->_formSessionVar, $tT["\165\x73\145\162\x5f\160\x68\157\x6e\x65"]);
        $this->sendChallenge(null, '', null, $tT["\165\163\145\x72\137\x70\x68\157\156\145"], VerificationType::PHONE, null, null, false);
        JEK:
    }
    function wpmember_add_button($C1, $Xr)
    {
        foreach ($C1 as $O5 => $DH) {
            if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0 && $O5 === $this->_phoneKey) {
                goto FZ1;
            }
            if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) === 0 && $O5 === $this->_emailKey)) {
                goto CG2;
            }
            $C1[$O5]["\x66\x69\x65\x6c\144"] .= $this->_add_shortcode_to_wpmember("\145\155\x61\x69\x6c", $DH["\x6d\145\x74\141"]);
            goto a8n;
            CG2:
            goto VQk;
            FZ1:
            $C1[$O5]["\146\x69\145\154\x64"] .= $this->_add_shortcode_to_wpmember("\x70\150\157\x6e\145", $DH["\155\145\164\x61"]);
            goto a8n;
            VQk:
            b2p:
        }
        a8n:
        return $C1;
    }
    function validate_wpmember_submit($K_)
    {
        global $wpmem_themsg;
        $au = $this->getVerificationType();
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto jsh;
        }
        $wpmem_themsg = MoMessages::showMessage(MoMessages::PLEASE_VALIDATE);
        jsh:
        if ($this->validate_submitted($K_, $au)) {
            goto Igd;
        }
        return;
        Igd:
        $this->validateChallenge($au, NULL, $K_["\x76\x61\x6c\151\144\141\164\x65\x5f\x6f\164\x70"]);
    }
    function validate_submitted($K_, $au)
    {
        global $wpmem_themsg;
        if ($au === VerificationType::EMAIL && !SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $K_[$this->_emailKey])) {
            goto qSA;
        }
        if ($au == VerificationType::PHONE && !SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $K_[$this->_phoneKey])) {
            goto Sl2;
        }
        return true;
        goto sTX;
        Sl2:
        $wpmem_themsg = MoMessages::showMessage(MoMessages::PHONE_MISMATCH);
        return false;
        sTX:
        goto Hf1;
        qSA:
        $wpmem_themsg = MoMessages::showMessage(MoMessages::EMAIL_MISMATCH);
        return false;
        Hf1:
    }
    function _add_shortcode_to_wpmember($CV, $DH)
    {
        $G0 = "\x3c\x64\x69\x76\40\x73\x74\171\154\x65\75\47\144\151\x73\160\x6c\141\171\x3a\x74\141\x62\x6c\145\x3b\164\145\170\164\x2d\141\154\x69\x67\156\x3a\x63\145\x6e\164\145\162\73\x27\76\x3c\151\155\147\40\163\x72\x63\75\x27" . MOV_URL . "\x69\156\143\x6c\165\144\x65\x73\x2f\151\155\x61\147\145\x73\x2f\154\x6f\141\144\145\x72\56\x67\151\x66\47\76\74\x2f\x64\151\166\x3e";
        $IL = "\74\x64\x69\166\40\163\164\x79\x6c\x65\x3d\x27\x6d\x61\162\147\151\x6e\55\164\157\160\x3a\x20\62\45\x3b\x27\76\x3c\142\165\164\x74\x6f\x6e\x20\x74\x79\160\145\x3d\47\142\x75\x74\x74\157\156\47\40\143\154\x61\x73\x73\75\x27\x62\165\164\164\x6f\156\40\x61\x6c\x74\x27\x20\x73\164\171\x6c\145\x3d\47\167\x69\x64\164\150\x3a\x31\x30\60\x25\x3b\150\x65\151\147\x68\x74\72\63\60\160\x78\x3b";
        $IL .= "\146\157\156\x74\x2d\x66\141\x6d\x69\x6c\x79\72\40\x52\157\142\157\164\x6f\x3b\146\157\x6e\164\55\163\x69\x7a\x65\x3a\40\x31\62\160\x78\x20\41\151\x6d\x70\x6f\162\x74\x61\156\164\x3b\x27\x20\x69\144\x3d\47\x6d\x69\x6e\x69\x6f\x72\141\x6e\x67\x65\x5f\x6f\x74\160\x5f\164\157\153\145\156\x5f\x73\x75\x62\x6d\x69\x74\x27\x20";
        $IL .= "\x74\x69\x74\154\x65\75\47\120\154\145\141\163\145\x20\105\x6e\x74\x65\x72\x20\x61\x6e\40\47" . $CV . "\47\x74\x6f\x20\x65\x6e\141\142\x6c\145\x20\164\150\x69\x73\x2e\x27\76\x43\x6c\151\x63\x6b\40\110\145\162\145\x20\x74\157\40\x56\145\162\x69\x66\x79\40" . $CV . "\74\x2f\142\165\164\x74\x6f\x6e\76\74\x2f\x64\x69\x76\76";
        $IL .= "\x3c\x64\x69\x76\x20\x73\x74\x79\x6c\145\75\47\x6d\141\162\x67\151\156\55\x74\x6f\160\72\x32\45\47\76\74\144\151\166\40\x69\x64\x3d\x27\x6d\157\137\x6d\145\163\x73\141\x67\x65\x27\x20\x68\x69\x64\x64\x65\156\x3d\x27\47\x20\163\x74\x79\154\x65\75\47\142\x61\x63\x6b\x67\x72\x6f\x75\156\144\55\143\157\x6c\157\162\72\40\x23\146\x37\146\66\x66\67\73\x70\x61\x64\x64\151\156\x67\x3a\x20";
        $IL .= "\x31\145\x6d\40\x32\x65\155\x20\61\145\x6d\x20\63\56\65\x65\155\x3b\x27\x3e\74\57\144\151\166\x3e\x3c\57\144\x69\166\76";
        $IL .= "\x3c\163\x63\x72\x69\160\164\76\x6a\x51\165\x65\x72\171\50\x64\x6f\x63\165\155\x65\x6e\x74\51\x2e\x72\145\x61\x64\171\50\146\x75\156\143\x74\x69\x6f\156\x28\x29\173\x24\155\157\x3d\x6a\x51\x75\x65\x72\x79\x3b\x24\155\x6f\50\42\43\155\x69\x6e\151\x6f\162\141\156\147\145\137\157\164\160\x5f\x74\x6f\153\x65\x6e\137\163\165\142\x6d\x69\164\42\51\x2e\143\x6c\x69\143\153\x28\146\165\x6e\143\x74\x69\157\156\x28\157\51\173\40";
        $IL .= "\x76\x61\x72\40\145\x3d\x24\x6d\157\50\42\x69\x6e\160\165\164\x5b\x6e\x61\x6d\145\x3d" . $DH . "\x5d\x22\51\x2e\166\x61\154\x28\51\x3b\40\x24\x6d\157\x28\42\43\155\x6f\137\155\145\x73\163\141\147\145\x22\51\x2e\145\x6d\160\x74\x79\50\x29\x2c\44\x6d\157\50\x22\43\x6d\157\137\x6d\145\163\x73\141\147\145\42\x29\56\141\x70\x70\145\156\144\50\42" . $G0 . "\x22\51\54";
        $IL .= "\x24\155\x6f\x28\x22\x23\x6d\x6f\x5f\155\x65\x73\x73\141\147\145\42\51\56\163\x68\x6f\167\50\x29\54\x24\155\157\x2e\141\x6a\x61\170\50\173\x75\162\154\72\42" . site_url() . "\57\77\157\160\x74\151\157\x6e\x3d\x6d\x69\156\151\157\162\141\156\x67\145\55\x77\x70\x6d\x65\x6d\x62\x65\x72\55\x66\157\162\x6d\x22\x2c\164\x79\x70\145\72\x22\120\x4f\x53\x54\42\54";
        $IL .= "\x64\x61\164\x61\x3a\173\165\x73\145\x72\137" . $CV . "\72\x65\175\x2c\143\x72\x6f\x73\x73\x44\157\155\x61\151\156\72\x21\x30\54\x64\x61\164\x61\x54\171\x70\x65\x3a\42\x6a\x73\x6f\x6e\x22\54\x73\x75\x63\x63\145\x73\x73\72\x66\x75\x6e\143\164\151\157\156\x28\157\51\173\x20";
        $IL .= "\151\146\x28\x6f\x2e\x72\x65\163\x75\x6c\164\75\x3d\75\x22\163\x75\x63\x63\x65\163\163\x22\x29\x7b\x24\x6d\x6f\50\42\43\155\x6f\137\x6d\145\163\163\141\147\x65\x22\51\x2e\x65\x6d\160\164\171\x28\x29\x2c\44\155\x6f\50\x22\x23\x6d\157\137\x6d\145\163\163\141\147\x65\x22\x29\56\x61\160\160\145\156\x64\x28\x6f\56\155\x65\x73\x73\x61\x67\x65\51\x2c";
        $IL .= "\x24\x6d\x6f\50\x22\x23\155\x6f\x5f\155\145\x73\x73\x61\x67\x65\42\x29\56\x63\x73\x73\50\x22\x62\157\162\144\145\162\x2d\x74\x6f\160\x22\54\x22\x33\160\170\40\163\x6f\154\x69\x64\40\147\x72\145\x65\156\x22\51\54\44\x6d\x6f\50\42\x69\x6e\x70\165\x74\x5b\x6e\x61\155\x65\x3d\x65\x6d\141\x69\x6c\x5f\166\x65\x72\x69\146\171\x5d\42\51\56\146\x6f\x63\x75\163\50\51\x7d\x65\154\163\x65\173";
        $IL .= "\x24\155\x6f\x28\42\43\155\x6f\x5f\155\145\163\x73\141\x67\145\42\x29\x2e\x65\155\160\164\x79\x28\51\54\x24\x6d\157\x28\42\x23\155\157\137\x6d\145\163\163\141\147\x65\42\x29\x2e\141\x70\160\145\156\x64\50\157\56\x6d\145\x73\163\x61\x67\x65\51\x2c\x24\x6d\157\50\42\43\155\x6f\x5f\x6d\145\x73\163\x61\147\145\42\51\56\143\163\x73\x28\42\x62\x6f\162\x64\145\162\55\164\x6f\160\x22\x2c\42\63\x70\170\x20\163\157\x6c\151\x64\40\x72\x65\x64\x22\x29";
        $IL .= "\54\44\x6d\x6f\x28\42\x69\156\x70\165\x74\x5b\156\x61\155\x65\x3d\x70\150\157\156\x65\x5f\166\145\162\x69\146\171\135\42\51\56\146\157\x63\x75\x73\50\51\175\40\x3b\175\54\x65\x72\x72\157\162\72\146\x75\156\x63\164\151\157\156\50\x6f\54\145\54\x6e\x29\x7b\175\x7d\x29\x7d\51\x3b\x7d\x29\73\74\x2f\x73\x63\162\x69\x70\x74\76";
        return $IL;
    }
    function handle_failed_verification($wE, $MQ, $TB, $au)
    {
        global $wpmem_themsg;
        $wpmem_themsg = MoUtility::_get_invalid_otp_method();
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
        if (!($this->isFormEnabled() && $this->_otpType === $this->_typePhoneTag)) {
            goto haY;
        }
        array_push($sq, $this->_phoneFormId);
        haY:
        return $sq;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto rlb;
        }
        return;
        rlb:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\167\160\137\155\145\155\x62\x65\x72\x5f\x72\145\x67\x5f\x65\156\x61\x62\154\x65");
        $this->_otpType = $this->sanitizeFormPOST("\167\160\x5f\x6d\145\x6d\142\x65\x72\x5f\162\x65\x67\x5f\x65\156\141\142\154\145\x5f\164\x79\160\145");
        $this->_phoneKey = $this->sanitizeFormPOST("\167\160\137\155\145\x6d\142\x65\x72\137\162\145\147\x5f\x70\150\157\x6e\x65\x5f\x66\x69\x65\154\x64\137\153\x65\171");
        if (!$this->basicValidationCheck(BaseMessages::WP_MEMBER_CHOOSE)) {
            goto ePU;
        }
        update_mo_option("\x77\160\x5f\x6d\145\155\142\145\x72\x5f\x72\145\147\137\160\x68\x6f\156\x65\x5f\146\151\x65\x6c\x64\137\x6b\x65\171", $this->_phoneKey);
        update_mo_option("\x77\160\137\155\145\x6d\142\145\162\137\162\x65\147\x5f\145\156\x61\142\154\x65", $this->_isFormEnabled);
        update_mo_option("\x77\x70\137\x6d\x65\x6d\x62\145\x72\137\162\x65\x67\x5f\145\156\x61\x62\x6c\145\x5f\164\171\x70\x65", $this->_otpType);
        ePU:
    }
}
