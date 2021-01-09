<?php


namespace OTP\Objects;

use OTP\Helper\FormList;
use OTP\Helper\FormSessionVars;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
class FormHandler
{
    protected $_typePhoneTag;
    protected $_typeEmailTag;
    protected $_typeBothTag;
    protected $_formKey;
    protected $_formName;
    protected $_otpType;
    protected $_phoneFormId;
    protected $_isFormEnabled;
    protected $_restrictDuplicates;
    protected $_byPassLogin;
    protected $_isLoginOrSocialForm;
    protected $_isAjaxForm;
    protected $_phoneKey;
    protected $_emailKey;
    protected $_buttonText;
    protected $_formDetails;
    protected $_disableAutoActivate;
    protected $_formSessionVar;
    protected $_formSessionVar2;
    protected $_nonce = "\146\157\x72\155\x5f\156\x6f\156\x63\145";
    protected $_txSessionId = FormSessionVars::TX_SESSION_ID;
    protected $_formOption = "\155\x6f\x5f\x63\165\x73\164\x6f\x6d\x65\162\x5f\166\x61\154\151\144\141\x74\151\x6f\156\x5f\x73\x65\x74\x74\x69\156\147\x73";
    protected $_generateOTPAction;
    protected $_validateOTPAction;
    protected $_nonceKey = "\163\x65\143\x75\x72\x69\x74\x79";
    protected $_isAddOnForm = FALSE;
    protected $_formDocuments = array();
    const VALIDATED = "\126\x41\x4c\x49\104\x41\x54\x45\x44";
    const VERIFICATION_FAILED = "\x76\x65\x72\x69\146\151\x63\141\164\x69\157\156\137\146\x61\x69\154\145\144";
    const VALIDATION_CHECKED = "\166\x61\x6c\151\144\x61\x74\x69\157\156\103\150\x65\143\x6b\x65\x64";
    protected function __construct()
    {
        add_action("\x61\x64\x6d\x69\156\137\151\156\151\x74", array($this, "\x68\141\x6e\x64\154\x65\106\x6f\162\155\x4f\160\164\151\x6f\x6e\163"), 2);
        if (!(!MoUtility::micr() || !$this->isFormEnabled())) {
            goto Th;
        }
        return;
        Th:
        add_action("\151\x6e\151\x74", array($this, "\150\141\x6e\x64\x6c\145\106\x6f\162\155"), 1);
        add_filter("\155\x6f\137\160\150\157\x6e\145\137\x64\x72\x6f\x70\x64\157\167\x6e\x5f\x73\145\x6c\x65\x63\x74\x6f\x72", array($this, "\147\x65\164\120\150\157\156\145\x4e\165\x6d\x62\145\x72\123\x65\x6c\x65\143\x74\157\162"), 1, 1);
        if (!(SessionUtils::isOTPInitialized($this->_formSessionVar) || SessionUtils::isOTPInitialized($this->_formSessionVar2))) {
            goto y5;
        }
        add_action("\157\x74\160\137\166\145\x72\151\x66\151\x63\x61\164\x69\x6f\x6e\137\163\x75\x63\x63\145\163\x73\146\165\x6c", array($this, "\x68\141\x6e\144\x6c\x65\137\160\x6f\x73\164\x5f\x76\145\x72\151\146\151\x63\141\x74\x69\157\x6e"), 1, 7);
        add_action("\157\x74\160\x5f\x76\x65\162\x69\146\x69\143\x61\x74\151\x6f\156\137\146\141\151\x6c\x65\x64", array($this, "\x68\141\x6e\144\x6c\x65\x5f\x66\141\x69\154\145\x64\137\x76\x65\162\151\x66\x69\x63\x61\164\151\157\x6e"), 1, 4);
        add_action("\165\x6e\163\145\x74\x5f\x73\x65\x73\163\x69\157\x6e\137\x76\x61\162\151\x61\142\154\145", array($this, "\165\x6e\x73\145\164\x4f\124\x50\123\145\163\x73\151\x6f\x6e\x56\x61\162\x69\x61\142\x6c\x65\x73"), 1, 0);
        y5:
        add_filter("\x69\x73\x5f\141\x6a\x61\170\x5f\146\x6f\x72\155", array($this, "\151\163\137\141\x6a\x61\x78\137\x66\157\x72\155\137\151\156\137\160\x6c\x61\x79"), 1, 1);
        add_filter("\151\163\137\154\157\147\151\156\137\157\x72\x5f\163\157\143\151\141\x6c\x5f\146\x6f\162\x6d", array($this, "\x69\x73\114\157\147\x69\156\x4f\162\x53\x6f\x63\151\141\154\x46\157\x72\x6d"), 1, 1);
        $QR = FormList::instance();
        $QR->add($this->getFormKey(), $this);
    }
    public function isLoginOrSocialForm($is)
    {
        return SessionUtils::isOTPInitialized($this->_formSessionVar) ? $this->getisLoginOrSocialForm() : $is;
    }
    public function is_ajax_form_in_play($hy)
    {
        return SessionUtils::isOTPInitialized($this->_formSessionVar) ? $this->_isAjaxForm : $hy;
    }
    public function sanitizeFormPOST($ju, $s6 = null)
    {
        $ju = ($s6 === null ? "\x6d\157\137\143\x75\163\x74\157\x6d\x65\162\137\x76\x61\x6c\151\x64\x61\x74\x69\157\156\x5f" : '') . $ju;
        return MoUtility::sanitizeCheck($ju, $_POST);
    }
    public function sendChallenge($wE, $MQ, $errors, $TB = null, $Rn = "\x65\155\x61\151\x6c", $eW = '', $HL = null, $P8 = false)
    {
        do_action("\155\x6f\x5f\x67\145\156\145\162\141\x74\145\137\x6f\164\160", $wE, $MQ, $errors, $TB, $Rn, $eW, $HL, $P8);
    }
    public function validateChallenge($au, $Bs = "\x6d\x6f\137\x6f\164\160\137\164\157\153\x65\x6e", $UE = NULL)
    {
        do_action("\x6d\x6f\137\166\141\154\151\x64\x61\164\145\137\x6f\164\160", $au, $Bs, $UE);
    }
    public function basicValidationCheck($Tg)
    {
        if (!($this->isFormEnabled() && MoUtility::isBlank($this->_otpType))) {
            goto u6;
        }
        do_action("\155\157\137\x72\x65\x67\x69\163\164\x72\x61\x74\151\x6f\x6e\x5f\163\150\x6f\167\x5f\155\145\x73\163\141\147\145", MoMessages::showMessage($Tg), MoConstants::ERROR);
        return false;
        u6:
        return true;
    }
    public function getVerificationType()
    {
        $ll = array($this->_typePhoneTag => VerificationType::PHONE, $this->_typeEmailTag => VerificationType::EMAIL, $this->_typeBothTag => VerificationType::BOTH);
        return MoUtility::isBlank($this->_otpType) ? false : $ll[$this->_otpType];
    }
    protected function validateAjaxRequest()
    {
        if (check_ajax_referer($this->_nonce, $this->_nonceKey)) {
            goto K6;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(BaseMessages::INVALID_OP), MoConstants::ERROR_JSON_TYPE));
        die;
        K6:
    }
    protected function ajaxProcessingFields()
    {
        $ll = array($this->_typePhoneTag => array(VerificationType::PHONE), $this->_typeEmailTag => array(VerificationType::EMAIL), $this->_typeBothTag => array(VerificationType::PHONE, VerificationType::EMAIL));
        return $ll[$this->_otpType];
    }
    public function getPhoneHTMLTag()
    {
        return $this->_typePhoneTag;
    }
    public function getEmailHTMLTag()
    {
        return $this->_typeEmailTag;
    }
    public function getBothHTMLTag()
    {
        return $this->_typeBothTag;
    }
    public function getFormKey()
    {
        return $this->_formKey;
    }
    public function getFormName()
    {
        return $this->_formName;
    }
    public function getOtpTypeEnabled()
    {
        return $this->_otpType;
    }
    public function disableAutoActivation()
    {
        return $this->_disableAutoActivate;
    }
    public function getPhoneKeyDetails()
    {
        return $this->_phoneKey;
    }
    public function getEmailKeyDetails()
    {
        return $this->_emailKey;
    }
    public function isFormEnabled()
    {
        return $this->_isFormEnabled;
    }
    public function getButtonText()
    {
        return mo_($this->_buttonText);
    }
    public function getFormDetails()
    {
        return $this->_formDetails;
    }
    public function restrictDuplicates()
    {
        return $this->_restrictDuplicates;
    }
    public function bypassForLoggedInUsers()
    {
        return $this->_byPassLogin;
    }
    public function getisLoginOrSocialForm()
    {
        return (bool) $this->_isLoginOrSocialForm;
    }
    public function getFormOption()
    {
        return $this->_formOption;
    }
    public function isAjaxForm()
    {
        return $this->_isAjaxForm;
    }
    public function isAddOnForm()
    {
        return $this->_isAddOnForm;
    }
    public function getFormDocuments()
    {
        return $this->_formDocuments;
    }
}
