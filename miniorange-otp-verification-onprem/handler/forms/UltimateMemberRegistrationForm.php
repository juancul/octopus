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
use OTP\Objects\VerificationLogic;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
use um\core\Form;
use WP_Error;
class UltimateMemberRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = get_mo_option("\165\155\137\151\x73\137\141\x6a\x61\170\x5f\x66\157\x72\155");
        $this->_formSessionVar = FormSessionVars::UM_DEFAULT_REG;
        $this->_typePhoneTag = "\x6d\x6f\137\x75\x6d\137\x70\150\x6f\x6e\x65\x5f\x65\156\x61\x62\x6c\145";
        $this->_typeEmailTag = "\155\x6f\137\165\155\137\x65\x6d\x61\151\x6c\137\x65\156\x61\142\x6c\145";
        $this->_typeBothTag = "\x6d\x6f\137\x75\155\137\x62\157\x74\150\137\x65\x6e\x61\142\154\145";
        $this->_phoneKey = get_mo_option("\165\155\137\160\150\x6f\156\145\x5f\x6b\x65\171");
        $this->_phoneKey = $this->_phoneKey ? $this->_phoneKey : "\155\157\142\x69\x6c\x65\x5f\156\165\155\x62\145\x72";
        $this->_phoneFormId = "\151\x6e\160\x75\x74\x5b\x6e\141\x6d\145\136\x3d\47" . $this->_phoneKey . "\47\x5d";
        $this->_formKey = "\125\114\124\111\x4d\x41\124\105\x5f\x46\117\x52\x4d";
        $this->_formName = mo_("\125\154\x74\151\x6d\141\x74\x65\x20\x4d\145\155\x62\x65\x72\40\x52\x65\147\151\x73\x74\162\x61\164\x69\x6f\156\x20\x46\157\x72\x6d");
        $this->_isFormEnabled = get_mo_option("\x75\x6d\x5f\144\x65\146\141\x75\x6c\x74\x5f\x65\x6e\x61\x62\154\145");
        $this->_restrictDuplicates = get_mo_option("\x75\155\x5f\162\x65\x73\x74\162\x69\143\x74\137\x64\165\x70\154\x69\x63\x61\164\145\x73");
        $this->_buttonText = get_mo_option("\x75\155\137\x62\x75\164\164\157\156\x5f\164\x65\170\164");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\103\x6c\x69\143\153\40\x48\145\162\x65\40\x74\x6f\40\x73\145\x6e\x64\x20\x4f\x54\x50");
        $this->_formKey = get_mo_option("\x75\x6d\x5f\x76\x65\x72\151\146\x79\x5f\x6d\145\x74\141\137\153\x65\171");
        $this->_formDocuments = MoOTPDocs::UM_ENABLED;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x75\x6d\137\x65\156\141\142\154\x65\x5f\x74\x79\x70\x65");
        if ($this->isUltimateMemberV2Installed()) {
            goto y8;
        }
        add_action("\x75\155\x5f\163\165\x62\155\x69\164\x5f\x66\157\x72\155\x5f\145\x72\x72\157\162\x73\x5f\150\157\157\153\137", array($this, "\155\x69\156\x69\157\162\x61\156\x67\145\x5f\165\155\137\160\150\157\156\x65\x5f\166\x61\x6c\x69\144\x61\x74\151\x6f\156"), 99, 1);
        add_action("\x75\155\x5f\x62\145\146\x6f\x72\145\x5f\x6e\x65\167\137\x75\x73\145\162\x5f\162\145\147\x69\163\164\145\162", array($this, "\x6d\151\x6e\151\x6f\162\x61\x6e\147\x65\x5f\165\155\x5f\x75\x73\x65\x72\137\162\145\x67\151\163\164\x72\x61\164\x69\157\x6e"), 99, 1);
        goto hO;
        y8:
        add_action("\165\x6d\x5f\x73\165\142\x6d\151\x74\x5f\x66\x6f\x72\x6d\137\145\162\162\157\162\163\x5f\x68\157\157\153\137\x5f\162\145\147\x69\163\x74\x72\x61\x74\151\157\156", array($this, "\x6d\x69\156\x69\157\x72\141\156\147\x65\137\x75\155\x32\137\160\150\x6f\x6e\145\137\x76\141\154\151\x64\141\164\x69\157\x6e"), 99, 1);
        add_filter("\165\x6d\137\x72\x65\147\151\163\x74\162\x61\164\151\157\156\x5f\165\x73\145\x72\x5f\x72\157\x6c\x65", array($this, "\x6d\x69\156\151\157\x72\x61\156\x67\x65\137\x75\155\x32\x5f\165\163\145\162\x5f\x72\x65\147\x69\163\164\x72\x61\x74\151\x6f\x6e"), 99, 2);
        hO:
        if (!($this->_isAjaxForm && $this->_otpType != $this->_typeBothTag)) {
            goto VO;
        }
        add_action("\167\160\x5f\x65\x6e\x71\x75\145\x75\145\x5f\x73\x63\162\x69\160\x74\x73", array($this, "\155\x69\156\x69\x6f\x72\141\x6e\x67\145\x5f\x72\x65\x67\151\x73\x74\145\x72\137\165\155\x5f\x73\x63\162\151\160\x74"));
        $this->routeData();
        VO:
    }
    function isUltimateMemberV2Installed()
    {
        if (function_exists("\151\x73\x5f\160\x6c\x75\147\x69\156\x5f\x61\x63\164\x69\166\145")) {
            goto V8;
        }
        include_once ABSPATH . "\167\x70\x2d\x61\144\x6d\151\x6e\57\x69\x6e\143\154\165\144\145\x73\57\x70\x6c\165\x67\x69\x6e\x2e\160\150\x70";
        V8:
        return is_plugin_active("\x75\x6c\164\x69\x6d\x61\164\x65\55\x6d\145\x6d\x62\145\x72\x2f\x75\x6c\164\x69\155\x61\164\145\55\x6d\x65\x6d\142\x65\162\56\x70\x68\x70");
    }
    private function routeData()
    {
        if (array_key_exists("\157\x70\x74\151\157\x6e", $_GET)) {
            goto uv;
        }
        return;
        uv:
        switch (trim($_GET["\157\160\164\x69\157\x6e"])) {
            case "\x6d\151\156\x69\x6f\x72\x61\156\147\x65\55\165\155\55\x61\x6a\x61\x78\55\166\145\x72\x69\146\171":
                $this->sendAjaxOTPRequest();
                goto Lr;
        }
        Cr:
        Lr:
    }
    private function sendAjaxOTPRequest()
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        $this->validateAjaxRequest();
        $Pn = MoUtility::sanitizeCheck("\x75\x73\145\x72\x5f\160\x68\x6f\156\145", $_POST);
        $MQ = MoUtility::sanitizeCheck("\x75\x73\x65\x72\137\145\x6d\x61\151\154", $_POST);
        if ($this->_otpType === $this->_typePhoneTag) {
            goto wL;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $MQ);
        goto AN;
        wL:
        $this->checkDuplicates($Pn, $this->_phoneKey, null);
        SessionUtils::addPhoneVerified($this->_formSessionVar, $Pn);
        AN:
        $this->startOtpTransaction(null, $MQ, null, $Pn, null, null);
    }
    function miniorange_register_um_script()
    {
        wp_register_script("\155\x6f\x76\x75\x6d", MOV_URL . "\x69\156\143\x6c\165\x64\x65\x73\x2f\152\163\x2f\x75\x6d\162\x65\147\x2e\x6d\x69\156\x2e\152\163", array("\152\x71\x75\x65\x72\171"));
        wp_localize_script("\x6d\x6f\166\x75\x6d", "\x6d\157\x75\155\166\x61\162", array("\x73\151\x74\x65\125\x52\x4c" => site_url(), "\x6f\x74\x70\x54\171\x70\x65" => $this->_otpType, "\x6e\x6f\x6e\x63\145" => wp_create_nonce($this->_nonce), "\142\165\164\x74\157\x6e\164\145\x78\164" => mo_($this->_buttonText), "\x66\x69\145\x6c\144" => $this->_otpType === $this->_typePhoneTag ? $this->_phoneKey : "\165\163\145\x72\137\x65\x6d\x61\151\154", "\151\155\147\x55\x52\114" => MOV_LOADER_URL));
        wp_enqueue_script("\155\x6f\x76\165\155");
    }
    function isPhoneVerificationEnabled()
    {
        $ms = $this->getVerificationType();
        return $ms === VerificationType::PHONE || $ms === VerificationType::BOTH;
    }
    function miniorange_um2_user_registration($HM, $Kc)
    {
        $CN = $this->getVerificationType();
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $CN)) {
            goto ua;
        }
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar) && $this->_isAjaxForm) {
            goto J5;
        }
        MoUtility::initialize_transaction($this->_formSessionVar);
        $Kc = $this->extractArgs($Kc);
        $this->startOtpTransaction($Kc["\165\163\x65\162\137\154\x6f\147\x69\156"], $Kc["\165\x73\145\x72\137\145\x6d\x61\x69\154"], new WP_Error(), $Kc[$this->_phoneKey], $Kc["\x75\163\145\162\x5f\x70\x61\163\x73\x77\x6f\162\144"], null);
        goto l7;
        ua:
        $this->unsetOTPSessionVariables();
        return $HM;
        goto l7;
        J5:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PLEASE_VALIDATE), MoConstants::ERROR_JSON_TYPE));
        l7:
        return $HM;
    }
    private function extractArgs($Kc)
    {
        return array("\x75\x73\145\162\x5f\154\x6f\147\151\x6e" => $Kc["\x75\163\x65\x72\137\154\x6f\x67\151\156"], "\165\x73\145\x72\x5f\145\155\141\x69\x6c" => $Kc["\165\x73\x65\162\x5f\145\155\x61\x69\154"], $this->_phoneKey => $Kc[$this->_phoneKey], "\x75\x73\145\162\137\160\x61\163\163\167\157\x72\x64" => $Kc["\x75\163\x65\x72\x5f\x70\141\163\x73\x77\x6f\x72\x64"]);
    }
    function miniorange_um_user_registration($Kc)
    {
        $errors = new WP_Error();
        MoUtility::initialize_transaction($this->_formSessionVar);
        foreach ($Kc as $O5 => $Xd) {
            if ($O5 == "\165\163\x65\x72\x5f\x6c\157\x67\x69\156") {
                goto qG;
            }
            if ($O5 == "\165\x73\145\x72\137\145\x6d\141\x69\154") {
                goto RI;
            }
            if ($O5 == "\165\x73\x65\x72\137\160\x61\x73\163\x77\157\162\144") {
                goto qb;
            }
            if ($O5 == $this->_phoneKey) {
                goto ez;
            }
            $HL[$O5] = $Xd;
            goto Jf;
            qG:
            $EN = $Xd;
            goto Jf;
            RI:
            $Vy = $Xd;
            goto Jf;
            qb:
            $eW = $Xd;
            goto Jf;
            ez:
            $TB = $Xd;
            Jf:
            zF:
        }
        k0:
        $this->startOtpTransaction($EN, $Vy, $errors, $TB, $eW, $HL);
    }
    function startOtpTransaction($EN, $Vy, $errors, $TB, $eW, $HL)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto Na;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) == 0) {
            goto To;
        }
        $this->sendChallenge($EN, $Vy, $errors, $TB, VerificationType::EMAIL, $eW, $HL);
        goto jP;
        Na:
        $this->sendChallenge($EN, $Vy, $errors, $TB, VerificationType::PHONE, $eW, $HL);
        goto jP;
        To:
        $this->sendChallenge($EN, $Vy, $errors, $TB, VerificationType::BOTH, $eW, $HL);
        jP:
    }
    function miniorange_um2_phone_validation($Kc)
    {
        $form = UM()->form();
        foreach ($Kc as $O5 => $Xd) {
            if ($this->_isAjaxForm && $O5 === $this->_formKey) {
                goto iO;
            }
            if ($O5 === $this->_phoneKey) {
                goto P4;
            }
            goto dh;
            iO:
            $this->checkIntegrityAndValidateOTP($form, $Xd, $Kc);
            goto dh;
            P4:
            $this->processPhoneNumbers($Xd, $O5, $form);
            dh:
            eC:
        }
        nI:
    }
    private function processPhoneNumbers($Xd, $O5, $form = null)
    {
        global $phoneLogic;
        if (MoUtility::validatePhoneNumber($Xd)) {
            goto nf;
        }
        $Tg = str_replace("\43\43\160\x68\x6f\x6e\x65\x23\x23", $Xd, $phoneLogic->_get_otp_invalid_format_message());
        $form->add_error($O5, $Tg);
        nf:
        $this->checkDuplicates($Xd, $O5, $form);
    }
    private function checkDuplicates($Xd, $O5, $form = null)
    {
        if (!($this->_restrictDuplicates && $this->isPhoneNumberAlreadyInUse($Xd, $O5))) {
            goto zG;
        }
        $Tg = MoMessages::showMessage(MoMessages::PHONE_EXISTS);
        if ($this->_isAjaxForm && SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto M1;
        }
        $form->add_error($O5, $Tg);
        goto U1;
        M1:
        wp_send_json(MoUtility::createJson($Tg, MoConstants::ERROR_JSON_TYPE));
        U1:
        zG:
    }
    private function checkIntegrityAndValidateOTP($form, $Xd, array $Kc)
    {
        $CN = $this->getVerificationType();
        $this->checkIntegrity($form, $Kc, $CN);
        $this->validateChallenge($CN, NULL, $Xd);
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $CN)) {
            goto GY;
        }
        $form->add_error($this->_formKey, MoUtility::_get_invalid_otp_method());
        GY:
    }
    private function checkIntegrity($MZ, array $Kc, $CN)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto Zd;
        }
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) == 0)) {
            goto K2;
        }
        if (SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $Kc["\165\163\145\x72\x5f\145\x6d\141\x69\x6c"])) {
            goto my;
        }
        $MZ->add_error($this->_formKey, MoMessages::showMessage(MoMessages::EMAIL_MISMATCH));
        my:
        K2:
        goto Hq;
        Zd:
        if (SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $Kc[$this->_phoneKey])) {
            goto Uf;
        }
        $MZ->add_error($this->_formKey, MoMessages::showMessage(MoMessages::PHONE_MISMATCH));
        Uf:
        Hq:
    }
    function miniorange_um_phone_validation($Kc)
    {
        global $ultimatemember;
        foreach ($Kc as $O5 => $Xd) {
            if ($this->_isAjaxForm && $O5 === $this->_formKey) {
                goto H0;
            }
            if ($O5 === $this->_phoneKey) {
                goto jo;
            }
            goto MI;
            H0:
            $this->checkIntegrityAndValidateOTP($ultimatemember->form, $Xd, $Kc);
            goto MI;
            jo:
            $this->processPhoneNumbers($Xd, $O5, $ultimatemember->form);
            MI:
            Nj:
        }
        d0:
    }
    function isPhoneNumberAlreadyInUse($l1, $O5)
    {
        global $wpdb;
        MoUtility::processPhoneNumber($l1);
        $V0 = "\123\105\114\105\103\124\40\140\x75\163\145\162\137\x69\x64\x60\40\106\x52\117\x4d\x20\x60{$wpdb->prefix}\165\163\x65\x72\155\x65\164\x61\140\40\x57\110\x45\122\105\x20\x60\155\145\164\x61\137\x6b\x65\x79\x60\40\x3d\x20\x27{$O5}\47\40\x41\116\x44\40\140\155\145\x74\x61\x5f\166\x61\154\165\145\140\x20\x3d\x20\40\47{$l1}\x27";
        $KA = $wpdb->get_row($V0);
        return !MoUtility::isBlank($KA);
    }
    function handle_failed_verification($wE, $MQ, $TB, $au)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto ce;
        }
        return;
        ce:
        $CN = $this->getVerificationType();
        $Ta = $CN === VerificationType::BOTH ? TRUE : FALSE;
        if ($this->_isAjaxForm) {
            goto zq;
        }
        miniorange_site_otp_validation_form($wE, $MQ, $TB, MoUtility::_get_invalid_otp_method(), $CN, $Ta);
        zq:
    }
    function handle_post_verification($WE, $wE, $MQ, $eW, $TB, $HL, $au)
    {
        if (function_exists("\151\163\137\x70\154\x75\x67\x69\156\137\141\143\x74\151\x76\145")) {
            goto Lj;
        }
        include_once ABSPATH . "\167\x70\x2d\x61\x64\155\151\156\x2f\151\156\143\154\x75\x64\145\x73\x2f\160\x6c\x75\x67\x69\x6e\56\160\x68\160";
        Lj:
        if ($this->isUltimateMemberV2Installed()) {
            goto Bv;
        }
        $this->register_ultimateMember_user($wE, $MQ, $eW, $TB, $HL);
        goto jd;
        Bv:
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $au);
        jd:
    }
    function register_ultimateMember_user($wE, $MQ, $eW, $TB, $HL)
    {
        $Kc = array();
        $Kc["\165\163\x65\x72\x5f\154\x6f\147\151\156"] = $wE;
        $Kc["\165\x73\145\162\x5f\145\155\141\151\154"] = $MQ;
        $Kc["\165\x73\x65\x72\x5f\160\x61\163\x73\167\x6f\162\x64"] = $eW;
        $Kc = array_merge($Kc, $HL);
        $wc = wp_create_user($wE, $eW, $MQ);
        $this->unsetOTPSessionVariables();
        do_action("\165\x6d\137\141\x66\x74\x65\x72\x5f\156\x65\167\137\165\x73\x65\x72\x5f\x72\x65\147\151\163\164\x65\x72", $wc, $Kc);
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($sq)
    {
        if (!($this->isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto uu;
        }
        array_push($sq, $this->_phoneFormId);
        uu:
        return $sq;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto uK;
        }
        return;
        uK:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x75\155\137\x64\145\146\x61\x75\154\164\x5f\x65\156\141\142\x6c\x65");
        $this->_otpType = $this->sanitizeFormPOST("\x75\155\x5f\x65\x6e\141\x62\x6c\x65\x5f\164\x79\x70\x65");
        $this->_restrictDuplicates = $this->_otpType != $this->_typePhoneTag ? '' : $this->sanitizeFormPOST("\x75\x6d\137\162\145\163\x74\162\x69\143\x74\x5f\x64\x75\160\154\x69\x63\x61\164\145\163");
        $this->_isAjaxForm = $this->sanitizeFormPOST("\165\155\x5f\151\x73\137\x61\152\x61\x78\137\x66\157\x72\x6d");
        $this->_buttonText = $this->sanitizeFormPOST("\165\155\137\x62\x75\164\164\x6f\x6e\x5f\x74\145\170\164");
        $this->_formKey = $this->sanitizeFormPOST("\x75\x6d\x5f\166\145\162\151\146\x79\137\x6d\145\164\141\x5f\153\145\171");
        $this->_phoneKey = $this->sanitizeFormPOST("\165\x6d\137\x70\x68\x6f\156\145\137\153\x65\171");
        if (!$this->basicValidationCheck(BaseMessages::UM_CHOOSE)) {
            goto Xc;
        }
        update_mo_option("\165\x6d\x5f\160\150\157\x6e\145\137\x6b\x65\171", $this->_phoneKey);
        update_mo_option("\165\155\137\144\x65\x66\141\165\154\x74\137\x65\x6e\141\142\154\x65", $this->_isFormEnabled);
        update_mo_option("\165\155\x5f\x65\x6e\x61\x62\154\145\137\164\x79\160\145", $this->_otpType);
        update_mo_option("\x75\x6d\137\x72\x65\x73\164\x72\151\143\164\137\x64\165\x70\154\x69\143\141\164\145\x73", $this->_restrictDuplicates);
        update_mo_option("\165\155\x5f\x69\163\x5f\x61\152\141\170\137\x66\157\162\155", $this->_isAjaxForm);
        update_mo_option("\165\155\x5f\x62\165\164\164\157\x6e\137\x74\x65\170\164", $this->_buttonText);
        update_mo_option("\x75\155\x5f\166\145\x72\x69\146\x79\x5f\155\x65\x74\x61\x5f\153\x65\171", $this->_formKey);
        Xc:
    }
}
