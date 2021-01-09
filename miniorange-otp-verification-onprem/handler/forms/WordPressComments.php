<?php


namespace OTP\Handler\Forms;

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
use WP_Comment;
class WordPressComments extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::WPCOMMENT;
        $this->_phoneFormId = "\151\156\160\x75\164\x5b\156\141\x6d\x65\75\x70\x68\x6f\x6e\145\135";
        $this->_formKey = "\127\x50\103\117\115\115\105\116\124";
        $this->_typePhoneTag = "\x6d\157\137\x77\160\143\x6f\155\155\x65\156\164\137\x70\x68\x6f\x6e\x65\x5f\x65\x6e\x61\142\154\145";
        $this->_typeEmailTag = "\x6d\x6f\137\167\160\x63\157\155\x6d\x65\x6e\164\x5f\x65\155\x61\151\x6c\137\x65\156\x61\x62\154\145";
        $this->_formName = mo_("\127\x6f\x72\144\120\x72\x65\163\163\40\103\157\x6d\x6d\145\156\164\x20\106\x6f\162\x6d");
        $this->_isFormEnabled = get_mo_option("\167\x70\x63\x6f\x6d\x6d\x65\156\164\x5f\145\156\141\142\154\145");
        $this->_formDocuments = MoOTPDocs::WP_COMMENT_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\167\160\x63\157\155\155\145\156\x74\x5f\x65\x6e\141\x62\x6c\x65\x5f\x74\x79\x70\145");
        $this->_byPassLogin = get_mo_option("\167\160\x63\157\x6d\x6d\x65\x6e\x74\x5f\145\x6e\x61\142\154\x65\x5f\x66\157\x72\137\154\x6f\x67\x67\x65\144\151\x6e\x5f\165\x73\145\x72\163");
        if (!$this->_byPassLogin) {
            goto wV;
        }
        add_filter("\x63\x6f\x6d\x6d\145\x6e\164\x5f\x66\157\162\155\x5f\144\145\146\141\165\x6c\164\137\146\151\x65\154\144\x73", array($this, "\x5f\x61\x64\144\137\143\x75\163\164\157\155\x5f\146\151\x65\154\144\163"), 99, 1);
        goto bs;
        wV:
        add_action("\143\x6f\155\155\x65\x6e\x74\137\x66\157\162\155\137\154\x6f\147\147\x65\x64\137\151\156\x5f\141\146\x74\145\162", array($this, "\x5f\141\x64\x64\137\163\x63\162\x69\x70\164\163\137\141\x6e\144\137\x61\144\x64\x69\164\x69\157\x6e\141\x6c\x5f\146\x69\x65\154\x64\163"), 1);
        add_action("\x63\157\x6d\x6d\x65\156\x74\x5f\146\157\x72\x6d\137\141\x66\x74\145\162\x5f\146\151\145\x6c\x64\x73", array($this, "\x5f\141\x64\x64\137\163\143\162\x69\x70\164\x73\x5f\x61\156\x64\137\x61\x64\x64\151\x74\x69\x6f\156\141\x6c\137\x66\151\145\x6c\144\x73"), 1);
        bs:
        add_filter("\x70\x72\x65\160\162\x6f\143\145\x73\163\x5f\x63\157\x6d\x6d\x65\x6e\x74", array($this, "\x76\x65\x72\x69\x66\171\137\143\157\x6d\x6d\145\156\164\137\155\145\164\141\x5f\144\141\x74\141"), 1, 1);
        add_action("\143\157\x6d\155\x65\x6e\x74\137\160\157\163\164", array($this, "\x73\x61\x76\145\137\x63\x6f\155\x6d\x65\x6e\164\137\x6d\145\x74\141\137\x64\x61\x74\x61"), 1, 1);
        add_action("\141\x64\x64\x5f\155\145\x74\141\x5f\142\x6f\x78\145\163\x5f\143\x6f\155\x6d\x65\x6e\164", array($this, "\x65\x78\x74\x65\156\x64\x5f\x63\157\x6d\x6d\145\x6e\x74\x5f\141\144\144\137\x6d\x65\x74\x61\137\142\x6f\x78"), 1, 1);
        add_action("\x65\x64\151\x74\x5f\x63\157\x6d\x6d\145\156\x74", array($this, "\x65\170\x74\x65\156\144\137\143\157\155\155\x65\156\164\x5f\x65\144\x69\x74\x5f\x6d\x65\164\141\x66\151\145\154\144\x73"), 1, 1);
        $this->routeData();
    }
    function routeData()
    {
        if (array_key_exists("\157\x70\164\x69\157\x6e", $_GET)) {
            goto yN;
        }
        return;
        yN:
        switch (trim($_GET["\x6f\160\164\x69\x6f\x6e"])) {
            case "\155\x6f\55\143\157\x6d\155\145\x6e\164\x73\55\x76\145\162\151\x66\x79":
                $this->_startOTPVerificationProcess($_POST);
                goto pM;
        }
        L_:
        pM:
    }
    function _startOTPVerificationProcess($QV)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typeEmailTag) === 0 && MoUtility::sanitizeCheck("\x75\x73\x65\162\x5f\145\155\x61\151\x6c", $QV)) {
            goto wY;
        }
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0 && MoUtility::sanitizeCheck("\165\163\145\162\137\x70\150\157\156\145", $QV)) {
            goto CL;
        }
        $Tg = strcasecmp($this->_otpType, $this->_typePhoneTag) === 0 ? MoMessages::showMessage(MoMessages::ENTER_PHONE) : MoMessages::showMessage(MoMessages::ENTER_EMAIL);
        wp_send_json(MoUtility::createJson($Tg, MoConstants::ERROR_JSON_TYPE));
        goto el;
        CL:
        SessionUtils::addPhoneVerified($this->_formSessionVar, trim($QV["\165\x73\145\162\x5f\160\x68\157\x6e\x65"]));
        $this->sendChallenge('', '', null, trim($QV["\x75\x73\145\x72\137\160\150\x6f\x6e\145"]), VerificationType::PHONE);
        el:
        goto TR;
        wY:
        SessionUtils::addEmailVerified($this->_formSessionVar, $QV["\x75\163\145\162\x5f\x65\155\x61\151\154"]);
        $this->sendChallenge('', $QV["\165\x73\145\162\x5f\145\155\x61\151\x6c"], null, $QV["\x75\163\145\x72\x5f\x65\155\141\151\x6c"], VerificationType::EMAIL);
        TR:
    }
    function extend_comment_edit_metafields($HD)
    {
        if (!(!isset($_POST["\145\x78\x74\145\156\x64\137\143\x6f\x6d\155\145\x6e\x74\x5f\165\x70\x64\x61\x74\145"]) || !wp_verify_nonce($_POST["\x65\170\x74\x65\156\x64\137\x63\x6f\155\155\145\x6e\164\x5f\165\160\144\x61\x74\x65"], "\145\170\164\145\x6e\x64\137\x63\x6f\x6d\155\145\156\x74\x5f\x75\160\144\141\164\x65"))) {
            goto cN;
        }
        return;
        cN:
        if (isset($_POST["\160\150\x6f\156\145"]) && $_POST["\160\x68\157\x6e\x65"] != '') {
            goto N3;
        }
        delete_comment_meta($HD, "\x70\x68\157\156\145");
        goto vO;
        N3:
        $l1 = wp_filter_nohtml_kses($_POST["\160\150\157\156\145"]);
        update_comment_meta($HD, "\160\x68\157\x6e\145", $l1);
        vO:
    }
    function extend_comment_add_meta_box()
    {
        add_meta_box("\164\x69\164\x6c\145", mo_("\105\x78\x74\162\x61\x20\x46\151\x65\x6c\x64\x73"), array($this, "\x65\x78\x74\x65\x6e\x64\x5f\143\157\x6d\x6d\x65\x6e\x74\137\155\x65\164\141\x5f\142\x6f\x78"), "\143\157\x6d\x6d\145\x6e\x74", "\x6e\x6f\162\155\141\x6c", "\x68\151\x67\x68");
    }
    function extend_comment_meta_box($Ku)
    {
        $l1 = get_comment_meta($Ku->comment_ID, "\x70\x68\157\x6e\x65", true);
        wp_nonce_field("\x65\x78\164\145\x6e\x64\137\143\x6f\x6d\155\x65\x6e\x74\137\165\160\x64\x61\164\145", "\145\170\164\145\x6e\144\137\x63\157\155\x6d\145\x6e\x74\x5f\165\x70\x64\x61\x74\x65", false);
        echo "\x3c\x74\x61\x62\154\x65\40\143\x6c\x61\163\163\75\x22\x66\x6f\162\x6d\x2d\164\141\x62\154\145\40\x65\144\x69\x74\x63\x6f\155\x6d\x65\156\x74\x22\76\xd\xa\40\40\x20\40\40\40\40\40\x20\40\40\x20\x20\40\40\40\x3c\164\x62\157\x64\x79\76\xd\12\x20\40\x20\x20\40\x20\x20\x20\x20\x20\40\x20\40\40\40\40\x3c\x74\162\x3e\15\xa\40\40\x20\40\x20\40\40\x20\x20\x20\40\x20\40\x20\40\40\x20\40\40\40\74\164\x64\x20\x63\x6c\x61\163\163\75\42\x66\x69\162\163\x74\x22\76\x3c\154\x61\x62\x65\x6c\x20\146\157\162\75\x22\160\150\157\156\x65\42\76" . mo_("\x50\150\157\156\x65") . "\x3a\x3c\57\154\141\x62\x65\154\x3e\x3c\57\164\x64\76\15\12\40\x20\40\40\40\x20\x20\x20\x20\40\x20\x20\40\40\40\40\40\x20\x20\x20\74\x74\144\76\x3c\x69\156\160\x75\164\x20\164\171\160\x65\x3d\42\164\145\170\x74\x22\40\156\141\x6d\x65\x3d\x22\160\150\157\x6e\x65\42\x20\163\151\172\x65\75\42\63\60\x22\x20\x76\141\154\165\x65\75\42" . esc_attr($l1) . "\42\x20\151\x64\x3d\42\x70\150\157\156\145\42\x3e\x3c\x2f\164\144\76\15\12\x20\40\40\x20\40\x20\40\x20\x20\x20\40\40\40\x20\x20\x20\74\57\x74\x72\x3e\15\xa\40\x20\x20\x20\40\40\x20\40\x20\x20\x20\40\40\x20\40\40\x3c\57\x74\142\157\x64\171\x3e\xd\xa\40\x20\40\40\40\40\x20\x20\40\40\40\x20\74\x2f\x74\141\142\154\x65\x3e";
    }
    function verify_comment_meta_data($oa)
    {
        if (!($this->_byPassLogin && is_user_logged_in())) {
            goto nH;
        }
        return $oa;
        nH:
        if (!(!isset($_POST["\x70\150\157\156\145"]) && strcasecmp($this->_otpType, $this->_typePhoneTag) === 0)) {
            goto qy;
        }
        wp_die(MoMessages::showMessage(MoMessages::WPCOMMNENT_PHONE_ENTER));
        qy:
        if (isset($_POST["\166\145\x72\x69\146\171\157\164\x70"])) {
            goto Y4;
        }
        wp_die(MoMessages::showMessage(MoMessages::WPCOMMNENT_VERIFY_ENTER));
        Y4:
        $CN = $this->getVerificationType();
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto pK;
        }
        wp_die(MoMessages::showMessage(MoMessages::PLEASE_VALIDATE));
        pK:
        if (!($CN === VerificationType::EMAIL && !SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $_POST["\x65\155\x61\x69\154"]))) {
            goto hh;
        }
        wp_die(MoMessages::showMessage(MoMessages::EMAIL_MISMATCH));
        hh:
        if (!($CN === VerificationType::PHONE && !SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $_POST["\x70\x68\x6f\x6e\145"]))) {
            goto Qp;
        }
        wp_die(MoMessages::showMessage(MoMessages::PHONE_MISMATCH));
        Qp:
        $this->validateChallenge($CN, NULL, $_POST["\166\145\x72\x69\146\171\x6f\x74\160"]);
        return $oa;
    }
    function _add_scripts_and_additional_fields()
    {
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) === 0)) {
            goto fb;
        }
        echo $this->_getFieldHTML("\x65\x6d\141\151\x6c");
        fb:
        if (!(strcasecmp($this->_otpType, $this->_typePhoneTag) === 0)) {
            goto cQ;
        }
        echo $this->_getFieldHTML("\160\x68\157\x6e\x65");
        cQ:
        echo $this->_getFieldHTML("\166\145\162\151\146\x79\157\x74\x70");
    }
    function _add_custom_fields($K_)
    {
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) === 0)) {
            goto s5;
        }
        $K_["\145\x6d\x61\151\x6c"] = $this->_getFieldHTML("\x65\x6d\x61\151\154");
        s5:
        if (!(strcasecmp($this->_otpType, $this->_typePhoneTag) === 0)) {
            goto Wt;
        }
        $K_["\160\150\x6f\156\x65"] = $this->_getFieldHTML("\160\150\157\156\145");
        Wt:
        $K_["\166\145\x72\x69\x66\x79\x6f\x74\x70"] = $this->_getFieldHTML("\166\x65\x72\x69\146\x79\157\164\160");
        return $K_;
    }
    function _getFieldHTML($Xs)
    {
        $Xh = array("\x65\x6d\141\x69\x6c" => (!is_user_logged_in() && !$this->_byPassLogin ? '' : "\x3c\160\x20\x63\154\x61\x73\x73\75\x22\x63\157\155\155\x65\x6e\x74\x2d\x66\x6f\162\x6d\55\x65\155\141\151\154\x22\x3e" . "\74\154\x61\x62\x65\154\x20\x66\157\162\x3d\42\145\x6d\x61\151\154\42\76" . mo_("\x45\x6d\141\151\154\x20\52") . "\x3c\57\x6c\141\142\145\154\76" . "\74\151\x6e\160\x75\x74\x20\x69\144\x3d\42\145\155\x61\x69\x6c\42\x20\x6e\141\155\145\x3d\x22\145\x6d\x61\x69\x6c\x22\40\x74\171\160\145\75\x22\164\145\x78\164\x22\x20\x73\151\172\x65\75\x22\63\x30\x22\40\40\164\x61\x62\151\156\x64\145\x78\x3d\42\64\42\40\57\76" . "\74\x2f\x70\x3e") . $this->get_otp_html_content("\145\x6d\x61\151\x6c"), "\x70\x68\157\156\145" => "\x3c\x70\40\143\154\141\x73\x73\75\42\143\157\155\155\x65\156\164\55\x66\157\162\x6d\55\145\155\141\x69\x6c\42\76" . "\74\154\x61\142\x65\154\40\x66\157\162\x3d\42\160\x68\x6f\x6e\x65\x22\76" . mo_("\120\150\x6f\156\145\40\x2a") . "\74\x2f\154\x61\142\x65\x6c\76" . "\74\151\156\x70\165\164\x20\x69\144\x3d\x22\160\150\x6f\156\x65\42\40\156\x61\155\x65\75\x22\x70\x68\x6f\x6e\x65\x22\40\x74\171\x70\145\x3d\42\164\x65\170\x74\x22\x20\x73\x69\172\145\x3d\x22\63\60\42\x20\40\164\x61\x62\151\x6e\144\x65\170\75\x22\x34\x22\x20\57\76" . "\74\57\160\x3e" . $this->get_otp_html_content("\x70\x68\157\156\x65"), "\166\x65\x72\151\x66\171\x6f\x74\x70" => "\x3c\160\x20\143\x6c\141\x73\x73\x3d\42\x63\x6f\155\x6d\x65\x6e\x74\55\146\x6f\x72\155\x2d\145\x6d\x61\x69\x6c\x22\76" . "\74\154\x61\142\x65\x6c\x20\146\157\162\75\42\x76\145\162\x69\146\171\157\x74\160\42\76" . mo_("\x56\145\162\x69\146\151\x63\x61\164\151\157\x6e\40\103\157\x64\145") . "\74\x2f\154\141\x62\x65\154\76" . "\x3c\151\x6e\160\165\x74\40\x69\x64\x3d\42\166\145\162\x69\146\x79\x6f\x74\x70\x22\40\x6e\141\155\145\x3d\x22\166\x65\x72\x69\x66\171\157\x74\160\42\x20\164\171\x70\145\x3d\x22\x74\145\x78\x74\42\40\163\151\172\145\75\x22\63\x30\x22\40\40\x74\141\142\x69\156\x64\x65\x78\75\42\64\x22\40\57\76" . "\x3c\57\160\x3e\x3c\142\x72\76");
        return $Xh[$Xs];
    }
    function get_otp_html_content($HI)
    {
        $G0 = "\74\144\151\166\x20\x73\x74\171\x6c\145\75\47\x64\151\x73\x70\154\141\171\72\164\141\142\154\x65\73\x74\x65\x78\164\x2d\141\154\x69\147\x6e\x3a\143\145\156\164\x65\162\x3b\47\76\74\x69\x6d\147\x20\x73\162\143\x3d\x27" . MOV_URL . "\x69\156\x63\154\x75\x64\145\163\57\151\x6d\x61\147\x65\x73\x2f\154\x6f\141\144\x65\162\56\x67\151\x66\x27\76\74\x2f\x64\151\166\76";
        $YE = "\x3c\144\x69\x76\40\163\x74\171\154\145\x3d\x22\155\141\162\x67\151\156\x2d\142\x6f\x74\164\157\x6d\72\x33\x25\x22\x3e\x3c\x69\156\160\165\164\x20\x74\171\160\145\75\42\142\x75\164\x74\x6f\x6e\42\40\143\154\141\x73\163\75\x22\x62\165\x74\x74\157\x6e\40\x61\x6c\x74\x22\40\x73\x74\171\154\145\x3d\42\167\151\144\164\x68\72\61\x30\x30\x25\x22\40\x69\144\x3d\42\155\151\156\x69\157\x72\141\156\x67\x65\x5f\x6f\x74\160\x5f\164\x6f\153\145\156\137\163\x75\x62\155\x69\164\42";
        $YE .= strcasecmp($this->_otpType, $this->_typePhoneTag) === 0 ? "\x74\x69\x74\154\x65\75\42\120\154\145\x61\x73\145\40\105\x6e\164\145\162\40\x61\40\x70\150\157\156\145\40\156\165\155\142\x65\x72\40\164\157\x20\x65\x6e\141\142\154\145\40\164\x68\x69\x73\56\x22\x20" : "\164\x69\x74\x6c\x65\x3d\42\120\x6c\x65\x61\x73\145\x20\x45\x6e\x74\145\162\x20\x61\40\x65\x6d\141\151\x6c\x20\156\x75\x6d\x62\x65\162\x20\164\157\40\145\x6e\141\142\154\x65\40\164\150\151\163\56\x22\x20";
        $YE .= strcasecmp($this->_otpType, $this->_typePhoneTag) === 0 ? "\166\141\154\x75\145\x3d\42\103\154\151\143\x6b\x20\150\145\162\x65\40\x74\157\x20\x76\145\x72\151\146\171\x20\x79\x6f\x75\162\x20\x50\x68\x6f\156\x65\42\x3e" : "\166\141\154\x75\145\x3d\42\103\154\x69\143\153\x20\150\x65\162\145\x20\x74\157\40\166\x65\x72\151\146\x79\x20\x79\x6f\165\162\x20\x45\155\x61\151\x6c\x22\76";
        $YE .= "\x3c\x64\151\166\40\x69\144\x3d\x22\x6d\157\x5f\x6d\x65\x73\x73\141\x67\x65\42\x20\150\x69\x64\x64\145\156\75\x22\x22\x20\163\164\x79\154\145\x3d\x22\142\x61\x63\x6b\x67\x72\x6f\165\156\144\55\143\157\154\157\x72\72\40\x23\x66\67\146\x36\x66\x37\x3b\x70\141\144\x64\151\x6e\x67\72\x20\x31\x65\155\x20\x32\145\155\x20\x31\145\x6d\40\63\x2e\x35\x65\155\73\x22\76\x3c\57\x64\x69\x76\x3e\74\57\x64\151\x76\x3e";
        $YE .= "\74\x73\143\162\x69\160\x74\x3e\152\121\x75\x65\162\x79\50\x64\x6f\x63\x75\155\145\x6e\x74\x29\56\162\145\141\x64\171\50\146\x75\156\x63\164\x69\157\x6e\50\x29\173\44\155\x6f\x3d\x6a\x51\x75\145\x72\171\73\x24\x6d\157\50\42\43\155\151\156\x69\157\162\141\156\x67\145\137\157\164\160\137\x74\x6f\153\x65\x6e\x5f\x73\165\142\155\x69\164\42\x29\56\x63\154\151\143\x6b\x28\146\165\156\x63\x74\151\157\156\50\157\x29\x7b";
        $YE .= "\166\141\x72\40\x65\x3d\44\155\157\50\x22\x69\156\160\165\x74\133\x6e\141\x6d\145\75" . $HI . "\x5d\x22\51\x2e\166\x61\x6c\x28\51\73\x20\44\155\157\50\42\43\x6d\157\137\155\x65\x73\163\141\147\145\x22\x29\56\x65\x6d\x70\164\171\50\x29\54\x24\155\x6f\50\x22\43\x6d\x6f\137\155\145\x73\x73\141\147\x65\42\51\56\x61\160\160\145\156\144\50\42" . $G0 . "\x22\x29\54";
        $YE .= "\44\x6d\x6f\x28\x22\x23\155\157\137\x6d\x65\163\163\141\147\145\x22\51\x2e\163\150\157\167\50\x29\x2c\44\155\157\56\141\152\141\170\50\173\x75\162\154\72\42" . site_url() . "\57\77\x6f\x70\164\x69\157\156\75\x6d\x6f\x2d\x63\x6f\x6d\155\145\156\x74\x73\x2d\x76\x65\162\151\146\x79\42\x2c\x74\x79\x70\145\x3a\x22\120\x4f\123\124\x22\54";
        $YE .= "\144\141\x74\x61\72\x7b\165\x73\145\162\137\160\x68\x6f\156\145\72\145\x2c\x75\163\x65\x72\137\145\155\141\x69\154\x3a\145\175\54\143\x72\x6f\x73\163\104\157\155\141\x69\156\x3a\x21\60\x2c\x64\141\164\x61\x54\x79\x70\x65\x3a\x22\x6a\x73\x6f\156\x22\54\x73\x75\143\143\145\x73\x73\x3a\x66\165\x6e\143\164\x69\x6f\156\50\x6f\x29\173\40\x69\x66\x28\x6f\56\162\x65\163\x75\154\164\75\75\x3d\42\x73\165\x63\x63\145\163\163\x22\x29\173";
        $YE .= "\44\x6d\157\50\42\43\x6d\x6f\x5f\x6d\145\163\x73\141\147\145\x22\51\x2e\145\155\x70\164\171\50\51\54\x24\155\157\50\42\43\x6d\157\137\x6d\145\x73\163\x61\147\x65\42\x29\56\x61\x70\x70\x65\156\x64\x28\x6f\x2e\x6d\145\163\x73\x61\147\x65\51\54\x24\155\157\50\42\43\155\x6f\137\155\x65\163\163\141\147\x65\42\51\x2e\143\x73\163\50\x22\x62\157\162\x64\145\x72\x2d\164\157\x70\x22\x2c\x22\x33\x70\170\40\163\x6f\x6c\151\144\x20\147\162\x65\145\156\42\x29\54";
        $YE .= "\44\155\x6f\50\42\151\x6e\x70\165\164\133\156\x61\x6d\x65\x3d\145\155\x61\151\x6c\137\x76\x65\x72\x69\x66\x79\x5d\42\x29\56\146\157\x63\x75\163\x28\x29\x7d\x65\x6c\163\145\173\x24\155\x6f\x28\x22\43\155\157\x5f\155\x65\x73\x73\141\x67\145\42\51\x2e\145\155\x70\164\171\x28\51\54\44\155\x6f\50\42\x23\x6d\157\137\x6d\x65\x73\163\x61\147\145\42\51\x2e\141\x70\x70\145\156\144\x28\157\56\x6d\145\163\163\141\x67\145\x29\54";
        $YE .= "\x24\x6d\157\50\x22\43\155\x6f\x5f\155\145\x73\163\x61\147\145\x22\x29\56\143\x73\163\x28\x22\142\x6f\x72\x64\x65\162\55\x74\157\160\x22\x2c\x22\63\x70\170\x20\x73\157\x6c\x69\144\x20\x72\x65\144\42\51\54\44\x6d\x6f\50\42\x69\x6e\160\165\164\x5b\x6e\141\155\145\75\160\150\x6f\156\145\x5f\x76\x65\162\x69\146\x79\x5d\x22\51\x2e\x66\157\x63\165\x73\50\51\x7d\40\73\175\54";
        $YE .= "\145\x72\162\x6f\162\72\x66\x75\x6e\x63\x74\x69\x6f\x6e\x28\157\x2c\x65\54\x6e\x29\173\175\x7d\51\x7d\51\73\175\51\73\74\x2f\163\143\162\x69\x70\164\x3e";
        return $YE;
    }
    function save_comment_meta_data($HD)
    {
        if (!(isset($_POST["\160\150\x6f\156\145"]) && $_POST["\x70\150\x6f\x6e\x65"] != '')) {
            goto X1;
        }
        $l1 = wp_filter_nohtml_kses($_POST["\x70\150\157\156\145"]);
        add_comment_meta($HD, "\160\150\x6f\156\145", $l1);
        X1:
    }
    function handle_failed_verification($wE, $MQ, $TB, $au)
    {
        wp_die(MoUtility::_get_invalid_otp_method());
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
            goto VY;
        }
        array_push($sq, $this->_phoneFormId);
        VY:
        return $sq;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto gt;
        }
        return;
        gt:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x77\160\x63\157\155\x6d\x65\x6e\x74\137\x65\x6e\141\142\x6c\x65");
        $this->_otpType = $this->sanitizeFormPOST("\167\160\x63\x6f\155\155\145\156\164\137\x65\x6e\141\x62\154\x65\137\x74\171\x70\x65");
        $this->_byPassLogin = $this->sanitizeFormPOST("\167\x70\143\157\x6d\x6d\145\156\164\x5f\145\x6e\141\x62\154\145\x5f\146\x6f\162\x5f\x6c\x6f\147\147\x65\x64\x69\156\x5f\165\163\145\162\163");
        update_mo_option("\167\160\x63\x6f\155\155\x65\156\164\137\x65\156\x61\142\x6c\145", $this->_isFormEnabled);
        update_mo_option("\167\160\143\x6f\x6d\155\x65\x6e\x74\137\x65\x6e\141\142\154\145\137\x74\x79\x70\x65", $this->_otpType);
        update_mo_option("\167\160\x63\x6f\155\155\145\156\164\137\x65\156\141\142\154\x65\137\146\x6f\162\x5f\x6c\157\147\x67\x65\x64\x69\x6e\x5f\x75\163\145\x72\x73", $this->_byPassLogin);
    }
}
