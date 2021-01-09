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
class FormMaker extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::FORM_MAKER;
        $this->_typePhoneTag = "\155\x6f\137\146\x6f\162\x6d\x5f\x6d\141\x6b\145\x72\137\x70\150\x6f\x6e\x65\137\145\156\141\x62\x6c\x65";
        $this->_typeEmailTag = "\155\x6f\137\x66\157\x72\155\137\x6d\x61\x6b\x65\162\x5f\x65\x6d\x61\x69\x6c\137\x65\x6e\x61\x62\154\x65";
        $this->_formName = mo_("\106\157\162\x6d\40\x4d\x61\153\145\162\40\106\x6f\x72\x6d");
        $this->_formKey = "\x46\x4f\122\x4d\x5f\x4d\101\x4b\x45\x52";
        $this->_isFormEnabled = get_mo_option("\x66\157\162\x6d\155\141\x6b\x65\162\x5f\145\156\141\x62\154\145");
        $this->_otpType = get_mo_option("\x66\157\162\x6d\x6d\141\x6b\x65\162\x5f\145\x6e\x61\142\154\x65\x5f\x74\171\x70\145");
        $this->_formDetails = maybe_unserialize(get_mo_option("\x66\x6f\x72\x6d\x6d\141\153\x65\x72\137\x6f\x74\x70\137\145\x6e\141\x62\x6c\x65\144"));
        $this->_buttonText = get_mo_option("\x66\x6f\162\x6d\x6d\141\153\145\162\x5f\142\x75\164\164\157\156\137\x74\145\x78\x74");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\x43\x6c\151\x63\x6b\40\x48\x65\x72\145\40\164\x6f\40\163\x65\156\144\x20\117\124\120");
        $this->_formDocuments = MoOTPDocs::FORMMAKER;
        parent::__construct();
        if (!$this->_isFormEnabled) {
            goto GI;
        }
        add_action("\x77\x70\x5f\145\x6e\x71\x75\x65\165\145\x5f\163\143\162\151\160\164\x73", array($this, "\x72\145\147\x69\x73\164\x65\162\x5f\x66\155\137\142\x75\164\x74\x6f\x6e\x5f\x73\x63\x72\x69\160\164"));
        GI:
    }
    function handleForm()
    {
        $this->routeData();
    }
    function routeData()
    {
        if (array_key_exists("\157\160\164\x69\157\x6e", $_GET)) {
            goto rS;
        }
        return;
        rS:
        switch (trim($_GET["\x6f\160\x74\151\157\156"])) {
            case "\x6d\151\156\151\x6f\162\x61\156\147\x65\x2d\x66\155\x2d\x61\152\141\170\x2d\166\x65\x72\151\x66\171":
                $this->_send_otp_fm_ajax_verify($_POST);
                goto Dp;
            case "\155\151\x6e\151\x6f\162\141\x6e\x67\x65\55\x66\x6d\x2d\166\145\x72\151\146\x79\x2d\143\x6f\144\x65":
                $this->_validate_otp($_POST);
                goto Dp;
        }
        GE:
        Dp:
    }
    private function _validate_otp($post)
    {
        $this->validateChallenge($this->getVerificationType(), NULL, $post["\157\x74\x70\x5f\164\157\x6b\x65\x6e"]);
    }
    function _send_otp_fm_ajax_verify($tT)
    {
        if ($this->_otpType == $this->_typePhoneTag) {
            goto q1;
        }
        $this->_send_fm_ajax_otp_to_email($tT);
        goto ec;
        q1:
        $this->_send_fm_ajax_otp_to_phone($tT);
        ec:
    }
    function _send_fm_ajax_otp_to_phone($tT)
    {
        if (!MoUtility::sanitizeCheck("\165\163\145\162\137\x70\x68\x6f\156\x65", $tT)) {
            goto P_;
        }
        $this->sendOTP(trim($tT["\x75\x73\145\x72\x5f\x70\150\x6f\156\x65"]), NULL, trim($tT["\165\x73\145\162\137\160\x68\x6f\156\145"]), VerificationType::PHONE);
        goto uo;
        P_:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        uo:
    }
    function _send_fm_ajax_otp_to_email($tT)
    {
        if (!MoUtility::sanitizeCheck("\165\163\145\162\137\x65\x6d\x61\151\x6c", $tT)) {
            goto Qi;
        }
        $this->sendOTP($tT["\165\x73\145\162\137\145\155\x61\151\154"], $tT["\x75\163\x65\162\x5f\x65\155\141\151\x6c"], NULL, VerificationType::EMAIL);
        goto Yd;
        Qi:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        Yd:
    }
    private function checkPhoneOrEmailIntegrity($dF)
    {
        if ($this->getVerificationType() === VerificationType::PHONE) {
            goto eA;
        }
        return SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $dF);
        goto bC;
        eA:
        return SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $dF);
        bC:
    }
    private function sendOTP($Jx, $W8, $ZI, $au)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if ($au === VerificationType::PHONE) {
            goto oh;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $Jx);
        goto SO;
        oh:
        SessionUtils::addPhoneVerified($this->_formSessionVar, $Jx);
        SO:
        $this->sendChallenge('', $W8, NULL, $ZI, $au);
    }
    function handle_failed_verification($wE, $MQ, $TB, $au)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto gc;
        }
        return;
        gc:
        wp_send_json(MoUtility::createJson(MoUtility::_get_invalid_otp_method(), MoConstants::ERROR_JSON_TYPE));
    }
    function handle_post_verification($WE, $wE, $MQ, $eW, $TB, $HL, $au)
    {
        if ($this->checkPhoneOrEmailIntegrity($_POST["\x73\x75\x62\137\x66\x69\145\x6c\x64"])) {
            goto d6;
        }
        if ($this->_otpType == $this->_typePhoneTag) {
            goto EM;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::EMAIL_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        goto NH;
        EM:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        NH:
        goto rz;
        d6:
        $this->unsetOTPSessionVariables();
        wp_send_json(MoUtility::createJson(self::VALIDATED, MoConstants::SUCCESS_JSON_TYPE));
        rz:
    }
    function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($sq)
    {
        if (!($this->isFormEnabled() && $this->getVerificationType() === VerificationType::PHONE)) {
            goto B7;
        }
        array_push($sq, $this->_phoneFormId);
        B7:
        return $sq;
    }
    function register_fm_button_script()
    {
        wp_register_script("\146\155\157\x74\x70\142\165\x74\x74\x6f\156\x73\x63\162\x69\x70\164", MOV_URL . "\151\x6e\143\x6c\165\x64\x65\163\x2f\x6a\x73\x2f\x66\x6f\x72\x6d\x6d\141\153\145\162\x2e\x6d\x69\156\56\152\163", array("\x6a\161\165\145\x72\x79"));
        wp_localize_script("\x66\155\x6f\x74\160\142\165\x74\164\157\156\x73\x63\x72\151\160\164", "\x6d\157\146\x6d\x76\x61\162", array("\x73\x69\x74\145\125\122\x4c" => site_url(), "\157\x74\160\x54\171\160\145" => $this->_otpType, "\x66\x6f\162\x6d\104\145\164\x61\x69\x6c\163" => $this->_formDetails, "\142\165\x74\164\x6f\156\164\x65\170\164" => mo_($this->_buttonText), "\x69\x6d\147\x55\122\x4c" => MOV_URL . "\151\x6e\x63\154\165\144\145\x73\x2f\x69\155\x61\x67\x65\x73\57\x6c\x6f\141\x64\145\x72\56\147\x69\146"));
        wp_enqueue_script("\x66\x6d\157\164\160\142\x75\164\164\157\x6e\163\x63\162\151\160\x74");
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto Bl;
        }
        return;
        Bl:
        $form = $this->parseFormDetails();
        $this->_formDetails = !empty($form) ? $form : '';
        $this->_otpType = $this->sanitizeFormPOST("\x66\155\x5f\145\156\141\142\x6c\x65\137\x74\171\160\145");
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x66\155\137\145\x6e\141\142\154\145");
        $this->_buttonText = $this->sanitizeFormPOST("\x66\x6d\137\x62\165\164\164\157\x6e\137\164\x65\x78\x74");
        if (!$this->basicValidationCheck(BaseMessages::FORMMAKER_CHOOSE)) {
            goto Bq;
        }
        update_mo_option("\x66\157\162\155\x6d\x61\153\x65\x72\137\145\156\x61\142\x6c\145", $this->_isFormEnabled);
        update_mo_option("\x66\x6f\162\x6d\x6d\141\153\x65\x72\137\x65\156\x61\x62\154\x65\137\x74\171\160\x65", $this->_otpType);
        update_mo_option("\x66\157\x72\155\155\141\153\x65\162\x5f\157\x74\x70\x5f\145\x6e\141\x62\x6c\145\144", maybe_serialize($this->_formDetails));
        update_mo_option("\x66\157\x72\155\155\141\x6b\145\162\x5f\142\x75\x74\x74\x6f\156\137\x74\x65\x78\x74", $this->_buttonText);
        Bq:
    }
    private function parseFormDetails()
    {
        $form = array();
        if (array_key_exists("\146\157\x72\x6d\x6d\141\x6b\x65\x72\x5f\x66\x6f\x72\155", $_POST)) {
            goto WK;
        }
        return array();
        WK:
        foreach (array_filter($_POST["\146\x6f\162\155\155\x61\x6b\145\x72\x5f\x66\x6f\162\x6d"]["\146\x6f\162\x6d"]) as $O5 => $Xd) {
            $form[$Xd] = array("\x65\155\x61\151\x6c\x6b\145\171" => $this->_get_efield_id($_POST["\x66\157\162\x6d\x6d\141\153\x65\162\137\x66\x6f\162\x6d"]["\145\155\141\x69\154\x6b\145\x79"][$O5], $Xd), "\160\150\157\x6e\145\x6b\x65\x79" => $this->_get_efield_id($_POST["\x66\x6f\162\x6d\155\x61\x6b\145\x72\x5f\x66\157\x72\x6d"]["\x70\150\157\156\145\x6b\145\171"][$O5], $Xd), "\x76\x65\162\x69\146\171\113\145\171" => $this->_get_efield_id($_POST["\x66\157\162\155\x6d\x61\153\x65\162\137\146\x6f\x72\x6d"]["\x76\x65\x72\x69\x66\x79\113\145\171"][$O5], $Xd), "\160\x68\x6f\156\145\x5f\163\150\157\167" => $_POST["\x66\157\162\x6d\x6d\x61\x6b\x65\162\137\x66\157\162\155"]["\160\150\x6f\156\x65\153\145\171"][$O5], "\x65\155\141\x69\154\x5f\163\150\157\167" => $_POST["\x66\157\162\155\155\x61\153\x65\x72\137\x66\157\162\155"]["\x65\155\x61\x69\154\x6b\145\171"][$O5], "\166\145\162\151\x66\171\137\163\x68\x6f\167" => $_POST["\146\x6f\x72\x6d\155\x61\153\145\x72\x5f\146\x6f\x72\155"]["\166\x65\x72\151\146\x79\x4b\145\x79"][$O5]);
            rZ:
        }
        j2:
        return $form;
    }
    private function _get_efield_id($RJ, $form)
    {
        global $wpdb;
        $eU = $wpdb->get_row("\x53\x45\114\x45\x43\124\40\x2a\x20\106\x52\x4f\115\x20{$wpdb->prefix}\146\x6f\162\155\155\x61\153\145\162\x20\x77\x68\145\x72\x65\40\x60\x69\x64\140\40\75" . $form);
        if (!MoUtility::isBlank($eU)) {
            goto Re;
        }
        return '';
        Re:
        $K_ = explode("\52\72\52\156\145\167\137\146\x69\145\x6c\x64\x2a\72\x2a", $eU->form_fields);
        $KV = $qa = $MA = array();
        foreach ($K_ as $DH) {
            $xw = explode("\x2a\x3a\52\x69\x64\52\72\x2a", $DH);
            if (MoUtility::isBlank($xw)) {
                goto Av;
            }
            array_push($KV, $xw[0]);
            if (!array_key_exists(1, $xw)) {
                goto wa;
            }
            $xw = explode("\x2a\x3a\x2a\x74\171\x70\x65\52\x3a\52", $xw[1]);
            array_push($qa, $xw[0]);
            $xw = explode("\x2a\72\52\x77\x5f\146\151\x65\154\144\x5f\154\141\x62\145\154\52\72\x2a", $xw[1]);
            wa:
            array_push($MA, $xw[0]);
            Av:
            XA:
        }
        yS:
        $O5 = array_search($RJ, $MA);
        return "\x23\x77\x64\x66\157\162\155\x5f" . $KV[$O5] . "\x5f\145\154\x65\x6d\x65\x6e\x74" . $form;
    }
}
