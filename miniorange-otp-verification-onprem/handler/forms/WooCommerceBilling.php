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
class WooCommerceBilling extends FormHandler implements IFormHandler
{
    use Instance;
    function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = FALSE;
        $this->_formSessionVar = FormSessionVars::WC_BILLING;
        $this->_typePhoneTag = "\155\x6f\x5f\167\143\x62\x5f\x70\x68\x6f\x6e\x65\137\145\156\x61\x62\x6c\145";
        $this->_typeEmailTag = "\155\157\x5f\x77\x63\142\137\145\x6d\x61\151\154\x5f\145\x6e\x61\142\154\145";
        $this->_phoneFormId = "\x23\142\151\x6c\x6c\x69\156\147\137\160\150\157\x6e\x65";
        $this->_formKey = "\127\103\x5f\102\x49\x4c\114\x49\x4e\107\137\x46\117\122\115";
        $this->_formName = mo_("\x57\157\157\x63\x6f\x6d\x6d\x65\162\x63\145\x20\x42\151\154\154\151\x6e\147\x20\101\144\x64\x72\x65\x73\x73\40\106\157\162\x6d");
        $this->_isFormEnabled = get_mo_option("\167\x63\x5f\142\151\x6c\x6c\x69\156\x67\x5f\145\156\141\142\154\x65");
        $this->_buttonText = get_mo_option("\167\143\137\x62\151\154\154\151\x6e\147\137\142\x75\x74\164\x6f\x6e\x5f\x74\x65\170\x74");
        $this->_buttonText = !MoUtility::isBlank($this->_buttonText) ? $this->_buttonText : mo_("\x43\154\151\x63\x6b\x20\x48\x65\162\x65\x20\164\x6f\x20\x73\x65\x6e\x64\40\x4f\124\x50");
        $this->_formDocuments = MoOTPDocs::WC_BILLING_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_restrictDuplicates = get_mo_option("\x77\x63\137\x62\x69\x6c\154\x69\156\147\137\x72\145\163\164\x72\151\143\164\x5f\144\165\x70\154\151\143\x61\164\145\163");
        $this->_otpType = get_mo_option("\167\x63\137\x62\x69\x6c\154\151\x6e\147\137\x74\171\160\145\x5f\145\x6e\141\x62\x6c\145\x64");
        if ($this->_otpType === $this->_typeEmailTag) {
            goto pQ;
        }
        add_filter("\x77\157\x6f\x63\x6f\x6d\155\x65\162\143\x65\x5f\160\162\x6f\x63\x65\x73\x73\137\x6d\x79\x61\143\x63\157\x75\x6e\164\x5f\x66\x69\x65\154\x64\137\x62\x69\154\x6c\151\x6e\x67\x5f\x70\x68\x6f\x6e\x65", array($this, "\x5f\x77\143\137\x75\163\145\x72\x5f\141\143\143\x6f\x75\156\x74\x5f\x75\160\x64\141\x74\x65"), 99, 1);
        goto KU;
        pQ:
        add_filter("\167\157\157\x63\157\x6d\x6d\x65\x72\x63\x65\137\x70\162\157\x63\145\x73\163\x5f\155\171\141\143\x63\x6f\165\156\x74\137\x66\151\x65\154\144\x5f\142\151\154\x6c\x69\156\x67\137\x65\x6d\141\x69\x6c", array($this, "\137\167\143\x5f\165\163\x65\162\x5f\141\143\143\x6f\x75\156\164\x5f\x75\x70\x64\141\x74\x65"), 99, 1);
        KU:
    }
    function _wc_user_account_update($Xd)
    {
        $Xd = $this->_otpType === $this->_typePhoneTag ? MoUtility::processPhoneNumber($Xd) : $Xd;
        $qf = $this->getVerificationType();
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $qf)) {
            goto cG;
        }
        $this->unsetOTPSessionVariables();
        return $Xd;
        cG:
        if (!$this->userHasNotChangeData($Xd)) {
            goto Zv;
        }
        return $Xd;
        Zv:
        if (!($this->_restrictDuplicates && $this->isDuplicate($Xd, $qf))) {
            goto IM;
        }
        return $Xd;
        IM:
        MoUtility::initialize_transaction($this->_formSessionVar);
        $this->sendChallenge(null, $_POST["\x62\x69\x6c\154\151\156\x67\137\145\x6d\x61\151\154"], null, $_POST["\142\151\x6c\154\151\x6e\147\137\160\150\x6f\156\x65"], $qf);
        return $Xd;
    }
    function handle_failed_verification($wE, $MQ, $TB, $au)
    {
        $CN = $this->getVerificationType();
        $Ta = $CN === VerificationType::BOTH ? TRUE : FALSE;
        miniorange_site_otp_validation_form($wE, $MQ, $TB, MoUtility::_get_invalid_otp_method(), $CN, $Ta);
    }
    function handle_post_verification($WE, $wE, $MQ, $eW, $TB, $HL, $au)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $au);
    }
    private function userHasNotChangeData($Xd)
    {
        $tT = $this->getUserData();
        return strcasecmp($tT, $Xd) == 0;
    }
    private function getUserData()
    {
        global $wpdb;
        $current_user = wp_get_current_user();
        $O5 = $this->_otpType === $this->_typePhoneTag ? "\142\151\x6c\154\151\156\147\x5f\x70\x68\157\156\x65" : "\142\x69\x6c\x6c\151\x6e\147\x5f\145\155\141\x69\154";
        $V0 = "\x53\105\114\x45\x43\124\x20\155\145\164\141\x5f\166\141\154\165\x65\40\x46\x52\x4f\115\40\x60{$wpdb->prefix}\x75\163\145\162\x6d\x65\164\x61\140\40\x57\x48\105\122\105\40\140\x6d\145\164\141\137\x6b\145\171\x60\x20\75\x20\47{$O5}\x27\x20\x41\x4e\x44\40\140\165\x73\145\x72\x5f\151\144\x60\40\75\x20{$current_user->ID}";
        $KA = $wpdb->get_row($V0);
        return isset($KA) ? $KA->meta_value : '';
    }
    private function isDuplicate($Xd, $qf)
    {
        global $wpdb;
        $O5 = "\142\x69\154\x6c\151\x6e\x67\137" . $qf;
        $KA = $wpdb->get_row("\x53\105\114\x45\x43\124\x20\140\x75\163\x65\x72\x5f\151\144\140\40\x46\x52\x4f\115\40\140{$wpdb->prefix}\165\x73\145\x72\x6d\145\x74\x61\140\x20\127\110\x45\x52\x45\40\x60\155\x65\164\x61\x5f\153\x65\171\x60\x20\x3d\40\47{$O5}\47\40\x41\x4e\x44\40\140\155\x65\164\x61\137\166\141\x6c\x75\x65\x60\40\x3d\40\40\x27{$Xd}\x27");
        if (!isset($KA)) {
            goto yd;
        }
        if ($qf === VerificationType::PHONE) {
            goto mk;
        }
        if (!($qf === VerificationType::EMAIL)) {
            goto Wp;
        }
        wc_add_notice(MoMessages::showMessage(MoMessages::EMAIL_EXISTS), MoConstants::ERROR_JSON_TYPE);
        Wp:
        goto SX;
        mk:
        wc_add_notice(MoMessages::showMessage(MoMessages::PHONE_EXISTS), MoConstants::ERROR_JSON_TYPE);
        SX:
        return TRUE;
        yd:
        return FALSE;
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    public function getPhoneNumberSelector($sq)
    {
        if (!($this->_isFormEnabled && $this->_otpType == $this->_typePhoneTag)) {
            goto rt;
        }
        array_push($sq, $this->_phoneFormId);
        rt:
        return $sq;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto jB;
        }
        return;
        jB:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x77\143\x5f\x62\x69\154\154\x69\156\147\137\x65\156\141\x62\x6c\145");
        $this->_otpType = $this->sanitizeFormPOST("\x77\x63\x5f\x62\x69\154\x6c\x69\156\147\137\164\x79\x70\x65\137\145\156\x61\142\154\145\144");
        $this->_restrictDuplicates = $this->sanitizeFormPOST("\167\143\x5f\142\151\x6c\154\151\x6e\147\x5f\x72\145\163\164\162\151\143\x74\137\144\x75\x70\x6c\151\143\141\164\145\163");
        if (!$this->basicValidationCheck(BaseMessages::WC_BILLING_CHOOSE)) {
            goto jl;
        }
        update_mo_option("\x77\143\137\x62\151\154\154\151\x6e\x67\x5f\x65\x6e\x61\x62\x6c\x65", $this->_isFormEnabled);
        update_mo_option("\x77\143\137\x62\151\x6c\154\x69\156\x67\x5f\164\171\160\x65\x5f\145\x6e\141\x62\x6c\145\x64", $this->_otpType);
        update_mo_option("\167\x63\x5f\x62\x69\154\x6c\x69\156\x67\137\x72\x65\x73\x74\162\151\x63\x74\137\144\x75\x70\154\x69\143\x61\164\x65\163", $this->_restrictDuplicates);
        jl:
    }
}
