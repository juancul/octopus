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
use UM\Core\Form;
class UltimateMemberProfileForm extends FormHandler implements IFormHandler
{
    use Instance;
    private $_verifyFieldKey;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::UM_PROFILE_UPDATE;
        $this->_typePhoneTag = "\x6d\x6f\137\165\155\x5f\160\162\157\146\151\x6c\x65\x5f\160\x68\157\156\145\x5f\145\156\141\142\154\145";
        $this->_typeEmailTag = "\x6d\157\137\x75\155\x5f\160\x72\157\146\x69\x6c\145\137\145\155\x61\x69\154\x5f\145\156\141\x62\x6c\x65";
        $this->_typeBothTag = "\x6d\157\x5f\165\155\137\x70\x72\157\x66\151\x6c\145\137\142\x6f\x74\x68\x5f\x65\x6e\x61\x62\154\x65";
        $this->_formKey = "\x55\114\x54\111\x4d\101\x54\105\x5f\x50\x52\x4f\106\111\x4c\x45\x5f\x46\117\x52\115";
        $this->_verifyFieldKey = "\166\x65\162\151\146\171\x5f\x66\151\145\x6c\x64";
        $this->_formName = mo_("\x55\154\x74\151\x6d\x61\164\145\x20\115\x65\x6d\x62\x65\x72\40\x50\162\157\146\151\x6c\x65\57\101\143\x63\157\165\x6e\x74\40\x46\157\x72\x6d");
        $this->_isFormEnabled = get_mo_option("\x75\x6d\137\x70\x72\157\146\151\x6c\x65\x5f\x65\x6e\141\x62\x6c\145");
        $this->_restrictDuplicates = get_mo_option("\165\x6d\137\160\162\157\146\x69\154\x65\137\x72\x65\x73\164\162\x69\x63\164\x5f\x64\165\160\x6c\151\143\141\x74\x65\163");
        $this->_buttonText = get_mo_option("\x75\155\x5f\x70\162\x6f\x66\x69\x6c\x65\137\x62\x75\x74\164\x6f\x6e\x5f\x74\145\170\164");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\x43\x6c\151\143\x6b\40\x48\x65\x72\x65\x20\164\157\40\163\145\x6e\144\x20\x4f\x54\120");
        $this->_emailKey = "\165\163\145\162\137\x65\155\141\151\x6c";
        $this->_phoneKey = get_mo_option("\165\x6d\137\160\162\157\146\151\x6c\145\137\x70\150\157\156\x65\137\153\x65\x79");
        $this->_phoneKey = $this->_phoneKey ? $this->_phoneKey : "\x6d\157\142\x69\154\x65\x5f\156\165\x6d\142\x65\162";
        $this->_phoneFormId = "\x69\x6e\x70\x75\164\133\156\141\155\x65\136\x3d\47{$this->_phoneKey}\x27\135";
        $this->_formDocuments = MoOTPDocs::UM_PROFILE;
        parent::__construct();
    }
    public function handleForm()
    {
        $this->_otpType = get_mo_option("\165\155\137\x70\162\x6f\146\x69\x6c\145\137\x65\156\x61\x62\154\145\137\x74\171\x70\x65");
        add_action("\167\160\137\x65\x6e\161\165\x65\165\x65\x5f\x73\143\162\x69\160\164\163", array($this, "\x6d\151\156\151\x6f\162\x61\x6e\147\x65\137\162\145\x67\x69\x73\x74\145\x72\x5f\165\155\x5f\163\x63\162\x69\x70\x74"));
        add_action("\x75\155\x5f\x73\165\x62\x6d\x69\164\x5f\x61\143\143\x6f\165\x6e\x74\137\145\162\x72\157\162\163\x5f\150\157\x6f\x6b", array($this, "\155\151\156\151\x6f\x72\141\x6e\x67\145\x5f\x75\x6d\x5f\x76\x61\154\x69\144\141\164\x69\x6f\x6e"), 99, 1);
        add_action("\x75\155\137\141\x64\144\x5f\145\162\162\157\x72\x5f\157\156\137\146\x6f\162\155\137\x73\165\142\x6d\151\164\137\x76\141\154\x69\144\x61\x74\151\157\156", array($this, "\x6d\x69\156\151\x6f\x72\141\156\147\x65\x5f\165\155\137\x70\162\x6f\x66\151\154\x65\x5f\166\141\154\151\x64\x61\164\151\x6f\x6e"), 1, 3);
        $this->routeData();
    }
    private function isAccountVerificationEnabled()
    {
        return strcasecmp($this->_otpType, $this->_typeEmailTag) == 0 || strcasecmp($this->_otpType, $this->_typeBothTag) == 0;
    }
    private function isProfileVerificationEnabled()
    {
        return strcasecmp($this->_otpType, $this->_typePhoneTag) == 0 || strcasecmp($this->_otpType, $this->_typeBothTag) == 0;
    }
    private function routeData()
    {
        if (array_key_exists("\x6f\x70\x74\x69\157\156", $_GET)) {
            goto xm;
        }
        return;
        xm:
        switch (trim($_GET["\x6f\x70\164\151\x6f\x6e"])) {
            case "\155\x69\156\x69\x6f\162\x61\x6e\147\145\55\x75\x6d\55\x61\x63\143\55\x61\152\141\170\55\166\145\162\151\x66\x79":
                $this->sendAjaxOTPRequest();
                goto No;
        }
        Mv:
        No:
    }
    private function sendAjaxOTPRequest()
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        $this->validateAjaxRequest();
        $Pn = MoUtility::sanitizeCheck("\x75\163\145\x72\x5f\160\x68\x6f\x6e\x65", $_POST);
        $MQ = MoUtility::sanitizeCheck("\165\163\x65\x72\x5f\145\155\x61\151\154", $_POST);
        $wR = MoUtility::sanitizeCheck("\x6f\164\x70\137\x72\x65\161\165\x65\163\x74\x5f\164\171\160\145", $_POST);
        $this->startOtpTransaction($MQ, $Pn, $wR);
    }
    private function startOtpTransaction($Vy, $TB, $wR)
    {
        if (strcasecmp($wR, $this->_typePhoneTag) == 0) {
            goto Ca;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $Vy);
        $this->sendChallenge(null, $Vy, null, $TB, VerificationType::EMAIL, null, null);
        goto EO;
        Ca:
        $this->checkDuplicates($TB, $this->_phoneKey);
        SessionUtils::addPhoneVerified($this->_formSessionVar, $TB);
        $this->sendChallenge(null, $Vy, null, $TB, VerificationType::PHONE, null, null);
        EO:
    }
    private function checkDuplicates($Xd, $O5)
    {
        if (!($this->_restrictDuplicates && $this->isPhoneNumberAlreadyInUse($Xd, $O5))) {
            goto r7;
        }
        $Tg = MoMessages::showMessage(MoMessages::PHONE_EXISTS);
        wp_send_json(MoUtility::createJson($Tg, MoConstants::ERROR_JSON_TYPE));
        r7:
    }
    private function getUserData($O5)
    {
        $current_user = wp_get_current_user();
        if ($O5 === $this->_phoneKey) {
            goto Rp;
        }
        return $current_user->user_email;
        goto xL;
        Rp:
        global $wpdb;
        $V0 = "\x53\105\x4c\105\x43\x54\40\x6d\145\x74\141\x5f\166\141\x6c\x75\145\x20\x46\122\x4f\115\40\x60{$wpdb->prefix}\x75\x73\x65\x72\x6d\145\x74\141\140\40\127\110\x45\x52\105\x20\x60\x6d\145\x74\x61\x5f\153\x65\x79\140\x20\x3d\x20\47{$O5}\47\x20\x41\116\x44\40\x60\165\x73\x65\x72\x5f\x69\144\140\40\x3d\40{$current_user->ID}";
        $KA = $wpdb->get_row($V0);
        return isset($KA) ? $KA->meta_value : '';
        xL:
    }
    private function checkFormSession($form)
    {
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto Ox;
        }
        $form->add_error($this->_emailKey, MoUtility::_get_invalid_otp_method());
        $form->add_error($this->_phoneKey, MoUtility::_get_invalid_otp_method());
        goto Gi;
        Ox:
        $this->unsetOTPSessionVariables();
        Gi:
    }
    private function getUmFormObj()
    {
        if ($this->isUltimateMemberV2Installed()) {
            goto h2;
        }
        global $ultimatemember;
        return $ultimatemember->form;
        goto Ve;
        h2:
        return UM()->form();
        Ve:
    }
    function isUltimateMemberV2Installed()
    {
        if (function_exists("\x69\x73\x5f\x70\154\165\147\151\156\137\x61\143\x74\x69\x76\145")) {
            goto FU;
        }
        include_once ABSPATH . "\x77\160\55\141\144\155\x69\156\57\x69\x6e\x63\x6c\x75\144\145\163\x2f\x70\154\165\x67\x69\x6e\x2e\160\150\160";
        FU:
        return is_plugin_active("\x75\154\x74\x69\x6d\141\x74\x65\55\155\x65\155\x62\x65\162\57\165\154\164\151\x6d\141\164\145\55\155\x65\155\x62\145\162\56\160\x68\160");
    }
    function isPhoneNumberAlreadyInUse($l1, $O5)
    {
        global $wpdb;
        MoUtility::processPhoneNumber($l1);
        $V0 = "\123\x45\x4c\x45\103\x54\40\x60\165\163\145\162\137\151\144\140\x20\x46\122\117\x4d\40\140{$wpdb->prefix}\x75\163\x65\x72\155\145\x74\x61\140\x20\x57\110\105\x52\x45\x20\x60\155\x65\x74\141\137\153\x65\x79\x60\x20\x3d\40\x27{$O5}\x27\40\101\116\x44\40\x60\155\x65\164\141\137\166\141\154\165\x65\x60\x20\x3d\40\x20\x27{$l1}\x27";
        $KA = $wpdb->get_row($V0);
        return !MoUtility::isBlank($KA);
    }
    public function miniorange_register_um_script()
    {
        wp_register_script("\x6d\x6f\166\165\x6d\160\162\x6f\x66\x69\x6c\145", MOV_URL . "\151\156\143\x6c\165\144\145\x73\57\x6a\163\x2f\x6d\x6f\x75\155\160\162\x6f\146\151\x6c\145\56\x6d\x69\x6e\x2e\x6a\163", array("\x6a\x71\x75\x65\x72\171"));
        wp_localize_script("\x6d\157\166\x75\x6d\x70\x72\157\x66\x69\154\x65", "\x6d\157\165\x6d\x61\x63\x76\141\162", array("\x73\151\x74\145\125\122\114" => site_url(), "\157\x74\x70\124\x79\160\145" => $this->_otpType, "\145\155\141\x69\154\x4f\x74\160\124\171\x70\145" => $this->_typeEmailTag, "\160\x68\157\x6e\x65\x4f\164\160\x54\x79\x70\x65" => $this->_typePhoneTag, "\x62\157\x74\150\117\x54\120\124\x79\160\145" => $this->_typeBothTag, "\x6e\157\156\x63\145" => wp_create_nonce($this->_nonce), "\142\x75\x74\x74\x6f\156\x54\x65\170\x74" => mo_($this->_buttonText), "\x69\155\x67\125\122\x4c" => MOV_LOADER_URL, "\146\x6f\162\155\x4b\145\x79" => $this->_verifyFieldKey, "\145\x6d\x61\151\154\126\x61\x6c\165\x65" => $this->getUserData($this->_emailKey), "\160\150\157\x6e\x65\x56\141\154\165\145" => $this->getUserData($this->_phoneKey), "\x70\x68\157\x6e\x65\113\x65\171" => $this->_phoneKey));
        wp_enqueue_script("\x6d\x6f\166\165\x6d\160\x72\x6f\146\151\x6c\x65");
    }
    private function userHasNotChangeData($qf, $Kc)
    {
        $tT = $this->getUserData($qf);
        return strcasecmp($tT, $Kc[$qf]) != 0;
    }
    public function miniorange_um_validation($Kc, $qf = "\165\163\x65\162\x5f\145\155\141\151\x6c")
    {
        $i3 = MoUtility::sanitizeCheck("\x6d\157\144\145", $Kc);
        if (!(!$this->userHasNotChangeData($qf, $Kc) && $i3 != "\x72\x65\x67\151\163\x74\145\162")) {
            goto az;
        }
        $form = $this->getUmFormObj();
        if ($this->isValidationRequired($qf) && !SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto ZB;
        }
        foreach ($Kc as $O5 => $Xd) {
            if ($O5 === $this->_verifyFieldKey) {
                goto br;
            }
            if ($O5 === $this->_phoneKey) {
                goto KV;
            }
            goto kL;
            br:
            $this->checkIntegrityAndValidateOTP($form, $Xd, $Kc);
            goto kL;
            KV:
            $this->processPhoneNumbers($Xd, $form);
            kL:
            kl:
        }
        P7:
        goto q5;
        ZB:
        $O5 = $this->isProfileVerificationEnabled() && $i3 == "\160\x72\157\146\151\x6c\145" ? $this->_phoneKey : $this->_emailKey;
        $form->add_error($O5, MoMessages::showMessage(MoMessages::PLEASE_VALIDATE));
        q5:
        az:
    }
    private function isValidationRequired($qf)
    {
        return $this->isAccountVerificationEnabled() && $qf === "\165\x73\145\x72\x5f\145\x6d\x61\151\x6c" || $this->isProfileVerificationEnabled() && $qf === $this->_phoneKey;
    }
    public function miniorange_um_profile_validation($form, $O5, $Kc)
    {
        if (!($O5 === $this->_phoneKey)) {
            goto iZ;
        }
        $this->miniorange_um_validation($Kc, $this->_phoneKey);
        iZ:
    }
    private function processPhoneNumbers($Xd, $form)
    {
        global $phoneLogic;
        if (MoUtility::validatePhoneNumber($Xd)) {
            goto bM;
        }
        $Tg = str_replace("\x23\x23\x70\x68\x6f\x6e\x65\43\43", $Xd, $phoneLogic->_get_otp_invalid_format_message());
        $form->add_error($this->_phoneKey, $Tg);
        bM:
        $this->checkDuplicates($Xd, $this->_phoneKey);
    }
    private function checkIntegrityAndValidateOTP($form, $Xd, array $Kc)
    {
        $this->checkIntegrity($form, $Kc);
        if (!($form->count_errors() > 0)) {
            goto K0;
        }
        return;
        K0:
        $this->validateChallenge($this->getVerificationType(), NULL, $Xd);
        $this->checkFormSession($form);
    }
    private function checkIntegrity($MZ, array $Kc)
    {
        if (!$this->isProfileVerificationEnabled()) {
            goto O0;
        }
        if (!SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $Kc[$this->_phoneKey])) {
            goto qQ;
        }
        $MZ->add_error($this->_phoneKey, MoMessages::showMessage(MoMessages::PHONE_MISMATCH));
        qQ:
        O0:
        if (!$this->isAccountVerificationEnabled()) {
            goto t5;
        }
        if (!SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $Kc[$this->_emailKey])) {
            goto us;
        }
        $MZ->add_error($this->_emailKey, MoMessages::showMessage(MoMessages::EMAIL_MISMATCH));
        us:
        t5:
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function handle_post_verification($WE, $wE, $MQ, $eW, $TB, $HL, $au)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $au);
    }
    public function handle_failed_verification($wE, $MQ, $TB, $au)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VERIFICATION_FAILED, $au);
    }
    public function getPhoneNumberSelector($sq)
    {
        if (!($this->isFormEnabled() && $this->isProfileVerificationEnabled())) {
            goto OU;
        }
        array_push($sq, $this->_phoneFormId);
        OU:
        return $sq;
    }
    public function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto Zz;
        }
        return;
        Zz:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x75\155\x5f\x70\162\157\x66\x69\154\x65\x5f\x65\x6e\x61\142\x6c\145");
        $this->_otpType = $this->sanitizeFormPOST("\x75\x6d\137\160\162\x6f\x66\151\x6c\x65\x5f\145\156\141\x62\154\145\x5f\164\171\x70\x65");
        $this->_buttonText = $this->sanitizeFormPOST("\x75\155\137\x70\162\157\146\x69\x6c\145\137\x62\x75\164\164\157\156\x5f\x74\145\x78\164");
        $this->_restrictDuplicates = $this->sanitizeFormPOST("\x75\x6d\x5f\160\x72\157\x66\x69\154\145\137\162\x65\x73\164\x72\151\143\164\x5f\x64\165\x70\x6c\x69\143\x61\x74\x65\163");
        $this->_phoneKey = $this->sanitizeFormPOST("\x75\155\137\x70\162\157\146\x69\x6c\x65\x5f\160\150\x6f\x6e\x65\x5f\x6b\145\x79");
        if (!$this->basicValidationCheck(BaseMessages::UM_PROFILE_CHOOSE)) {
            goto mp;
        }
        update_mo_option("\165\x6d\x5f\x70\162\157\x66\151\154\145\137\145\156\x61\x62\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\x75\155\137\x70\162\x6f\146\x69\x6c\x65\x5f\x65\156\x61\142\154\x65\x5f\x74\x79\160\x65", $this->_otpType);
        update_mo_option("\x75\x6d\137\160\x72\157\x66\x69\154\x65\x5f\142\x75\164\164\157\x6e\x5f\x74\145\x78\x74", $this->_buttonText);
        update_mo_option("\165\155\137\160\x72\x6f\146\151\154\145\x5f\162\145\163\164\162\x69\143\x74\137\144\x75\x70\154\151\x63\x61\x74\145\163", $this->_restrictDuplicates);
        update_mo_option("\x75\155\137\160\162\157\x66\151\154\145\137\x70\x68\x6f\x6e\145\137\x6b\x65\x79", $this->_phoneKey);
        mp:
    }
}
