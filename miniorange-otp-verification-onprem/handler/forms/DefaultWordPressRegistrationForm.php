<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
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
use WP_Error;
class DefaultWordPressRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::WP_DEFAULT_REG;
        $this->_phoneKey = "\x74\145\154\x65\x70\150\x6f\x6e\x65";
        $this->_phoneFormId = "\43\160\150\157\156\x65\x5f\x6e\165\155\142\145\162\137\155\x6f";
        $this->_formKey = "\127\x50\x5f\x44\105\106\x41\x55\x4c\124";
        $this->_typePhoneTag = "\155\x6f\137\x77\160\137\144\145\146\141\165\154\x74\137\x70\150\157\156\x65\x5f\x65\156\x61\x62\x6c\x65";
        $this->_typeEmailTag = "\155\x6f\x5f\167\x70\137\x64\145\x66\x61\165\x6c\x74\137\145\x6d\x61\151\x6c\137\x65\x6e\x61\142\154\x65";
        $this->_typeBothTag = "\x6d\x6f\x5f\x77\x70\137\x64\x65\x66\141\165\154\164\137\142\157\x74\150\x5f\x65\x6e\141\142\154\145";
        $this->_formName = mo_("\127\157\162\144\120\162\x65\x73\163\40\x44\x65\146\x61\x75\x6c\x74\40\57\x20\x54\x4d\x4c\40\122\x65\147\151\x73\164\162\x61\x74\151\157\156\x20\106\157\162\155");
        $this->_isFormEnabled = get_mo_option("\x77\x70\x5f\x64\x65\146\141\x75\154\x74\x5f\x65\x6e\141\x62\154\x65");
        $this->_formDocuments = MoOTPDocs::WP_DEFAULT_FORM_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\167\x70\x5f\x64\145\146\x61\x75\x6c\x74\137\145\156\x61\142\x6c\x65\137\164\171\160\145");
        $this->_disableAutoActivate = get_mo_option("\167\160\x5f\x72\145\147\137\x61\x75\164\157\x5f\141\x63\164\151\x76\141\164\x65") ? FALSE : TRUE;
        $this->_restrictDuplicates = get_mo_option("\x77\160\137\x72\x65\147\137\162\x65\163\x74\162\151\x63\x74\x5f\x64\x75\160\154\151\x63\141\164\145\x73");
        add_action("\x72\145\x67\x69\163\x74\145\x72\137\x66\157\162\155", array($this, "\155\x69\156\x69\x6f\x72\x61\156\x67\x65\x5f\x73\x69\x74\145\137\x72\x65\147\151\163\164\x65\162\137\x66\x6f\x72\155"));
        add_filter("\162\145\x67\x69\163\164\x72\x61\164\151\x6f\x6e\137\145\x72\162\157\162\163", array($this, "\x6d\x69\156\151\157\x72\x61\156\x67\x65\137\x73\151\164\x65\137\162\x65\x67\x69\163\164\162\x61\x74\151\x6f\156\137\145\x72\x72\x6f\162\163"), 99, 3);
        add_action("\141\x64\x6d\151\156\x5f\160\157\163\164\137\x6e\x6f\160\162\x69\166\137\166\141\x6c\151\144\x61\164\x69\x6f\x6e\137\147\x6f\x42\141\x63\153", array($this, "\x5f\x68\141\156\144\x6c\x65\137\x76\x61\154\x69\144\x61\x74\151\157\156\x5f\x67\x6f\x42\x61\x63\153\x5f\141\143\x74\151\157\156"));
        add_action("\x75\163\x65\x72\137\162\145\x67\151\163\164\x65\162", array($this, "\x6d\151\x6e\151\157\162\x61\156\x67\x65\x5f\162\x65\147\151\163\x74\x72\141\x74\x69\157\x6e\x5f\x73\x61\166\145"), 10, 1);
        add_filter("\x77\x70\x5f\154\x6f\147\x69\x6e\x5f\145\x72\x72\x6f\162\x73", array($this, "\x6d\x69\x6e\x69\157\x72\x61\156\147\145\x5f\x63\165\163\x74\x6f\x6d\137\162\145\x67\x5f\155\145\x73\x73\x61\x67\x65"), 10, 2);
        if ($this->_disableAutoActivate) {
            goto EP;
        }
        remove_action("\x72\x65\x67\151\x73\164\145\x72\137\x6e\x65\x77\137\165\x73\x65\162", "\167\x70\x5f\x73\x65\156\x64\x5f\156\145\167\137\165\163\145\x72\x5f\x6e\157\164\x69\146\151\143\x61\x74\151\157\156\x73");
        EP:
    }
    function isPhoneVerificationEnabled()
    {
        $au = $this->getVerificationType();
        return $au === VerificationType::PHONE || $au === VerificationType::BOTH;
    }
    function miniorange_custom_reg_message(WP_Error $errors, $WE)
    {
        if ($this->_disableAutoActivate) {
            goto l1;
        }
        if (!in_array("\162\x65\x67\x69\163\164\x65\162\x65\144", $errors->get_error_codes())) {
            goto x8;
        }
        $errors->remove("\x72\x65\147\x69\163\x74\145\162\145\144");
        $errors->add("\x72\x65\x67\x69\x73\x74\145\x72\145\x64", mo_("\x52\x65\x67\x69\163\x74\162\x61\x74\x69\157\x6e\x20\103\x6f\155\x70\x6c\x65\x74\x65\56"), "\x6d\x65\163\x73\x61\x67\145");
        x8:
        l1:
        return $errors;
    }
    function miniorange_site_register_form()
    {
        echo "\x3c\151\x6e\160\165\x74\x20\164\x79\160\x65\x3d\42\150\x69\x64\x64\145\156\42\40\156\141\155\x65\x3d\x22\x72\145\147\151\163\x74\x65\x72\137\156\x6f\x6e\143\145\42\40\x76\141\x6c\165\x65\x3d\x22\162\145\x67\x69\163\x74\x65\x72\137\156\157\156\143\x65\x22\x2f\x3e";
        if (!$this->isPhoneVerificationEnabled()) {
            goto Hf;
        }
        echo "\74\154\141\142\x65\x6c\40\146\157\x72\75\42\x70\x68\157\156\x65\x5f\156\165\155\142\145\162\137\155\157\42\x3e" . mo_("\120\x68\x6f\156\x65\x20\x4e\x75\155\142\145\162") . "\74\142\x72\40\x2f\x3e\xa\x20\x20\x20\40\x20\x20\x20\40\40\40\40\x20\x20\x20\x20\40\x3c\151\x6e\160\x75\164\40\164\171\160\145\x3d\x22\x74\x65\x78\164\x22\40\156\141\155\145\x3d\x22\x70\x68\157\x6e\x65\137\x6e\165\155\142\x65\x72\x5f\155\157\42\x20\x69\x64\75\42\160\150\x6f\156\x65\137\x6e\165\x6d\x62\x65\x72\137\155\x6f\x22\40\143\x6c\x61\x73\x73\75\x22\151\x6e\160\165\x74\x22\x20\166\141\x6c\x75\x65\x3d\42\x22\x20\163\164\x79\154\x65\x3d\42\x22\x2f\76\x3c\57\x6c\x61\142\145\x6c\x3e";
        Hf:
        if ($this->_disableAutoActivate) {
            goto dG;
        }
        echo "\x3c\154\141\142\x65\154\x20\146\x6f\x72\75\42\x70\x61\163\163\167\x6f\162\144\137\155\x6f\42\76" . mo_("\120\141\x73\163\x77\x6f\x72\144") . "\x3c\x62\x72\40\x2f\76\12\40\x20\x20\40\x20\x20\x20\40\40\40\40\40\x20\x20\x20\x20\74\151\156\160\165\164\x20\x74\x79\160\x65\x3d\x22\160\141\163\163\167\157\162\144\x22\x20\156\141\155\x65\75\x22\160\141\x73\x73\167\157\x72\144\x5f\x6d\157\x22\40\151\144\75\42\160\x61\x73\x73\167\x6f\x72\144\x5f\155\x6f\x22\x20\143\154\x61\x73\x73\x3d\x22\x69\156\x70\x75\x74\x22\x20\x76\x61\154\x75\145\75\x22\x22\40\x73\x74\x79\x6c\x65\x3d\42\42\x2f\x3e\x3c\57\154\141\x62\x65\x6c\76";
        echo "\74\x6c\x61\142\x65\154\x20\x66\x6f\x72\x3d\x22\x63\157\x6e\146\151\x72\155\x5f\x70\141\x73\x73\x77\x6f\162\144\x5f\x6d\157\x22\x3e" . mo_("\x43\x6f\156\x66\151\x72\155\40\x50\x61\163\x73\x77\x6f\162\x64") . "\74\142\162\40\57\76\12\x20\40\x20\x20\40\x20\40\40\40\40\x20\40\40\40\40\40\x3c\x69\x6e\160\165\164\40\x74\171\x70\x65\75\x22\x70\141\163\x73\x77\157\162\144\x22\x20\x6e\141\x6d\145\75\42\143\157\156\146\x69\162\x6d\x5f\x70\141\x73\163\x77\157\x72\144\137\x6d\x6f\x22\40\x69\x64\x3d\x22\x63\157\156\146\151\x72\155\x5f\x70\141\163\x73\x77\x6f\x72\x64\137\x6d\x6f\42\x20\x63\x6c\x61\163\163\75\42\151\156\160\165\x74\x22\40\166\141\154\165\x65\x3d\42\x22\40\x73\164\171\x6c\145\75\42\x22\57\76\x3c\57\x6c\141\142\x65\154\76";
        echo "\x3c\163\143\162\x69\160\x74\x3e\167\x69\x6e\x64\x6f\167\x2e\x6f\156\x6c\x6f\x61\144\x3d\146\165\x6e\x63\x74\151\x6f\x6e\x28\x29\x7b\40\144\x6f\x63\x75\155\145\x6e\164\56\x67\145\164\105\x6c\145\155\x65\156\x74\102\x79\111\x64\x28\x22\162\145\x67\137\160\x61\163\x73\155\141\x69\x6c\x22\x29\56\x72\x65\155\157\166\145\x28\51\73\40\x7d\74\x2f\x73\x63\162\x69\160\x74\x3e";
        dG:
    }
    function miniorange_registration_save($wc)
    {
        $ZI = MoPHPSessions::getSessionVar("\160\x68\157\156\x65\x5f\x6e\165\155\142\x65\162\x5f\155\157");
        if (!$ZI) {
            goto FO;
        }
        add_user_meta($wc, $this->_phoneKey, $ZI);
        FO:
        if ($this->_disableAutoActivate) {
            goto TH;
        }
        wp_set_password($_POST["\160\141\163\x73\167\x6f\x72\x64\137\x6d\157"], $wc);
        update_user_option($wc, "\x64\145\x66\141\165\154\164\137\x70\141\163\x73\167\157\162\x64\137\156\141\147", false, true);
        TH:
    }
    function miniorange_site_registration_errors(WP_Error $errors, $Ls, $MQ)
    {
        $TB = isset($_POST["\x70\x68\157\156\145\x5f\156\x75\155\142\x65\x72\x5f\155\157"]) ? $_POST["\160\x68\157\x6e\x65\137\156\165\155\142\x65\162\137\x6d\157"] : null;
        $eW = isset($_POST["\160\x61\163\x73\167\x6f\x72\144\x5f\x6d\157"]) ? $_POST["\x70\x61\163\x73\167\x6f\162\x64\137\155\x6f"] : null;
        $gW = isset($_POST["\x63\157\156\146\151\162\x6d\x5f\x70\141\163\163\167\x6f\162\144\137\155\x6f"]) ? $_POST["\143\157\x6e\x66\151\162\x6d\x5f\160\x61\x73\163\x77\157\162\x64\x5f\155\x6f"] : null;
        $this->checkIfPhoneNumberUnique($errors, $TB);
        $this->validatePasswords($errors, $eW, $gW);
        if (empty($errors->errors)) {
            goto vh;
        }
        return $errors;
        vh:
        if ($this->_otpType) {
            goto Dy;
        }
        return $errors;
        Dy:
        return $this->startOTPTransaction($Ls, $MQ, $errors, $TB);
    }
    private function validatePasswords(WP_Error &$zu, $eW, $gW)
    {
        if (!$this->_disableAutoActivate) {
            goto yf;
        }
        return;
        yf:
        if (!(strcasecmp($eW, $gW) !== 0)) {
            goto ZV;
        }
        $zu->add("\160\141\x73\163\x77\x6f\x72\144\x5f\155\151\x73\155\141\164\143\x68", MoMessages::showMessage(MoMessages::PASS_MISMATCH));
        ZV:
    }
    private function checkIfPhoneNumberUnique(WP_Error &$errors, $TB)
    {
        if (!(strcasecmp($this->_otpType, $this->_typePhoneTag) !== 0)) {
            goto e2;
        }
        return;
        e2:
        if (MoUtility::isBlank($TB) || !MoUtility::validatePhoneNumber($TB)) {
            goto QN;
        }
        if ($this->_restrictDuplicates && $this->isPhoneNumberAlreadyInUse(trim($TB), $this->_phoneKey)) {
            goto Wq;
        }
        goto sj;
        QN:
        $errors->add("\x69\156\x76\141\x6c\x69\144\137\x70\150\157\x6e\145", MoMessages::showMessage(MoMessages::ENTER_PHONE_DEFAULT));
        goto sj;
        Wq:
        $errors->add("\x69\x6e\x76\141\x6c\x69\144\137\x70\x68\157\x6e\145", MoMessages::showMessage(MoMessages::PHONE_EXISTS));
        sj:
    }
    function startOTPTransaction($Ls, $MQ, $errors, $TB)
    {
        if (!(!MoUtility::isBlank(array_filter($errors->errors)) || !isset($_POST["\x72\x65\x67\151\x73\164\x65\x72\x5f\156\157\156\143\145"]))) {
            goto HM;
        }
        return $errors;
        HM:
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0) {
            goto gh;
        }
        if (strcasecmp($this->_otpType, $this->_typeBothTag) === 0) {
            goto OW;
        }
        $this->sendChallenge($Ls, $MQ, $errors, $TB, VerificationType::EMAIL);
        goto i5;
        OW:
        $this->sendChallenge($Ls, $MQ, $errors, $TB, VerificationType::BOTH);
        i5:
        goto v6;
        gh:
        $this->sendChallenge($Ls, $MQ, $errors, $TB, VerificationType::PHONE);
        v6:
        return $errors;
    }
    function handle_failed_verification($wE, $MQ, $TB, $au)
    {
        $CN = $this->getVerificationType();
        $Ta = $CN === VerificationType::BOTH ? TRUE : FALSE;
        miniorange_site_otp_validation_form($wE, $MQ, $TB, MoUtility::_get_invalid_otp_method(), $CN, $Ta);
    }
    function handle_post_verification($WE, $wE, $MQ, $eW, $TB, $HL, $au)
    {
        $this->unsetOTPSessionVariables();
    }
    function isPhoneNumberAlreadyInUse($l1, $O5)
    {
        global $wpdb;
        $l1 = MoUtility::processPhoneNumber($l1);
        $KA = $wpdb->get_row("\123\x45\114\105\x43\x54\40\x60\165\x73\x65\x72\137\151\144\140\x20\106\x52\x4f\x4d\40\140{$wpdb->prefix}\165\163\x65\162\155\x65\164\141\x60\40\127\x48\x45\x52\105\40\x60\x6d\145\164\x61\137\153\145\x79\x60\40\x3d\x20\x27{$O5}\47\40\101\x4e\104\40\140\x6d\x65\x74\141\137\166\141\x6c\165\145\x60\x20\75\x20\40\47{$l1}\x27");
        return !MoUtility::isBlank($KA);
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($sq)
    {
        if (!($this->isFormEnabled() && $this->isPhoneVerificationEnabled())) {
            goto OJ;
        }
        array_push($sq, $this->_phoneFormId);
        OJ:
        return $sq;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto W0;
        }
        return;
        W0:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\167\x70\x5f\x64\145\x66\x61\165\154\164\137\145\156\141\x62\154\x65");
        $this->_otpType = $this->sanitizeFormPOST("\x77\x70\x5f\144\145\x66\141\x75\154\x74\137\x65\x6e\x61\142\x6c\x65\x5f\x74\x79\x70\145");
        $this->_restrictDuplicates = $this->sanitizeFormPOST("\x77\160\137\x72\x65\x67\x5f\162\145\163\x74\x72\151\x63\x74\x5f\144\x75\160\x6c\x69\x63\x61\x74\x65\x73");
        $this->_disableAutoActivate = $this->sanitizeFormPOST("\x77\x70\137\x72\145\147\137\x61\165\x74\157\x5f\x61\x63\x74\x69\x76\x61\x74\145") ? FALSE : TRUE;
        update_mo_option("\167\x70\x5f\x64\x65\146\x61\x75\154\164\x5f\145\156\x61\x62\154\x65", $this->_isFormEnabled);
        update_mo_option("\x77\160\x5f\144\145\146\x61\165\154\164\x5f\145\x6e\141\142\154\145\x5f\164\x79\160\x65", $this->_otpType);
        update_mo_option("\x77\160\x5f\x72\x65\x67\x5f\x72\145\x73\x74\x72\151\x63\x74\137\x64\165\160\x6c\x69\x63\x61\164\x65\x73", $this->_restrictDuplicates);
        update_mo_option("\167\x70\x5f\162\x65\x67\137\x61\x75\164\x6f\137\141\143\164\x69\x76\x61\x74\x65", $this->_disableAutoActivate ? FALSE : TRUE);
    }
}
