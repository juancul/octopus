<?php


namespace OTP\Addons\PasswordReset\Handler;

use OTP\Addons\PasswordReset\Helper\UMPasswordResetMessages;
use OTP\Helper\FormSessionVars;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use UM;
use um\core\Form;
use um\core\Options;
use um\core\Password;
use um\core\User;
use WP_User;
class UMPasswordResetHandler extends FormHandler implements IFormHandler
{
    use Instance;
    private $_fieldKey;
    private $_isOnlyPhoneReset;
    protected function __construct()
    {
        $this->_isAjaxForm = TRUE;
        $this->_isAddOnForm = TRUE;
        $this->_formOption = "\x75\x6d\137\160\141\x73\x73\167\157\x72\x64\137\162\145\163\145\x74\137\150\x61\156\144\154\145\x72";
        $this->_formSessionVar = FormSessionVars::UM_DEFAULT_PASS;
        $this->_typePhoneTag = "\x6d\157\x5f\165\x6d\137\160\150\x6f\x6e\145\x5f\x65\156\x61\x62\154\x65";
        $this->_typeEmailTag = "\x6d\157\137\x75\x6d\137\145\155\141\x69\154\x5f\x65\x6e\x61\142\x6c\x65";
        $this->_phoneFormId = "\165\163\145\x72\156\x61\x6d\145\x5f\x62";
        $this->_fieldKey = "\x75\163\145\x72\x6e\141\x6d\x65\137\x62";
        $this->_formKey = "\x55\x4c\124\x49\x4d\x41\124\x45\137\120\101\123\x53\x5f\x52\105\x53\x45\124";
        $this->_formName = mo_("\125\154\x74\151\155\141\164\145\x20\115\145\x6d\x62\145\x72\x20\120\141\163\163\167\157\x72\144\x20\122\x65\163\x65\x74\40\x75\163\151\156\147\40\117\124\x50");
        $this->_isFormEnabled = get_umpr_option("\x70\x61\163\x73\x5f\145\x6e\x61\x62\x6c\x65") ? TRUE : FALSE;
        $this->_generateOTPAction = "\155\157\x5f\x75\155\160\162\137\163\145\156\144\x5f\157\164\160";
        $this->_buttonText = get_umpr_option("\x70\141\163\x73\x5f\142\x75\x74\164\157\x6e\137\164\145\170\164");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\122\145\x73\x65\x74\40\120\141\x73\163\x77\157\x72\x64");
        $this->_phoneKey = get_umpr_option("\160\141\163\163\137\x70\150\157\156\x65\x4b\145\x79");
        $this->_phoneKey = $this->_phoneKey ? $this->_phoneKey : "\x6d\157\x62\151\154\x65\x5f\156\165\155\x62\145\x72";
        $this->_isOnlyPhoneReset = get_umpr_option("\x6f\x6e\154\x79\137\x70\150\157\156\145\137\x72\x65\163\x65\164");
        parent::__construct();
    }
    public function handleForm()
    {
        $this->_otpType = get_umpr_option("\145\156\x61\142\x6c\145\x64\137\164\171\160\145");
        if (!$this->_isOnlyPhoneReset) {
            goto Q2;
        }
        $this->_phoneFormId = "\x69\156\160\x75\x74\x23\x75\x73\x65\x72\156\141\155\145\137\x62";
        Q2:
        add_action("\167\160\137\141\152\141\170\137\x6e\157\160\x72\x69\166\137" . $this->_generateOTPAction, array($this, "\x73\145\x6e\144\x41\x6a\x61\x78\x4f\124\x50\x52\x65\161\x75\145\163\164"));
        add_action("\167\160\137\141\x6a\141\170\x5f" . $this->_generateOTPAction, array($this, "\x73\x65\x6e\144\x41\x6a\141\170\x4f\124\120\x52\145\161\x75\x65\x73\x74"));
        add_action("\167\x70\137\145\156\161\x75\x65\x75\x65\137\x73\143\x72\151\x70\164\163", array($this, "\155\151\156\151\x6f\x72\x61\x6e\147\x65\x5f\x72\x65\147\x69\x73\164\145\162\x5f\x75\x6d\137\x73\143\x72\x69\x70\x74"));
        add_action("\165\155\137\x72\145\163\x65\164\137\160\x61\x73\163\167\157\162\x64\137\145\162\162\157\x72\x73\x5f\150\157\157\153", array($this, "\x75\x6d\x5f\x72\145\x73\x65\x74\x5f\x70\141\x73\163\167\x6f\x72\144\137\145\162\162\157\x72\x73\x5f\x68\x6f\157\x6b"), 99);
        add_action("\165\155\x5f\x72\145\163\145\164\137\x70\141\x73\163\x77\x6f\x72\144\x5f\x70\162\157\143\x65\163\x73\137\150\x6f\x6f\153", array($this, "\x75\155\x5f\x72\145\163\x65\x74\137\160\x61\163\x73\167\157\x72\x64\x5f\x70\162\157\143\145\163\x73\137\150\157\157\x6b"), 1);
    }
    public function sendAjaxOTPRequest()
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        $this->validateAjaxRequest();
        $EN = MoUtility::sanitizeCheck("\x75\163\x65\x72\x6e\141\155\145", $_POST);
        SessionUtils::addUserInSession($this->_formSessionVar, $EN);
        $user = $this->getUser($EN);
        $l1 = get_user_meta($user->ID, $this->_phoneKey, true);
        $this->startOtpTransaction(null, $user->user_email, null, $l1, null, null);
    }
    public function um_reset_password_process_hook()
    {
        $user = MoUtility::sanitizeCheck("\x75\x73\145\x72\156\x61\155\x65\x5f\142", $_POST);
        $user = $this->getUser(trim($user));
        $D2 = $this->getUmPwdObj();
        um_fetch_user($user->ID);
        $this->getUmUserObj()->password_reset();
        wp_redirect($D2->reset_url());
        die;
    }
    public function um_reset_password_errors_hook()
    {
        $form = $this->getUmFormObj();
        $EN = MoUtility::sanitizeCheck($this->_fieldKey, $_POST);
        if (!isset($form->errors)) {
            goto Cp;
        }
        if (!(strcasecmp($this->_otpType, $this->_typePhoneTag) == 0 && MoUtility::validatePhoneNumber($EN))) {
            goto Br;
        }
        $user = $this->getUserFromPhoneNumber($EN);
        if (!$user) {
            goto RK;
        }
        $form->errors = null;
        if (isset($form->errors)) {
            goto SZ;
        }
        $this->check_reset_password_limit($form, $user->ID);
        SZ:
        goto r_;
        RK:
        $form->add_error($this->_fieldKey, UMPasswordResetMessages::showMessage(UMPasswordResetMessages::USERNAME_NOT_EXIST));
        r_:
        Br:
        Cp:
        if (isset($form->errors)) {
            goto bU;
        }
        $this->checkIntegrityAndValidateOTP($form, MoUtility::sanitizeCheck("\x76\x65\x72\x69\x66\171\137\x66\x69\145\x6c\144", $_POST), $_POST);
        bU:
    }
    private function checkIntegrityAndValidateOTP(&$form, $Xd, array $Kc)
    {
        $CN = $this->getVerificationType();
        $this->checkIntegrity($form, $Kc);
        $this->validateChallenge($CN, NULL, $Xd);
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $CN)) {
            goto Au;
        }
        $form->add_error($this->_fieldKey, UMPasswordResetMessages::showMessage(UMPasswordResetMessages::INVALID_OTP));
        Au:
    }
    private function checkIntegrity($MZ, array $Kc)
    {
        $Fq = SessionUtils::getUserSubmitted($this->_formSessionVar);
        if (!($Fq !== $Kc[$this->_fieldKey])) {
            goto PC;
        }
        $MZ->add_error($this->_fieldKey, UMPasswordResetMessages::showMessage(UMPasswordResetMessages::USERNAME_MISMATCH));
        PC:
    }
    public function getUserId($user)
    {
        $user = $this->getUser($user);
        return $user ? $user->ID : false;
    }
    public function getUser($EN)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0 && MoUtility::validatePhoneNumber($EN)) {
            goto nu;
        }
        if (is_email($EN)) {
            goto gO;
        }
        $user = get_user_by("\x6c\x6f\x67\151\156", $EN);
        goto c3;
        gO:
        $user = get_user_by("\145\155\x61\151\x6c", $EN);
        c3:
        goto D9;
        nu:
        $EN = MoUtility::processPhoneNumber($EN);
        $user = $this->getUserFromPhoneNumber($EN);
        D9:
        return $user;
    }
    function getUserFromPhoneNumber($EN)
    {
        global $wpdb;
        $KA = $wpdb->get_row("\123\x45\114\x45\x43\124\x20\x60\165\163\x65\162\137\151\144\x60\40\x46\x52\x4f\x4d\x20\x60{$wpdb->prefix}\165\163\x65\x72\x6d\145\x74\141\x60\40\127\x48\x45\122\105\40\140\155\x65\164\141\x5f\x6b\145\x79\x60\x20\75\x20\x27{$this->_phoneKey}\47\40\x41\116\104\40\x60\155\145\164\x61\x5f\x76\141\x6c\165\x65\140\x20\x3d\x20\x20\47{$EN}\x27");
        return !MoUtility::isBlank($KA) ? get_userdata($KA->user_id) : false;
    }
    public function check_reset_password_limit(Form &$form, $wc)
    {
        $h1 = (int) get_user_meta($wc, "\160\x61\x73\163\x77\157\x72\x64\x5f\162\163\x74\137\141\164\x74\145\x6d\160\164\163", true);
        $J0 = user_can(intval($wc), "\x6d\141\156\x61\x67\x65\x5f\x6f\x70\x74\x69\x6f\x6e\x73");
        if (!$this->getUmOptions()->get("\x65\x6e\x61\x62\x6c\x65\x5f\162\145\163\145\164\x5f\x70\x61\x73\x73\x77\x6f\x72\144\x5f\x6c\x69\155\x69\x74")) {
            goto GB;
        }
        if ($this->getUmOptions()->get("\144\x69\163\141\x62\x6c\145\x5f\x61\x64\x6d\x69\x6e\x5f\162\145\x73\x65\x74\137\x70\141\x73\x73\167\157\x72\144\x5f\154\151\x6d\x69\x74") && $J0) {
            goto ND;
        }
        $N3 = $this->getUmOptions()->get("\162\x65\163\145\x74\x5f\x70\x61\x73\163\x77\x6f\x72\144\x5f\x6c\151\155\x69\x74\137\x6e\165\155\x62\x65\162");
        if ($h1 >= $N3) {
            goto tO;
        }
        update_user_meta($wc, "\x70\x61\163\163\x77\157\x72\x64\x5f\162\x73\x74\137\x61\164\164\145\155\x70\164\163", $h1 + 1);
        goto Qy;
        tO:
        $form->add_error($this->_fieldKey, __("\131\x6f\165\40\x68\x61\166\x65\x20\162\x65\141\x63\150\145\144\x20\x74\x68\145\x20\x6c\x69\x6d\151\164\40\x66\x6f\x72\40\x72\x65\161\165\145\x73\164\x69\156\147\x20\x70\x61\163\163\x77\x6f\x72\144\40\42\x2e\12\x20\40\40\x20\x20\x20\x20\x20\40\x20\x20\40\x20\40\x20\x20\x20\x20\40\x20\x22\143\150\141\156\x67\145\x20\x66\157\x72\x20\164\x68\x69\163\40\x75\163\145\x72\40\141\x6c\x72\x65\x61\x64\x79\56\40\x43\x6f\156\164\141\x63\164\x20\x73\165\160\160\157\162\164\40\x69\146\x20\x79\157\165\40\143\x61\x6e\156\x6f\x74\40\157\x70\x65\x6e\40\x74\150\145\x20\x65\x6d\x61\151\x6c", "\x75\154\x74\151\155\141\x74\145\55\155\x65\x6d\x62\x65\x72"));
        Qy:
        goto ep;
        ND:
        ep:
        GB:
    }
    private function getUmFormObj()
    {
        if ($this->isUltimateMemberV2Installed()) {
            goto Yw;
        }
        global $ultimatemember;
        return $ultimatemember->form;
        goto FC;
        Yw:
        return UM()->form();
        FC:
    }
    private function getUmUserObj()
    {
        if ($this->isUltimateMemberV2Installed()) {
            goto dO1;
        }
        global $ultimatemember;
        return $ultimatemember->user;
        goto gx;
        dO1:
        return UM()->user();
        gx:
    }
    private function getUmPwdObj()
    {
        if ($this->isUltimateMemberV2Installed()) {
            goto wD;
        }
        global $ultimatemember;
        return $ultimatemember->password;
        goto Cv;
        wD:
        return UM()->password();
        Cv:
    }
    private function getUmOptions()
    {
        if ($this->isUltimateMemberV2Installed()) {
            goto jJ;
        }
        global $ultimatemember;
        return $ultimatemember->options;
        goto eO;
        jJ:
        return UM()->options();
        eO:
    }
    function isUltimateMemberV2Installed()
    {
        if (function_exists("\x69\163\x5f\160\154\165\x67\151\156\x5f\141\143\x74\x69\x76\145")) {
            goto i6;
        }
        include_once ABSPATH . "\167\160\x2d\141\x64\155\x69\156\x2f\x69\x6e\x63\x6c\x75\x64\145\x73\x2f\x70\x6c\165\147\151\x6e\56\160\150\160";
        i6:
        return is_plugin_active("\165\x6c\x74\151\x6d\141\164\x65\x2d\x6d\145\155\x62\x65\x72\57\x75\154\x74\151\x6d\141\x74\x65\x2d\155\x65\x6d\142\x65\x72\x2e\x70\150\x70");
    }
    private function startOtpTransaction($EN, $Vy, $errors, $TB, $eW, $HL)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto pF;
        }
        $this->sendChallenge($EN, $Vy, $errors, $TB, VerificationType::EMAIL, $eW, $HL);
        goto o6;
        pF:
        $this->sendChallenge($EN, $Vy, $errors, $TB, VerificationType::PHONE, $eW, $HL);
        o6:
    }
    public function miniorange_register_um_script()
    {
        wp_register_script("\x6d\x6f\x75\155\x70\x72", UMPR_URL . "\151\x6e\x63\x6c\165\144\x65\163\57\152\x73\57\x6d\157\x75\x6d\x70\162\x2e\155\x69\156\x2e\x6a\163", array("\x6a\x71\165\x65\162\171"));
        wp_localize_script("\x6d\157\x75\155\x70\x72", "\155\x6f\x75\x6d\x70\x72\166\141\162", array("\x73\x69\x74\x65\125\x52\114" => wp_ajax_url(), "\156\157\156\x63\145" => wp_create_nonce($this->_nonce), "\x62\165\x74\164\x6f\x6e\164\x65\170\164" => mo_($this->_buttonText), "\x69\155\147\x55\x52\114" => MOV_LOADER_URL, "\141\x63\164\x69\157\156" => array("\x73\145\x6e\x64" => $this->_generateOTPAction), "\146\x69\145\154\x64\113\x65\171" => $this->_fieldKey, "\162\145\163\145\164\114\141\142\145\x6c\124\145\170\x74" => UMPasswordResetMessages::showMessage($this->_isOnlyPhoneReset ? UMPasswordResetMessages::RESET_LABEL_OP : UMPasswordResetMessages::RESET_LABEL), "\160\x68\124\x65\x78\x74" => $this->_isOnlyPhoneReset ? mo_("\105\156\164\x65\162\x20\131\157\165\x72\x20\x50\150\x6f\156\145\x20\116\165\155\142\145\162") : mo_("\105\156\x74\x65\162\x20\x59\157\165\x72\40\105\x6d\x61\x69\x6c\54\x20\x55\x73\x65\162\156\141\155\x65\x20\157\162\x20\120\x68\157\156\145\x20\x4e\x75\x6d\x62\145\x72")));
        wp_enqueue_script("\x6d\157\165\155\160\x72");
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
    public function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto om;
        }
        return;
        om:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\165\x6d\137\x70\x72\x5f\x65\x6e\141\142\x6c\x65");
        $this->_buttonText = $this->sanitizeFormPOST("\165\155\137\160\x72\x5f\142\165\164\x74\x6f\156\137\164\x65\170\164");
        $this->_buttonText = $this->_buttonText ? $this->_buttonText : "\122\x65\x73\x65\x74\x20\x50\x61\163\x73\167\157\x72\144";
        $this->_otpType = $this->sanitizeFormPOST("\165\x6d\137\160\162\137\145\156\141\x62\154\145\137\164\171\160\x65");
        $this->_phoneKey = $this->sanitizeFormPOST("\165\155\x5f\x70\x72\x5f\160\150\157\x6e\x65\137\146\x69\145\x6c\144\x5f\153\x65\171");
        $this->_isOnlyPhoneReset = $this->sanitizeFormPOST("\x75\x6d\137\x70\x72\137\157\156\x6c\171\137\160\x68\157\156\145");
        update_umpr_option("\x6f\x6e\154\171\x5f\x70\x68\157\x6e\145\137\x72\145\163\145\164", $this->_isOnlyPhoneReset);
        update_umpr_option("\160\x61\x73\x73\x5f\x65\156\141\142\154\145", $this->_isFormEnabled);
        update_umpr_option("\160\141\163\163\x5f\x62\x75\x74\x74\x6f\x6e\x5f\x74\145\170\164", $this->_buttonText);
        update_umpr_option("\145\x6e\x61\142\154\x65\x64\137\x74\171\160\x65", $this->_otpType);
        update_umpr_option("\x70\x61\163\163\x5f\x70\150\x6f\x6e\x65\x4b\x65\x79", $this->_phoneKey);
    }
    public function getPhoneNumberSelector($sq)
    {
        if (!($this->isFormEnabled() && strcasecmp($this->_otpType, $this->_typePhoneTag) == 0)) {
            goto fo;
        }
        array_push($sq, $this->_phoneFormId);
        fo:
        return $sq;
    }
    public function getIsOnlyPhoneReset()
    {
        return $this->_isOnlyPhoneReset;
    }
}
