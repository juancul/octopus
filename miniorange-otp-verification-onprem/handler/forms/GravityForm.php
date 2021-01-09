<?php


namespace OTP\Handler\Forms;

use GF_Field;
use GFAPI;
use OTP\Helper\FormSessionVars;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
class GravityForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::GF_FORMS;
        $this->_typePhoneTag = "\x6d\x6f\x5f\x67\146\x5f\x63\x6f\x6e\164\x61\x63\164\x5f\x70\x68\x6f\x6e\145\x5f\x65\156\141\x62\x6c\145";
        $this->_typeEmailTag = "\x6d\x6f\x5f\x67\x66\x5f\143\157\x6e\x74\x61\143\x74\137\x65\x6d\x61\151\x6c\x5f\x65\156\x61\x62\x6c\x65";
        $this->_formKey = "\x47\122\x41\126\x49\124\x59\137\x46\117\x52\x4d";
        $this->_formName = mo_("\x47\162\141\x76\x69\164\x79\x20\106\x6f\x72\x6d");
        $this->_isFormEnabled = get_mo_option("\x67\146\137\143\157\x6e\164\x61\x63\164\137\145\x6e\141\x62\x6c\x65");
        $this->_phoneFormId = "\x2e\x67\x69\156\160\165\x74\x5f\143\157\x6e\x74\141\151\156\x65\162\137\160\150\157\x6e\x65";
        $this->_buttonText = get_mo_option("\147\x66\137\142\165\x74\164\x6f\x6e\137\x74\x65\170\164");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\103\x6c\x69\x63\153\40\x48\145\162\145\40\x74\157\x20\x73\x65\x6e\144\40\117\x54\120");
        $this->_formDocuments = MoOTPDocs::GF_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\147\x66\137\x63\157\x6e\x74\x61\143\x74\x5f\164\171\160\145");
        $this->_formDetails = maybe_unserialize(get_mo_option("\147\146\x5f\157\x74\160\137\145\156\141\142\154\x65\x64"));
        if (!empty($this->_formDetails)) {
            goto HK;
        }
        return;
        HK:
        add_filter("\x67\x66\157\162\x6d\x5f\146\x69\145\154\144\x5f\143\x6f\156\x74\145\x6e\x74", array($this, "\x5f\x61\x64\144\137\x73\143\162\151\160\x74\163"), 1, 5);
        add_filter("\147\146\x6f\162\155\x5f\146\151\145\154\144\137\x76\141\x6c\x69\144\x61\164\151\157\156", array($this, "\166\x61\x6c\151\144\141\164\145\137\x66\x6f\162\x6d\137\163\165\x62\x6d\151\x74"), 1, 5);
        $this->routeData();
    }
    function routeData()
    {
        if (array_key_exists("\x6f\160\164\x69\157\156", $_GET)) {
            goto X7;
        }
        return;
        X7:
        switch (trim($_GET["\157\x70\x74\151\157\x6e"])) {
            case "\x6d\x69\x6e\151\157\x72\141\156\x67\x65\x2d\x67\146\x2d\143\157\x6e\x74\x61\143\164":
                $this->_handle_gf_form($_POST);
                goto Db;
        }
        Ll:
        Db:
    }
    function _handle_gf_form($QV)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (!($this->_otpType === $this->_typeEmailTag)) {
            goto mB;
        }
        $this->processEmailAndStartOTPVerificationProcess($QV);
        mB:
        if (!($this->_otpType === $this->_typePhoneTag)) {
            goto Kr;
        }
        $this->processPhoneAndStartOTPVerificationProcess($QV);
        Kr:
    }
    function processEmailAndStartOTPVerificationProcess($QV)
    {
        if (MoUtility::sanitizeCheck("\165\163\x65\162\x5f\145\x6d\141\x69\154", $QV)) {
            goto ds;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        goto OL;
        ds:
        SessionUtils::addEmailVerified($this->_formSessionVar, $QV["\165\x73\x65\162\x5f\145\155\x61\151\x6c"]);
        $this->sendChallenge('', $QV["\165\x73\145\x72\x5f\145\155\x61\x69\x6c"], null, $QV["\x75\163\145\x72\137\x65\155\141\x69\154"], VerificationType::EMAIL);
        OL:
    }
    function processPhoneAndStartOTPVerificationProcess($QV)
    {
        if (MoUtility::sanitizeCheck("\x75\x73\145\x72\137\x70\x68\157\156\145", $QV)) {
            goto hB;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        goto DC;
        hB:
        SessionUtils::addPhoneVerified($this->_formSessionVar, trim($QV["\165\x73\145\162\137\160\150\157\156\145"]));
        $this->sendChallenge('', '', null, trim($QV["\165\x73\145\162\x5f\x70\x68\x6f\x6e\x65"]), VerificationType::PHONE);
        DC:
    }
    function _add_scripts($IL, $DH, $Xd, $kM, $K5)
    {
        $p8 = $this->_formDetails[$K5];
        if (MoUtility::isBlank($p8)) {
            goto tm;
        }
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) === 0 && get_class($DH) === "\107\x46\137\x46\x69\145\154\x64\x5f\x45\155\x61\x69\154" && $DH["\151\x64"] == $p8["\145\x6d\141\151\x6c\x6b\x65\x79"])) {
            goto Dz;
        }
        $IL = $this->_add_shortcode_to_form("\145\155\x61\x69\154", $IL, $DH, $K5);
        Dz:
        if (!(strcasecmp($this->_otpType, $this->_typePhoneTag) === 0 && get_class($DH) === "\107\106\x5f\x46\x69\x65\x6c\x64\x5f\120\x68\157\x6e\145" && $DH["\151\144"] == $p8["\x70\x68\157\x6e\x65\153\x65\171"])) {
            goto zI;
        }
        $IL = $this->_add_shortcode_to_form("\x70\x68\157\x6e\145", $IL, $DH, $K5);
        zI:
        tm:
        return $IL;
    }
    function _add_shortcode_to_form($CV, $IL, $DH, $K5)
    {
        $G0 = "\74\144\151\166\x20\163\164\x79\154\145\x3d\47\x64\151\x73\160\x6c\141\x79\72\x74\x61\142\154\145\x3b\x74\145\x78\164\x2d\x61\154\151\147\x6e\72\x63\145\x6e\x74\x65\162\x3b\47\x3e\74\151\x6d\147\40\x73\162\x63\x3d\x27" . MOV_URL . "\x69\x6e\143\x6c\x75\x64\x65\x73\x2f\151\x6d\141\147\145\163\x2f\x6c\157\x61\144\x65\x72\56\x67\151\146\x27\76\74\57\144\151\x76\76";
        $IL .= "\x3c\x64\151\x76\40\x73\164\x79\x6c\x65\x3d\47\155\x61\162\147\x69\x6e\x2d\x74\157\x70\72\40\62\45\73\47\76\74\151\156\160\x75\164\x20\x74\x79\x70\x65\75\47\x62\165\164\x74\157\x6e\47\40\143\x6c\141\163\x73\75\x27\x67\x66\x6f\162\155\x5f\x62\x75\164\x74\x6f\x6e\x20\142\x75\x74\x74\x6f\x6e\40\155\x65\144\x69\165\155\x27\40";
        $IL .= "\x69\x64\x3d\x27\155\151\x6e\x69\x6f\162\x61\156\147\x65\x5f\157\x74\x70\x5f\164\x6f\153\x65\x6e\137\x73\x75\x62\155\151\164\47\40\164\x69\x74\x6c\145\75\x27\120\x6c\x65\x61\x73\145\40\x45\156\164\x65\x72\x20\141\x6e\40" . $CV . "\40\x74\157\40\x65\156\141\x62\154\145\x20\164\150\151\163\47\x20";
        $IL .= "\166\141\154\165\145\x3d\x20\47" . mo_($this->_buttonText) . "\47\76\x3c\144\x69\166\40\x73\164\171\154\145\75\47\x6d\141\162\147\x69\x6e\x2d\x74\157\160\x3a\x32\x25\47\76";
        $IL .= "\74\x64\x69\166\40\x69\x64\x3d\47\x6d\x6f\x5f\155\x65\x73\163\x61\147\x65\47\40\x68\x69\144\144\x65\156\75\47\x27\40\x73\164\171\x6c\x65\75\x27\x62\x61\143\x6b\147\162\157\165\156\144\x2d\143\x6f\x6c\157\x72\72\40\43\x66\x37\x66\66\x66\67\x3b\x70\x61\144\144\x69\156\147\72\x20\61\x65\155\40\x32\145\x6d\x20\x31\145\x6d\x20\x33\x2e\x35\145\155\73\x27\x3e\74\x2f\x64\151\166\x3e\x3c\57\x64\151\x76\x3e\74\x2f\x64\151\x76\76";
        $IL .= "\x3c\x73\x74\171\x6c\145\76\100\155\145\x64\151\141\40\x6f\x6e\x6c\x79\40\x73\x63\x72\x65\145\156\40\x61\x6e\144\x20\50\x6d\151\x6e\x2d\167\151\x64\x74\150\72\x20\x36\x34\x31\160\170\51\x20\173\40\43\155\x6f\x5f\x6d\145\163\x73\141\x67\x65\40\x7b\40\x77\151\144\x74\x68\72\x20\x63\141\154\x63\50\x35\60\45\x20\55\x20\x38\x70\170\51\73\x7d\x7d\74\57\163\x74\171\x6c\145\76";
        $IL .= "\74\163\143\162\x69\x70\164\x3e\152\121\x75\145\162\x79\50\x64\x6f\143\165\155\x65\x6e\x74\x29\56\162\x65\141\144\171\50\x66\x75\156\x63\x74\x69\x6f\x6e\x28\51\173\x24\155\157\x3d\152\x51\165\145\162\171\73\44\x6d\x6f\50\x22\43\x67\146\157\162\155\x5f" . $K5 . "\x20\x23\x6d\151\156\x69\x6f\162\141\156\x67\145\x5f\157\164\x70\137\164\157\153\145\156\x5f\x73\165\x62\x6d\x69\164\42\51\56\x63\154\x69\x63\153\50\x66\165\x6e\143\164\151\x6f\x6e\50\x6f\x29\x7b";
        $IL .= "\x76\141\x72\40\145\x3d\x24\155\157\x28\x22\43\x69\156\160\165\164\137" . $K5 . "\137" . $DH->id . "\42\x29\56\166\x61\x6c\50\x29\x3b\x20\x24\155\157\50\42\43\x67\x66\x6f\162\155\137" . $K5 . "\x20\43\x6d\x6f\137\155\x65\163\163\141\147\x65\42\51\x2e\145\x6d\160\x74\x79\50\x29\x2c\44\155\157\50\x22\x23\147\x66\157\162\x6d\x5f" . $K5 . "\x20\43\x6d\157\x5f\155\145\x73\x73\141\147\145\42\51\x2e\x61\x70\160\x65\156\x64\50\x22" . $G0 . "\x22\x29";
        $IL .= "\x2c\44\155\x6f\x28\x22\43\x67\146\x6f\162\155\137" . $K5 . "\x20\x23\x6d\x6f\137\155\x65\x73\163\x61\147\145\42\x29\x2e\x73\150\157\167\50\51\54\44\x6d\157\56\x61\152\141\x78\x28\173\x75\x72\154\72\x22" . site_url() . "\57\77\157\160\164\151\157\x6e\x3d\x6d\151\156\151\x6f\x72\x61\156\147\x65\x2d\147\146\x2d\x63\x6f\x6e\x74\141\x63\164\x22\x2c\x74\171\x70\x65\72\42\x50\117\x53\x54\x22\54\x64\x61\164\141\72\173\165\x73\145\162\x5f";
        $IL .= $CV . "\x3a\x65\x7d\x2c\x63\162\x6f\163\x73\x44\x6f\155\x61\151\x6e\72\41\x30\x2c\144\141\164\x61\124\171\x70\145\72\x22\152\163\x6f\156\x22\x2c\x73\x75\x63\x63\145\163\x73\x3a\x66\x75\x6e\143\x74\x69\x6f\x6e\x28\x6f\51\173\40\151\x66\x28\x6f\x2e\x72\145\x73\x75\x6c\x74\x3d\75\75\x22\x73\165\143\x63\x65\x73\x73\42\x29\x7b\x24\155\157\50\42\43\147\x66\x6f\162\x6d\x5f" . $K5 . "\x20\x23\155\x6f\x5f\155\x65\x73\163\x61\147\145\x22\x29\x2e\x65\155\160\x74\171\x28\x29";
        $IL .= "\54\x24\155\157\x28\x22\43\x67\x66\157\162\x6d\x5f" . $K5 . "\40\43\x6d\x6f\x5f\x6d\145\163\x73\141\147\x65\42\x29\x2e\141\x70\160\x65\x6e\x64\50\157\56\155\145\x73\x73\141\147\x65\x29\x2c\44\155\157\50\x22\43\147\146\x6f\162\155\x5f" . $K5 . "\x20\x23\155\x6f\x5f\155\145\163\163\x61\x67\x65\x22\x29\x2e\x63\x73\x73\x28\42\142\x6f\162\144\x65\162\55\164\157\160\42\54\x22\63\160\x78\40\163\x6f\x6c\x69\x64\40\147\162\x65\x65\156\x22\51\54\x24\x6d\x6f\50\x22";
        $IL .= "\43\147\x66\157\x72\x6d\137" . $K5 . "\40\x69\x6e\160\165\x74\x5b\156\x61\155\145\75\x65\x6d\141\x69\154\x5f\166\145\x72\151\146\x79\x5d\x22\51\x2e\x66\157\x63\x75\163\50\x29\175\145\x6c\x73\145\173\44\x6d\x6f\x28\42\x23\147\146\x6f\x72\155\137" . $K5 . "\40\x23\x6d\157\137\x6d\145\x73\x73\x61\x67\x65\x22\51\56\x65\155\160\164\x79\50\x29\54\44\155\x6f\x28\42\x23\x67\146\x6f\x72\x6d\137" . $K5 . "\x20\43\x6d\157\137\x6d\x65\163\x73\x61\147\145\42\x29\56\x61\160\x70\145\x6e\x64\x28\157\x2e\155\145\163\163\141\147\x65\x29\54";
        $IL .= "\x24\x6d\157\x28\x22\43\147\x66\157\162\155\137" . $K5 . "\40\x23\155\x6f\x5f\x6d\x65\163\x73\x61\147\x65\x22\x29\56\x63\x73\x73\50\42\x62\x6f\x72\144\x65\x72\x2d\164\157\160\x22\x2c\x22\x33\x70\x78\40\163\157\x6c\151\x64\40\162\145\x64\42\x29\54\44\x6d\x6f\x28\42\43\x67\x66\x6f\x72\155\x5f" . $K5 . "\x20\x69\156\160\165\x74\x5b\156\141\155\x65\x3d\x70\150\x6f\x6e\145\x5f\x76\145\162\x69\146\x79\135\x22\x29\56\x66\157\143\165\163\x28\x29\175\40\73\x7d\54";
        $IL .= "\145\x72\x72\x6f\x72\x3a\146\x75\156\x63\x74\x69\x6f\x6e\50\157\54\145\54\x6e\51\x7b\175\175\x29\175\51\x3b\175\x29\x3b\74\57\x73\x63\x72\151\160\x74\x3e";
        return $IL;
    }
    function validate_form_submit($zu, $Xd, $form, $DH)
    {
        $qG = MoUtility::sanitizeCheck($DH->formId, $this->_formDetails);
        if (!($qG && $zu["\x69\x73\137\166\x61\x6c\x69\x64"] == 1)) {
            goto Hm;
        }
        if (strpos($DH->label, $qG["\166\x65\162\x69\146\171\113\x65\x79"]) !== false && SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto Jc;
        }
        if (!$this->isEmailOrPhoneField($DH, $qG)) {
            goto Jn;
        }
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto xk;
        }
        $zu = array("\x69\163\137\166\141\x6c\x69\x64" => null, "\155\145\x73\163\141\147\x65" => MoMessages::showMessage(MoMessages::PLEASE_VALIDATE));
        goto Oe;
        xk:
        $zu = $this->validate_submitted_email_or_phone($zu["\151\x73\137\x76\x61\x6c\151\144"], $Xd, $zu);
        Oe:
        Jn:
        goto dj;
        Jc:
        $zu = $this->validate_otp($zu, $Xd);
        dj:
        Hm:
        return $zu;
    }
    function validate_otp($zu, $Xd)
    {
        $au = $this->getVerificationType();
        if (MoUtility::isBlank($Xd)) {
            goto eT;
        }
        $this->validateChallenge($au, NULL, $Xd);
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $au)) {
            goto ck;
        }
        $this->unsetOTPSessionVariables();
        goto BP;
        ck:
        $zu = array("\x69\163\137\x76\141\x6c\x69\144" => null, "\155\x65\163\163\141\147\x65" => MoUtility::_get_invalid_otp_method());
        BP:
        goto x7;
        eT:
        $zu = array("\x69\163\137\166\x61\154\x69\144" => null, "\x6d\x65\163\163\x61\x67\145" => MoUtility::_get_invalid_otp_method());
        x7:
        return $zu;
    }
    function validate_submitted_email_or_phone($yd, $Xd, $zu)
    {
        $au = $this->getVerificationType();
        if (!$yd) {
            goto Tt;
        }
        if ($au === VerificationType::EMAIL && !SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $Xd)) {
            goto DG;
        }
        if (!($au === VerificationType::PHONE && !SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $Xd))) {
            goto JZ;
        }
        return array("\151\x73\x5f\166\141\x6c\151\x64" => null, "\155\x65\x73\163\x61\147\x65" => MoMessages::showMessage(MoMessages::PHONE_MISMATCH));
        JZ:
        goto Fn1;
        DG:
        return array("\x69\163\137\x76\141\x6c\151\144" => null, "\x6d\145\163\163\x61\x67\145" => MoMessages::showMessage(MoMessages::EMAIL_MISMATCH));
        Fn1:
        Tt:
        return $zu;
    }
    function handle_failed_verification($wE, $MQ, $TB, $au)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VERIFICATION_FAILED, $au);
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
        if (!($this->isFormEnabled() && $this->_otpType === $this->_typePhoneTag)) {
            goto xW;
        }
        foreach ($this->_formDetails as $O5 => $xA) {
            $C9 = sprintf("\45\163\137\45\144\x5f\45\144", "\151\x6e\160\x75\x74", $O5, $xA["\160\x68\157\x6e\x65\153\x65\x79"]);
            array_push($sq, sprintf("\x25\163\40\43\45\x73", $this->_phoneFormId, $C9));
            jx:
        }
        vj:
        xW:
        return $sq;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto Rt;
        }
        return;
        Rt:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\147\x66\137\143\157\156\164\141\x63\164\137\145\x6e\x61\142\x6c\x65");
        $this->_otpType = $this->sanitizeFormPOST("\147\146\x5f\x63\x6f\156\x74\x61\x63\x74\137\x74\x79\x70\x65");
        $this->_buttonText = $this->sanitizeFormPOST("\147\x66\x5f\142\x75\x74\164\157\x6e\x5f\164\x65\170\164");
        $rf = $this->parseFormDetails();
        $this->_formDetails = is_array($rf) ? $rf : '';
        update_mo_option("\x67\146\137\157\x74\160\x5f\145\x6e\141\142\x6c\x65\x64", maybe_serialize($this->_formDetails));
        update_mo_option("\147\146\x5f\143\157\x6e\164\141\143\164\137\145\x6e\x61\x62\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\147\146\x5f\x63\x6f\x6e\x74\141\143\x74\x5f\x74\171\160\145", $this->_otpType);
        update_mo_option("\x67\146\137\142\165\164\164\x6f\x6e\x5f\164\x65\x78\164", $this->_buttonText);
    }
    private function parseFormDetails()
    {
        $rf = array();
        $xK = function ($PW, $Jb, $qf) {
            foreach ($PW as $DH) {
                if (!(get_class($DH) === $qf && $DH["\x6c\x61\x62\x65\x6c"] == $Jb)) {
                    goto sE;
                }
                return $DH["\x69\144"];
                sE:
                dy:
            }
            Fk:
            return null;
        };
        $form = NULL;
        if (!(!array_key_exists("\147\162\141\x76\x69\x74\171\137\x66\x6f\162\x6d", $_POST) || !$this->_isFormEnabled)) {
            goto M_;
        }
        return array();
        M_:
        foreach (array_filter($_POST["\147\x72\141\x76\x69\x74\x79\x5f\146\x6f\x72\x6d"]["\146\157\162\x6d"]) as $O5 => $Xd) {
            $p8 = GFAPI::get_form($Xd);
            $a4 = $_POST["\147\162\141\166\x69\164\x79\137\x66\x6f\x72\155"]["\145\155\141\151\x6c\x6b\x65\171"][$O5];
            $nT = $_POST["\147\162\141\x76\x69\x74\171\137\x66\157\x72\155"]["\160\x68\157\x6e\145\x6b\x65\x79"][$O5];
            $rf[$Xd] = array("\x65\x6d\141\x69\154\x6b\x65\x79" => $xK($p8["\146\x69\x65\x6c\x64\x73"], $a4, "\107\x46\x5f\106\151\x65\x6c\x64\x5f\105\x6d\x61\x69\154"), "\160\x68\x6f\156\x65\x6b\145\171" => $xK($p8["\x66\151\145\x6c\144\163"], $nT, "\107\x46\137\106\x69\x65\x6c\x64\137\x50\150\x6f\x6e\145"), "\x76\x65\162\151\146\x79\113\x65\171" => $_POST["\147\162\141\x76\x69\x74\x79\137\x66\x6f\x72\x6d"]["\x76\145\x72\x69\x66\171\x4b\x65\171"][$O5], "\x70\150\157\156\145\x5f\163\150\x6f\x77" => $_POST["\147\162\x61\166\151\x74\x79\137\x66\x6f\x72\x6d"]["\x70\150\x6f\156\145\x6b\x65\171"][$O5], "\145\155\141\x69\154\x5f\163\x68\x6f\x77" => $_POST["\147\162\x61\166\x69\164\171\137\146\x6f\x72\x6d"]["\x65\x6d\x61\x69\x6c\153\145\x79"][$O5], "\x76\x65\x72\x69\x66\171\137\x73\x68\157\167" => $_POST["\147\162\141\x76\151\x74\x79\x5f\x66\x6f\162\155"]["\x76\145\x72\x69\146\171\x4b\x65\171"][$O5]);
            bE:
        }
        F8:
        return $rf;
    }
    private function isEmailOrPhoneField($DH, $jQ)
    {
        return $this->_otpType === $this->_typePhoneTag && $DH->id === $jQ["\160\150\157\156\x65\x6b\x65\x79"] || $this->_otpType === $this->_typeEmailTag && $DH->id === $jQ["\145\155\141\x69\x6c\x6b\145\x79"];
    }
}
