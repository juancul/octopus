<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoPHPSessions;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
class NinjaFormAjaxForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::NINJA_FORM_AJAX;
        $this->_typePhoneTag = "\x6d\157\x5f\156\151\156\152\141\137\146\x6f\162\155\x5f\160\150\x6f\x6e\145\x5f\145\x6e\141\142\x6c\x65";
        $this->_typeEmailTag = "\155\157\x5f\156\151\156\152\141\x5f\146\157\162\155\x5f\145\x6d\x61\151\x6c\137\145\156\141\142\x6c\x65";
        $this->_typeBothTag = "\x6d\157\137\156\151\156\x6a\141\x5f\x66\157\162\155\x5f\142\157\x74\150\x5f\145\156\x61\x62\x6c\x65";
        $this->_formKey = "\116\111\116\112\101\137\x46\117\x52\115\137\x41\x4a\x41\x58";
        $this->_formName = mo_("\x4e\x69\156\x6a\141\40\x46\157\x72\x6d\x73\x20\x28\40\x41\x62\x6f\x76\145\40\x76\x65\x72\x73\151\157\x6e\x20\63\56\x30\x20\x29");
        $this->_isFormEnabled = get_mo_option("\x6e\x6a\x61\x5f\x65\156\141\x62\154\x65");
        $this->_buttonText = get_mo_option("\156\152\x61\137\142\x75\x74\x74\x6f\156\137\164\145\170\x74");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\103\154\151\x63\x6b\x20\x48\x65\162\x65\40\164\x6f\40\163\x65\x6e\x64\40\x4f\124\120");
        $this->_phoneFormId = array();
        $this->_formDocuments = MoOTPDocs::NINJA_FORMS_AJAX_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\156\x69\156\x6a\141\137\146\x6f\x72\x6d\x5f\145\156\x61\142\x6c\145\137\164\x79\160\145");
        $this->_formDetails = maybe_unserialize(get_mo_option("\156\151\x6e\152\x61\x5f\x66\157\162\155\x5f\157\x74\x70\x5f\x65\156\x61\142\x6c\145\x64"));
        if (!empty($this->_formDetails)) {
            goto ab;
        }
        return;
        ab:
        foreach ($this->_formDetails as $O5 => $Xd) {
            array_push($this->_phoneFormId, "\151\156\x70\x75\164\x5b\x69\x64\75\156\146\x2d\146\151\145\x6c\x64\x2d" . $Xd["\x70\150\x6f\x6e\x65\153\145\171"] . "\135");
            lP:
        }
        oA:
        add_action("\x6e\x69\156\152\141\137\146\157\162\x6d\163\x5f\x61\x66\164\x65\162\137\x66\x6f\162\155\x5f\x64\151\x73\x70\154\141\x79", array($this, "\x65\x6e\x71\165\145\x75\145\x5f\x6e\x6a\x5f\146\x6f\162\155\x5f\x73\143\x72\151\x70\x74"), 99, 1);
        add_filter("\156\x69\x6e\152\141\137\x66\x6f\162\x6d\163\x5f\163\x75\x62\x6d\151\x74\137\144\x61\x74\141", array($this, "\137\150\x61\156\144\154\x65\x5f\156\152\x5f\141\152\141\170\137\x66\x6f\x72\155\137\163\x75\142\x6d\151\x74"), 99, 1);
        $au = $this->getVerificationType();
        if (!$au) {
            goto dx;
        }
        add_filter("\x6e\x69\x6e\x6a\141\137\146\157\162\155\x73\137\154\x6f\143\141\x6c\151\172\x65\137\x66\x69\145\x6c\144\x5f\163\x65\x74\x74\x69\x6e\147\163\137" . $au, array($this, "\137\x61\x64\x64\137\142\x75\164\x74\157\x6e"), 99, 2);
        dx:
        $this->routeData();
    }
    function routeData()
    {
        if (array_key_exists("\157\160\x74\151\x6f\x6e", $_GET)) {
            goto Qz;
        }
        return;
        Qz:
        switch (trim($_GET["\157\160\x74\151\157\x6e"])) {
            case "\155\x69\156\x69\x6f\162\141\x6e\147\x65\55\x6e\152\55\141\152\x61\170\x2d\166\145\x72\151\x66\171":
                $this->_send_otp_nj_ajax_verify($_POST);
                goto vY;
        }
        qq:
        vY:
    }
    function enqueue_nj_form_script($K5)
    {
        if (!array_key_exists($K5, $this->_formDetails)) {
            goto Tq;
        }
        $p8 = $this->_formDetails[$K5];
        $VX = array_keys($this->_formDetails);
        wp_register_script("\156\x6a\163\x63\x72\x69\x70\164", MOV_URL . "\151\156\x63\154\x75\x64\x65\x73\57\x6a\x73\57\x6e\x69\x6e\152\141\x66\x6f\x72\x6d\x61\x6a\x61\170\56\155\151\x6e\x2e\x6a\x73", array("\x6a\161\165\x65\x72\171"), MOV_VERSION, true);
        wp_localize_script("\156\x6a\163\143\162\x69\160\x74", "\x6d\x6f\x6e\151\156\x6a\x61\166\x61\162\x73", array("\x69\x6d\147\x55\122\114" => MOV_URL . "\151\156\143\154\165\144\145\x73\x2f\151\155\x61\x67\x65\x73\x2f\x6c\x6f\x61\x64\145\x72\x2e\147\x69\146", "\x73\x69\x74\x65\125\x52\114" => site_url(), "\157\x74\x70\x54\x79\160\x65" => $this->_otpType == $this->_typePhoneTag ? VerificationType::PHONE : VerificationType::EMAIL, "\x66\157\x72\x6d\x73" => $this->_formDetails, "\146\157\162\155\x4b\x65\x79\126\x61\154\163" => $VX));
        wp_enqueue_script("\x6e\x6a\x73\143\162\x69\x70\164");
        Tq:
        return $K5;
    }
    function _add_button($Sc, $form)
    {
        $mA = $form->get_id();
        if (array_key_exists($mA, $this->_formDetails)) {
            goto fa;
        }
        return $Sc;
        fa:
        $p8 = $this->_formDetails[$mA];
        $Fn = $this->_otpType == $this->_typePhoneTag ? "\160\150\x6f\x6e\145\153\x65\171" : "\x65\155\x61\151\x6c\x6b\145\x79";
        if (!($Sc["\x69\x64"] == $p8[$Fn])) {
            goto Pk;
        }
        $Sc["\141\146\164\x65\x72\x46\x69\145\x6c\144"] = "\12\x20\x20\x20\x20\x20\x20\x20\40\x20\x20\x20\x20\40\x20\40\x20\x3c\144\151\x76\40\151\x64\75\42\x6e\146\x2d\146\151\x65\154\144\x2d\64\55\143\x6f\x6e\164\141\x69\x6e\x65\x72\42\40\x63\x6c\x61\x73\x73\x3d\42\x6e\146\55\146\x69\x65\154\144\55\143\x6f\156\164\x61\151\156\145\162\40\x73\165\x62\x6d\151\x74\x2d\x63\x6f\156\x74\x61\x69\156\x65\x72\x20\40\154\x61\x62\145\154\55\141\142\157\x76\x65\40\42\x3e\xa\x20\x20\x20\x20\x20\40\40\x20\x20\40\x20\40\40\40\x20\x20\40\40\40\40\74\x64\x69\166\x20\143\154\x61\x73\163\x3d\x22\x6e\146\55\142\145\x66\x6f\x72\145\55\146\x69\145\x6c\144\42\x3e\12\x20\40\x20\x20\x20\40\x20\x20\x20\40\x20\x20\x20\x20\x20\x20\40\x20\40\x20\x20\x20\40\40\x3c\156\146\x2d\163\x65\143\164\x69\157\x6e\76\74\x2f\x6e\146\55\163\x65\x63\164\x69\157\x6e\x3e\xa\x20\x20\x20\40\x20\x20\x20\40\40\40\x20\x20\40\40\x20\40\x20\40\x20\x20\x3c\x2f\144\x69\166\76\12\40\x20\40\x20\40\40\x20\x20\40\40\40\x20\40\x20\40\x20\40\40\40\40\x3c\x64\151\166\x20\x63\x6c\141\x73\163\x3d\42\x6e\x66\55\146\151\x65\x6c\144\42\76\12\40\40\40\40\x20\40\x20\x20\40\x20\x20\x20\40\x20\x20\x20\x20\x20\x20\x20\x20\x20\40\x20\74\144\x69\166\x20\143\x6c\x61\x73\163\x3d\42\x66\x69\145\x6c\144\x2d\x77\x72\x61\x70\40\x73\x75\142\155\x69\164\x2d\x77\x72\141\160\x22\x3e\xa\40\x20\x20\40\x20\40\40\x20\x20\x20\40\x20\x20\x20\x20\40\x20\x20\40\x20\x20\x20\x20\40\40\40\x20\x20\x3c\x64\151\166\x20\x63\154\x61\x73\163\75\x22\x6e\146\x2d\x66\x69\x65\x6c\x64\x2d\154\x61\142\145\x6c\x22\76\x3c\57\x64\151\166\x3e\xa\40\x20\x20\40\x20\x20\x20\x20\40\40\x20\40\x20\x20\x20\x20\x20\40\40\40\40\40\x20\40\x20\x20\x20\40\x3c\144\151\166\x20\x63\154\141\x73\163\75\x22\x6e\146\55\x66\x69\x65\x6c\x64\x2d\145\154\x65\155\x65\156\x74\x22\76\xa\40\40\x20\40\40\x20\x20\x20\x20\x20\40\x20\40\40\x20\x20\x20\x20\x20\40\40\40\x20\x20\40\x20\40\40\x20\x20\40\40\74\x69\156\160\x75\164\40\40\x69\144\x3d\42\155\151\156\x69\157\162\141\x6e\x67\x65\x5f\157\164\x70\x5f\164\157\153\x65\x6e\137\x73\x75\x62\x6d\x69\164\x5f" . $mA . "\x22\40\143\154\x61\163\163\x3d\42\x6e\151\156\x6a\141\x2d\x66\x6f\x72\155\x73\55\x66\x69\145\x6c\x64\x20\x6e\x66\x2d\x65\154\145\155\145\x6e\164\x22\12\40\x20\40\x20\40\x20\40\x20\x20\40\40\40\x20\x20\40\x20\x20\40\x20\x20\40\x20\40\x20\40\40\40\x20\40\x20\40\40\40\40\x20\40\x20\x20\x20\x20\166\141\x6c\165\x65\75\x22" . mo_($this->_buttonText) . "\x22\40\x74\x79\x70\145\75\42\x62\165\x74\164\157\156\x22\x3e\12\40\x20\40\x20\40\40\x20\x20\x20\40\40\x20\40\40\x20\x20\40\40\40\x20\x20\40\40\x20\40\x20\40\40\x3c\57\144\151\166\76\xa\40\x20\x20\40\x20\40\40\x20\x20\x20\x20\x20\40\x20\40\x20\40\x20\x20\40\40\40\x20\x20\74\57\x64\x69\166\x3e\xa\x20\40\40\x20\x20\40\40\x20\40\x20\40\40\40\x20\40\40\40\40\40\40\74\57\x64\151\166\x3e\xa\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\40\40\x20\40\40\x20\40\40\x20\x3c\144\x69\166\x20\143\154\x61\163\163\x3d\x22\156\146\x2d\141\x66\x74\x65\162\55\146\x69\x65\154\x64\x22\76\xa\x20\x20\40\40\40\40\x20\40\x20\40\x20\40\x20\40\x20\x20\40\x20\x20\x20\40\x20\40\x20\74\x6e\146\x2d\163\145\x63\164\151\x6f\x6e\x3e\xa\40\x20\40\40\40\x20\40\x20\40\x20\x20\40\40\x20\x20\40\x20\40\40\40\40\40\40\x20\x20\x20\40\x20\74\144\x69\x76\x20\x63\154\x61\163\x73\x3d\x22\x6e\146\55\151\x6e\160\x75\x74\55\154\x69\155\x69\164\x22\76\74\x2f\144\x69\166\76\12\x20\40\40\x20\x20\40\x20\x20\x20\x20\x20\x20\40\40\40\x20\x20\x20\40\x20\40\40\40\x20\40\x20\x20\x20\x3c\x64\x69\x76\40\143\154\x61\163\x73\75\x22\156\146\x2d\145\162\162\157\x72\x2d\167\162\x61\160\40\156\146\x2d\145\x72\x72\157\162\x22\x3e\74\57\144\151\166\x3e\xa\x20\40\x20\40\40\x20\40\40\x20\40\40\x20\40\40\40\x20\x20\40\40\40\x20\40\x20\x20\x3c\x2f\x6e\146\x2d\163\x65\143\x74\151\157\156\76\12\40\x20\40\40\x20\40\40\40\40\40\x20\x20\x20\40\x20\x20\x20\40\40\40\74\x2f\144\x69\166\76\xa\x20\40\x20\x20\40\40\x20\x20\40\x20\x20\40\40\40\x20\x20\x3c\57\x64\x69\166\76\12\40\x20\40\40\x20\x20\x20\x20\x20\x20\40\x20\40\x20\40\x20\74\144\x69\166\40\151\x64\75\x22\155\157\137\x6d\x65\x73\x73\x61\147\x65\x5f" . $mA . "\42\x20\150\x69\x64\144\x65\156\x3d\x22\42\40\x73\x74\x79\154\145\x3d\x22\x62\x61\x63\x6b\147\162\x6f\165\156\144\x2d\x63\x6f\x6c\x6f\x72\x3a\x20\x23\x66\67\x66\x36\x66\67\x3b\160\141\144\144\x69\156\x67\x3a\x20\61\145\155\40\x32\x65\155\40\x31\x65\155\40\63\x2e\65\x65\155\x3b\42\76\x3c\x2f\144\151\x76\76";
        Pk:
        return $Sc;
    }
    function _handle_nj_ajax_form_submit($tT)
    {
        if (array_key_exists($tT["\x69\x64"], $this->_formDetails)) {
            goto TL;
        }
        return $tT;
        TL:
        $p8 = $this->_formDetails[$tT["\151\x64"]];
        $tT = $this->checkIfOtpVerificationStarted($p8, $tT);
        if (!isset($tT["\x65\162\162\157\x72\x73"]["\x66\x69\145\x6c\x64\163"])) {
            goto CD;
        }
        return $tT;
        CD:
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) == 0)) {
            goto K8;
        }
        $tT = $this->processEmail($p8, $tT);
        K8:
        if (!(strcasecmp($this->_otpType, $this->_typePhoneTag) == 0)) {
            goto ax;
        }
        $tT = $this->processPhone($p8, $tT);
        ax:
        if (isset($tT["\145\162\162\x6f\x72\163"]["\x66\x69\145\154\144\163"])) {
            goto dt;
        }
        $tT = $this->processOTPEntered($tT, $p8);
        dt:
        return $tT;
    }
    function processOTPEntered($tT, $p8)
    {
        $Bk = $p8["\x76\145\162\151\146\171\x4b\x65\x79"];
        $au = $this->getVerificationType();
        $this->validateChallenge($au, NULL, $tT["\146\151\x65\154\x64\x73"][$Bk]["\x76\x61\154\x75\x65"]);
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $au)) {
            goto f2;
        }
        $this->unsetOTPSessionVariables();
        goto bu;
        f2:
        $tT["\145\162\162\x6f\162\x73"]["\146\x69\145\154\144\x73"][$Bk] = MoUtility::_get_invalid_otp_method();
        bu:
        return $tT;
    }
    function checkIfOtpVerificationStarted($p8, $tT)
    {
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto a1;
        }
        return $tT;
        a1:
        if (strcasecmp($this->_otpType, $this->_typeEmailTag) == 0) {
            goto JY;
        }
        $tT["\145\162\162\x6f\162\x73"]["\146\x69\x65\x6c\144\x73"][$p8["\160\150\157\156\x65\153\x65\x79"]] = MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE);
        goto Zy;
        JY:
        $tT["\x65\x72\x72\x6f\x72\163"]["\x66\x69\x65\x6c\144\163"][$p8["\x65\x6d\141\151\154\153\x65\171"]] = MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE);
        Zy:
        return $tT;
    }
    function processEmail($p8, $tT)
    {
        $B1 = $p8["\145\x6d\x61\151\x6c\153\x65\171"];
        if (!SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $tT["\146\151\145\154\x64\x73"][$B1]["\166\x61\x6c\165\x65"])) {
            goto gi;
        }
        $tT["\x65\x72\162\157\162\163"]["\x66\151\145\x6c\144\x73"][$B1] = MoMessages::showMessage(MoMessages::EMAIL_MISMATCH);
        gi:
        return $tT;
    }
    function processPhone($p8, $tT)
    {
        $B1 = $p8["\x70\150\x6f\156\145\x6b\145\x79"];
        if (!SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $tT["\x66\x69\x65\x6c\x64\163"][$B1]["\166\141\x6c\165\145"])) {
            goto z7;
        }
        $tT["\x65\x72\x72\x6f\162\x73"]["\146\151\145\154\144\163"][$B1] = MoMessages::showMessage(MoMessages::PHONE_MISMATCH);
        z7:
        return $tT;
    }
    function _send_otp_nj_ajax_verify($tT)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if ($this->_otpType == $this->_typePhoneTag) {
            goto PR;
        }
        $this->_send_nj_ajax_otp_to_email($tT);
        goto RL;
        PR:
        $this->_send_nj_ajax_otp_to_phone($tT);
        RL:
    }
    function _send_nj_ajax_otp_to_phone($tT)
    {
        if (!array_key_exists("\165\163\145\162\x5f\x70\x68\x6f\x6e\x65", $tT) || !isset($tT["\165\x73\x65\x72\x5f\x70\x68\x6f\156\x65"])) {
            goto NO;
        }
        $this->setSessionAndStartOTPVerification(trim($tT["\x75\163\145\162\137\160\150\x6f\156\145"]), NULL, trim($tT["\x75\x73\145\162\x5f\x70\x68\157\156\x65"]), VerificationType::PHONE);
        goto NK;
        NO:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        NK:
    }
    function _send_nj_ajax_otp_to_email($tT)
    {
        if (!array_key_exists("\165\163\145\x72\137\145\155\141\151\154", $tT) || !isset($tT["\x75\163\x65\x72\137\x65\x6d\141\x69\x6c"])) {
            goto i1;
        }
        $this->setSessionAndStartOTPVerification($tT["\165\163\145\162\137\x65\155\x61\151\x6c"], $tT["\165\x73\x65\162\x5f\145\155\141\x69\x6c"], NULL, VerificationType::EMAIL);
        goto s1;
        i1:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        s1:
    }
    function setSessionAndStartOTPVerification($Jx, $W8, $ZI, $au)
    {
        SessionUtils::setFormOrFieldId($this->_formSessionVar, $Jx);
        $this->sendChallenge('', $W8, NULL, $ZI, $au);
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
        if (!($this->isFormEnabled() && $this->_otpType == $this->_typePhoneTag)) {
            goto PP;
        }
        $sq = array_merge($sq, $this->_phoneFormId);
        PP:
        return $sq;
    }
    function getFieldId($tT)
    {
        global $wpdb;
        return $wpdb->get_var("\123\105\114\x45\103\x54\x20\151\144\x20\106\122\x4f\115\40{$wpdb->prefix}\x6e\146\x33\x5f\146\x69\x65\x6c\x64\163\40\x77\x68\x65\162\145\x20\140\153\x65\171\140\x20\75\47" . $tT . "\x27");
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto QV;
        }
        return;
        QV:
        if (!isset($_POST["\155\157\x5f\143\165\163\x74\x6f\x6d\x65\162\x5f\x76\x61\154\151\x64\141\164\151\157\x6e\x5f\156\151\x6e\x6a\141\x5f\x66\x6f\162\155\x5f\x65\156\141\x62\x6c\145"])) {
            goto qS;
        }
        return;
        qS:
        $form = $this->parseFormDetails();
        $this->_formDetails = !empty($form) ? $form : '';
        $this->_otpType = $this->sanitizeFormPOST("\x6e\152\x61\x5f\145\x6e\x61\x62\154\145\137\164\x79\160\145");
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x6e\x6a\141\137\x65\156\x61\x62\x6c\x65");
        $this->_buttonText = $this->sanitizeFormPOST("\156\x6a\x61\x5f\142\x75\164\164\157\156\137\x74\x65\x78\x74");
        update_mo_option("\156\151\156\x6a\141\x5f\x66\157\x72\x6d\137\x65\156\x61\x62\x6c\145", 0);
        update_mo_option("\x6e\152\141\137\145\156\141\x62\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\x6e\151\x6e\x6a\x61\137\x66\x6f\162\x6d\137\x65\x6e\x61\142\x6c\x65\137\164\x79\x70\145", $this->_otpType);
        update_mo_option("\x6e\151\156\x6a\141\x5f\146\x6f\162\x6d\x5f\x6f\164\x70\137\145\156\141\x62\154\x65\144", maybe_serialize($this->_formDetails));
        update_mo_option("\x6e\x6a\x61\137\x62\x75\x74\164\x6f\156\137\164\145\x78\164", $this->_buttonText);
    }
    function parseFormDetails()
    {
        $form = array();
        if (array_key_exists("\156\151\x6e\152\x61\137\141\152\141\170\137\146\157\162\155", $_POST)) {
            goto au;
        }
        return array();
        au:
        foreach (array_filter($_POST["\156\151\x6e\152\x61\137\141\152\x61\x78\137\x66\157\x72\155"]["\x66\157\162\155"]) as $O5 => $Xd) {
            $form[$Xd] = array("\x65\155\x61\151\154\x6b\145\x79" => $this->getFieldId($_POST["\156\151\156\152\141\x5f\141\152\x61\x78\x5f\146\x6f\162\155"]["\145\x6d\x61\151\x6c\153\x65\x79"][$O5]), "\x70\150\157\x6e\145\x6b\145\171" => $this->getFieldId($_POST["\x6e\151\x6e\152\141\x5f\x61\152\141\x78\137\x66\x6f\162\x6d"]["\x70\x68\157\156\145\153\x65\x79"][$O5]), "\166\x65\162\x69\146\171\113\145\x79" => $this->getFieldId($_POST["\156\151\x6e\152\x61\137\141\152\141\x78\137\x66\x6f\x72\x6d"]["\166\145\x72\x69\146\x79\113\x65\171"][$O5]), "\160\x68\x6f\x6e\x65\137\163\150\x6f\x77" => $_POST["\x6e\151\x6e\152\141\x5f\x61\152\141\x78\137\x66\x6f\x72\x6d"]["\160\150\157\x6e\145\x6b\145\x79"][$O5], "\x65\155\x61\x69\x6c\137\163\x68\157\167" => $_POST["\156\151\x6e\152\141\137\141\x6a\x61\x78\137\146\x6f\x72\x6d"]["\x65\x6d\141\x69\154\x6b\145\171"][$O5], "\x76\145\x72\151\x66\171\x5f\163\x68\x6f\x77" => $_POST["\156\x69\156\152\141\x5f\x61\152\141\x78\137\x66\x6f\x72\155"]["\x76\145\x72\x69\146\171\x4b\145\171"][$O5]);
            nt:
        }
        ac:
        return $form;
    }
}
