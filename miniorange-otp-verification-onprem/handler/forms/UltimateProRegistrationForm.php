<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoMessages;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
class UltimateProRegistrationForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::ULTIMATE_PRO;
        $this->_phoneFormId = "\x69\156\160\165\164\x5b\x6e\x61\x6d\145\75\160\x68\157\156\x65\x5d";
        $this->_formKey = "\125\x4c\x54\111\x4d\101\124\105\137\x4d\x45\x4d\x5f\120\122\x4f";
        $this->_typePhoneTag = "\x6d\x6f\137\165\154\x74\x69\x70\162\157\137\160\x68\157\156\x65\137\145\156\x61\142\x6c\145";
        $this->_typeEmailTag = "\155\x6f\137\x75\x6c\164\151\x70\x72\x6f\137\x65\x6d\x61\151\154\x5f\145\156\x61\x62\154\145";
        $this->_formName = mo_("\x55\154\164\151\x6d\x61\164\145\40\115\x65\x6d\142\x65\162\x73\x68\x69\160\x20\x50\162\157\40\x46\x6f\x72\155");
        $this->_isFormEnabled = get_mo_option("\165\154\164\151\160\x72\x6f\137\x65\156\x61\x62\x6c\x65");
        $this->_formDocuments = MoOTPDocs::UM_PRO_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x75\154\164\151\160\162\x6f\137\164\171\160\145");
        add_action("\167\160\x5f\x61\152\141\x78\x5f\x6e\x6f\x70\x72\151\x76\137\151\x68\143\x5f\x63\x68\145\143\x6b\137\x72\145\147\x5f\x66\x69\x65\x6c\x64\x5f\141\x6a\141\170", array($this, "\x5f\165\154\164\151\160\x72\157\x5f\150\141\x6e\x64\154\145\x5f\163\165\x62\155\151\x74"), 1);
        add_action("\x77\160\x5f\141\152\x61\x78\137\151\150\x63\x5f\143\150\x65\143\x6b\x5f\162\x65\x67\137\146\151\x65\x6c\144\137\141\x6a\141\170", array($this, "\x5f\165\154\164\151\x70\x72\157\x5f\x68\x61\156\144\x6c\x65\137\x73\165\x62\155\x69\164"), 1);
        if (!(strcasecmp($this->_otpType, $this->_typePhoneTag) == 0)) {
            goto ZNa;
        }
        add_shortcode("\155\157\x5f\160\150\157\x6e\x65", array($this, "\137\160\150\157\156\145\137\x73\x68\157\x72\164\x63\x6f\x64\145"));
        ZNa:
        if (!(strcasecmp($this->_otpType, $this->_typeEmailTag) == 0)) {
            goto imD;
        }
        add_shortcode("\x6d\x6f\137\145\155\x61\x69\x6c", array($this, "\137\x65\155\141\x69\x6c\x5f\163\150\157\162\x74\x63\x6f\x64\x65"));
        imD:
        $this->routeData();
    }
    function routeData()
    {
        if (array_key_exists("\157\160\x74\151\x6f\x6e", $_GET)) {
            goto oBG;
        }
        return;
        oBG:
        switch (trim($_GET["\x6f\160\x74\x69\157\x6e"])) {
            case "\155\151\156\151\157\162\x61\156\x67\x65\55\165\154\164\151":
                $this->_handle_ulti_form($_POST);
                goto Qps;
        }
        XJM:
        Qps:
    }
    function _ultipro_handle_submit()
    {
        $vs = array("\160\x68\157\156\145", "\x75\x73\145\162\x5f\x65\x6d\x61\x69\x6c", "\166\x61\x6c\151\x64\141\164\145");
        $dc = ihc_return_meta_arr("\x72\x65\x67\x69\x73\x74\x65\162\x2d\x6d\163\147");
        if (isset($_REQUEST["\x74\x79\160\145"]) && isset($_REQUEST["\166\x61\154\165\145"])) {
            goto hHg;
        }
        if (!isset($_REQUEST["\x66\x69\x65\x6c\x64\163\x5f\x6f\x62\x6a"])) {
            goto nED;
        }
        $t5 = $_REQUEST["\146\151\145\154\144\x73\137\157\142\x6a"];
        foreach ($t5 as $M1 => $AX) {
            if (in_array($AX["\x74\x79\x70\x65"], $vs)) {
                goto b_U;
            }
            $cC[] = array("\164\171\x70\145" => $AX["\164\171\x70\145"], "\x76\x61\154\x75\145" => ihc_check_value_field($AX["\164\171\160\x65"], $AX["\166\x61\154\165\x65"], $AX["\163\145\143\x6f\x6e\144\x5f\x76\141\x6c\165\145"], $dc));
            goto eEz;
            b_U:
            $cC[] = $this->validate_umpro_submitted_value($AX["\164\x79\160\145"], $AX["\x76\141\154\x75\145"], $AX["\x73\x65\x63\x6f\156\144\x5f\166\141\x6c\x75\x65"], $dc);
            eEz:
            RtK:
        }
        wVp:
        echo json_encode($cC);
        nED:
        goto Teb;
        hHg:
        echo ihc_check_value_field($_REQUEST["\164\x79\160\x65"], $_REQUEST["\x76\x61\x6c\x75\145"], $_REQUEST["\x73\145\x63\x6f\156\x64\137\x76\141\x6c\x75\x65"], $dc);
        Teb:
        die;
    }
    function _phone_shortcode()
    {
        $G0 = "\x3c\x64\151\x76\x20\x73\164\x79\x6c\x65\75\x27\144\151\163\160\154\141\x79\72\x74\141\x62\x6c\145\73\x74\145\x78\x74\55\x61\154\x69\x67\x6e\72\x63\x65\x6e\x74\145\162\x3b\47\76\x3c\151\155\147\x20\163\x72\x63\x3d\x27" . MOV_URL . "\x69\156\x63\154\x75\144\x65\163\57\151\155\141\147\x65\163\57\154\157\141\144\145\162\x2e\x67\x69\x66\47\76\74\57\x64\x69\166\x3e";
        $dr = "\x3c\144\x69\166\x20\163\x74\171\x6c\x65\75\x27\x6d\141\x72\147\151\156\x2d\164\x6f\x70\72\40\62\45\73\x27\76\74\x62\165\164\164\x6f\x6e\x20\164\171\160\x65\75\x27\x62\165\164\164\157\x6e\47\x20\144\x69\x73\141\142\154\x65\144\75\x27\x64\x69\x73\141\142\x6c\145\144\x27\x20\143\154\141\x73\x73\75\47\142\165\x74\x74\x6f\156\x20\141\154\x74\47\x20\x73\164\171\x6c\x65\x3d\x27\167\x69\144\164\150\72\x31\60\x30\x25\x3b\x68\145\151\x67\x68\x74\72\63\60\x70\x78\73";
        $dr .= "\146\x6f\x6e\164\x2d\146\x61\155\151\154\x79\72\40\122\157\142\157\164\157\x3b\146\x6f\156\x74\55\163\x69\x7a\x65\x3a\x20\61\x32\x70\x78\x20\x21\x69\x6d\x70\157\162\164\141\156\164\73\x27\x20\151\144\75\47\155\x69\x6e\x69\x6f\162\141\x6e\147\x65\x5f\157\164\160\x5f\164\157\153\145\156\x5f\x73\x75\142\x6d\x69\164\47\x20\164\151\164\x6c\145\75\x27\x50\x6c\145\141\163\145\x20\x45\x6e\x74\145\x72\40\x61\156\x20\x70\150\157\156\145\40\164\157\40\x65\x6e\141\x62\154\x65\x20\x74\150\151\163\56\x27\76";
        $dr .= "\x43\154\151\143\x6b\40\x48\145\x72\145\x20\x74\x6f\40\x56\145\162\151\x66\171\40\120\x68\157\156\145\x3c\57\142\x75\x74\x74\x6f\156\76\74\57\x64\151\x76\76\x3c\x64\x69\x76\x20\163\x74\x79\x6c\x65\x3d\x27\155\x61\162\147\x69\156\55\164\x6f\160\x3a\62\x25\47\76\74\144\x69\166\40\x69\144\x3d\47\x6d\x6f\137\x6d\145\x73\163\141\x67\x65\47\40\x68\x69\144\x64\x65\156\x3d\47\x27\x20";
        $dr .= "\x73\164\171\154\x65\x3d\x27\x62\141\143\x6b\147\162\157\165\x6e\144\55\143\x6f\154\157\162\72\40\x23\x66\67\146\66\x66\67\x3b\x70\141\x64\x64\151\156\x67\x3a\40\x31\145\x6d\40\62\145\x6d\x20\61\x65\x6d\x20\x33\x2e\x35\x65\x6d\x3b\47\x27\76\x3c\57\144\151\166\76\74\57\x64\x69\x76\x3e";
        $YE = "\74\x73\143\162\151\160\164\76\x6a\x51\x75\145\162\171\50\144\x6f\143\165\155\x65\156\x74\x29\56\162\x65\x61\x64\x79\x28\x66\x75\x6e\143\164\x69\157\156\50\x29\x7b\x24\x6d\157\75\152\121\165\145\162\x79\73\40\166\x61\x72\40\x64\x69\166\105\x6c\x65\155\x65\156\x74\x20\75\40\x22" . $dr . "\x22\73\40";
        $YE .= "\x24\155\157\50\42\151\x6e\x70\x75\164\x5b\156\141\x6d\145\x3d\160\150\x6f\156\145\135\x22\51\x2e\143\150\141\156\147\145\x28\146\165\156\x63\164\151\157\156\x28\x29\173\x20\x69\146\50\x21\x24\155\x6f\x28\164\x68\x69\x73\51\56\166\141\x6c\x28\51\51\173\x20\x24\155\x6f\50\x22\x23\155\x69\156\151\157\162\x61\x6e\x67\145\137\157\164\x70\x5f\x74\x6f\153\145\x6e\x5f\x73\x75\142\x6d\x69\x74\x22\x29\56\160\x72\x6f\x70\x28\x22\x64\x69\163\x61\x62\x6c\x65\x64\42\54\x74\162\165\145\x29\x3b";
        $YE .= "\40\x7d\145\x6c\x73\145\173\x20\44\x6d\157\x28\42\43\155\x69\x6e\151\x6f\162\141\156\147\145\x5f\x6f\164\x70\x5f\x74\x6f\x6b\x65\156\x5f\163\165\x62\x6d\x69\x74\x22\51\56\160\x72\157\160\x28\42\144\x69\x73\141\142\x6c\145\144\42\54\x66\x61\154\163\x65\x29\x3b\x20\x7d\x20\x7d\51\x3b";
        $YE .= "\40\x24\x6d\x6f\x28\x64\x69\166\x45\x6c\145\155\145\x6e\164\51\56\151\x6e\163\x65\x72\164\x41\x66\x74\145\162\50\x24\x6d\x6f\x28\x20\42\151\x6e\x70\x75\164\133\156\141\x6d\x65\75\x70\150\x6f\156\x65\135\x22\51\x29\x3b\x20\x24\155\157\50\x22\x23\155\x69\x6e\151\157\x72\141\x6e\x67\x65\137\157\164\x70\x5f\x74\x6f\x6b\145\156\137\x73\165\142\x6d\x69\x74\42\x29\x2e\x63\154\x69\143\153\x28\146\165\x6e\143\164\151\157\156\50\157\x29\173\40";
        $YE .= "\x76\141\162\40\145\75\44\x6d\157\50\42\x69\156\x70\x75\x74\x5b\x6e\x61\x6d\x65\x3d\x70\x68\x6f\156\x65\135\42\51\x2e\x76\141\x6c\50\x29\73\40\44\155\x6f\x28\x22\43\155\x6f\x5f\x6d\145\163\x73\141\147\x65\x22\51\56\145\x6d\x70\x74\x79\50\51\54\x24\x6d\157\50\x22\43\x6d\x6f\x5f\x6d\x65\163\163\141\147\145\x22\51\x2e\141\x70\160\x65\x6e\x64\x28\42" . $G0 . "\42\x29\x2c";
        $YE .= "\44\x6d\157\x28\x22\x23\155\157\x5f\x6d\x65\163\x73\x61\147\145\42\51\x2e\x73\x68\x6f\x77\x28\x29\x2c\x24\155\157\x2e\141\152\141\170\50\x7b\x75\162\x6c\x3a\x22" . site_url() . "\x2f\x3f\x6f\160\164\151\x6f\x6e\75\x6d\x69\156\151\x6f\162\x61\156\147\x65\x2d\x75\154\164\x69\x22\x2c\x74\x79\x70\145\x3a\42\120\x4f\123\x54\x22\x2c";
        $YE .= "\144\x61\164\141\x3a\x7b\x75\163\x65\162\x5f\x70\150\x6f\x6e\x65\72\x65\x7d\x2c\143\162\157\163\163\104\x6f\x6d\x61\151\x6e\x3a\x21\x30\x2c\x64\x61\x74\x61\x54\x79\160\145\72\x22\152\163\x6f\x6e\42\54\x73\165\x63\143\145\x73\x73\x3a\146\165\156\x63\164\x69\x6f\156\50\157\51\173\x20\x69\146\x28\x6f\x2e\x72\x65\163\165\154\x74\75\75\42\163\x75\x63\143\x65\x73\x73\42\51\173\44\x6d\157\x28\42\x23\x6d\157\x5f\155\145\163\163\141\x67\145\x22\x29\56\x65\155\x70\x74\171\50\x29\54";
        $YE .= "\44\x6d\x6f\50\42\x23\x6d\x6f\x5f\x6d\145\163\x73\x61\x67\145\42\x29\56\x61\160\160\145\156\x64\x28\157\56\x6d\145\x73\x73\141\147\145\51\x2c\x24\x6d\157\50\x22\43\155\x6f\x5f\155\x65\x73\163\x61\147\x65\x22\51\56\x63\x73\163\x28\42\142\x6f\x72\x64\145\162\x2d\x74\x6f\160\42\54\42\x33\x70\170\40\163\x6f\x6c\x69\144\40\147\x72\145\145\156\x22\x29\54";
        $YE .= "\44\155\x6f\50\x22\x69\x6e\x70\x75\164\x5b\x6e\x61\155\145\x3d\145\155\x61\x69\x6c\137\166\x65\162\151\x66\171\x5d\42\51\x2e\x66\157\x63\165\163\50\51\175\x65\x6c\x73\x65\x7b\44\155\x6f\50\42\43\155\x6f\137\155\145\163\163\x61\147\145\42\x29\x2e\145\155\160\164\x79\50\51\x2c\44\155\157\x28\42\x23\x6d\x6f\137\x6d\145\x73\x73\x61\147\145\42\x29\x2e\x61\160\x70\x65\x6e\x64\50\157\x2e\x6d\x65\x73\163\141\x67\145\x29\54";
        $YE .= "\x24\x6d\x6f\50\x22\x23\155\157\x5f\x6d\145\163\163\x61\x67\x65\x22\x29\56\x63\163\x73\x28\42\142\x6f\162\x64\x65\x72\55\x74\x6f\160\x22\x2c\42\x33\x70\170\40\163\x6f\154\151\144\x20\162\x65\x64\42\51\54\x24\x6d\157\50\x22\151\x6e\x70\x75\x74\133\156\141\155\145\75\160\x68\157\156\145\137\x76\x65\x72\x69\146\171\x5d\42\51\56\x66\157\143\165\163\x28\x29\x7d\40\73\x7d\x2c";
        $YE .= "\145\x72\x72\157\162\x3a\146\165\156\x63\x74\x69\157\x6e\x28\x6f\54\x65\54\156\x29\173\x7d\175\x29\175\x29\x3b\175\51\73\x3c\x2f\163\x63\162\x69\x70\164\76";
        return $YE;
    }
    function _email_shortcode()
    {
        $G0 = "\x3c\144\x69\x76\40\x73\164\171\x6c\x65\x3d\x27\144\x69\x73\160\154\x61\171\x3a\x74\141\142\x6c\145\x3b\x74\145\170\164\55\141\154\151\x67\156\72\143\145\x6e\164\x65\x72\x3b\47\x3e\74\x69\155\147\40\x73\x72\x63\x3d\47" . MOV_URL . "\151\x6e\143\x6c\x75\x64\x65\x73\57\x69\x6d\141\x67\x65\x73\x2f\x6c\x6f\x61\144\145\162\56\147\151\x66\47\x3e\x3c\x2f\144\x69\166\x3e";
        $dr = "\x3c\x64\x69\166\40\163\164\171\x6c\x65\x3d\47\155\x61\x72\147\151\156\55\164\157\x70\72\40\62\x25\73\47\x3e\74\x62\165\x74\164\x6f\156\x20\x74\x79\160\145\75\x27\142\165\164\x74\x6f\156\47\40\144\x69\163\x61\142\x6c\145\144\75\x27\x64\x69\163\x61\x62\154\x65\144\x27\x20\x63\154\141\x73\x73\x3d\47\142\165\164\x74\x6f\x6e\x20\141\x6c\x74\47\x20";
        $dr .= "\163\164\171\x6c\145\75\47\167\151\x64\164\x68\72\x31\x30\x30\45\x3b\150\x65\x69\147\x68\164\72\x33\x30\x70\170\73\x66\157\156\164\55\x66\x61\x6d\x69\154\x79\72\x20\122\x6f\142\x6f\164\x6f\x3b\x66\x6f\156\x74\55\x73\x69\x7a\145\x3a\40\61\62\x70\170\x20\x21\151\x6d\x70\x6f\162\x74\141\x6e\164\x3b\47\40\151\144\x3d\x27\155\151\x6e\x69\x6f\162\141\156\x67\x65\x5f\157\164\160\x5f\164\x6f\153\x65\156\137\163\165\x62\x6d\x69\164\x27\40";
        $dr .= "\164\151\x74\154\145\75\47\x50\154\x65\141\x73\x65\40\105\156\164\x65\x72\x20\141\x6e\40\x65\x6d\141\151\x6c\40\x74\x6f\40\145\x6e\x61\x62\x6c\x65\x20\x74\150\x69\163\56\x27\76\x43\154\151\x63\x6b\40\x48\145\162\145\40\164\157\x20\126\x65\162\x69\146\x79\40\171\x6f\x75\x72\40\145\x6d\x61\151\x6c\x3c\x2f\x62\165\x74\164\157\156\x3e\x3c\57\144\x69\x76\x3e\74\x64\x69\166\x20\163\x74\x79\154\145\75\x27\x6d\x61\x72\x67\151\x6e\55\164\x6f\x70\72\62\45\47\x3e";
        $dr .= "\x3c\x64\151\x76\x20\x69\x64\x3d\47\x6d\x6f\x5f\x6d\145\163\x73\x61\x67\x65\47\40\x68\x69\144\144\x65\x6e\x3d\47\47\x20\x73\164\x79\x6c\x65\75\47\142\x61\x63\x6b\147\162\157\165\x6e\144\55\x63\157\x6c\x6f\162\72\40\x23\146\x37\146\x36\x66\x37\73\160\141\144\144\151\156\147\x3a\40\61\145\155\x20\x32\145\x6d\40\x31\145\155\x20\x33\56\65\145\x6d\73\x27\x27\x3e\74\57\x64\151\x76\76\74\57\x64\x69\x76\x3e";
        $YE = "\74\x73\143\162\x69\160\164\x3e\x6a\x51\x75\145\x72\x79\50\x64\x6f\143\165\155\x65\156\164\x29\x2e\x72\x65\x61\144\171\x28\146\165\156\143\164\x69\157\x6e\x28\51\x7b\x24\x6d\157\75\x6a\x51\x75\x65\162\x79\x3b\40\166\x61\x72\40\x64\151\x76\x45\x6c\x65\x6d\145\156\164\x20\75\40\42" . $dr . "\42\x3b\x20";
        $YE .= "\44\x6d\x6f\50\x22\x69\x6e\160\165\164\133\x6e\x61\155\145\75\x75\x73\x65\x72\x5f\x65\155\x61\x69\154\135\x22\x29\x2e\143\x68\x61\x6e\147\145\50\146\x75\x6e\143\x74\x69\x6f\x6e\x28\51\x7b\x20\151\x66\50\x21\44\x6d\x6f\x28\164\x68\x69\x73\x29\56\x76\x61\154\50\x29\x29\x7b\x20";
        $YE .= "\x24\x6d\157\x28\42\x23\155\x69\156\151\x6f\162\x61\156\x67\145\x5f\157\x74\160\137\x74\157\x6b\x65\156\x5f\163\165\142\x6d\151\164\x22\x29\x2e\x70\162\x6f\x70\x28\x22\x64\x69\x73\x61\142\154\x65\144\42\54\164\x72\165\x65\51\73\40\175\x65\x6c\x73\145\x7b\x20";
        $YE .= "\44\x6d\x6f\50\42\x23\155\x69\x6e\x69\x6f\162\x61\156\147\145\137\157\x74\160\137\x74\157\x6b\x65\156\x5f\163\x75\x62\x6d\151\x74\x22\x29\x2e\x70\x72\157\x70\50\x22\x64\x69\163\x61\142\154\145\144\42\x2c\146\x61\154\x73\x65\x29\73\x20\175\x20\175\51\73\x20";
        $YE .= "\44\155\157\x28\144\x69\166\105\x6c\x65\155\145\x6e\x74\x29\56\151\x6e\x73\145\x72\164\101\146\x74\x65\162\50\44\x6d\x6f\x28\x20\42\151\x6e\160\165\164\x5b\156\x61\x6d\x65\x3d\x75\x73\x65\162\137\145\x6d\x61\x69\154\x5d\42\51\x29\x3b\40\x24\x6d\157\x28\x22\x23\155\151\x6e\x69\157\162\141\x6e\147\145\137\157\x74\160\137\164\157\153\x65\156\x5f\163\x75\x62\x6d\151\x74\42\51\56\143\154\x69\143\153\x28\x66\165\x6e\143\x74\151\x6f\156\x28\x6f\51\x7b\40";
        $YE .= "\166\x61\x72\x20\145\x3d\44\x6d\157\x28\x22\151\156\160\165\x74\133\156\141\155\x65\x3d\165\x73\145\x72\x5f\145\x6d\x61\x69\154\x5d\x22\51\x2e\x76\141\x6c\50\51\x3b\x20\x24\x6d\157\x28\x22\x23\x6d\157\137\x6d\145\163\x73\141\147\x65\42\51\x2e\x65\x6d\x70\164\x79\50\51\x2c\x24\155\x6f\50\42\43\x6d\157\137\x6d\145\163\163\x61\x67\145\42\51\56\x61\160\160\145\156\144\50\x22" . $G0 . "\42\51\54";
        $YE .= "\x24\x6d\x6f\x28\x22\43\155\x6f\137\155\x65\x73\x73\x61\x67\x65\x22\x29\56\163\x68\x6f\167\x28\x29\x2c\x24\x6d\x6f\x2e\141\152\141\170\50\x7b\x75\x72\x6c\72\x22" . site_url() . "\x2f\77\157\x70\x74\x69\157\x6e\75\x6d\x69\156\151\x6f\x72\141\156\x67\x65\55\x75\154\x74\151\x22\54\x74\171\160\x65\72\x22\x50\x4f\x53\124\x22\x2c\x64\x61\x74\141\x3a\173\165\163\145\162\x5f\145\155\141\x69\x6c\72\x65\x7d\54\x63\x72\x6f\163\x73\104\x6f\155\141\x69\156\x3a\x21\x30\x2c\x64\x61\x74\141\124\x79\x70\x65\x3a\x22\x6a\x73\x6f\x6e\x22\54\x73\x75\143\143\x65\x73\x73\72\x66\x75\156\x63\164\x69\x6f\156\50\x6f\51\173\x20\151\146\x28\x6f\56\162\145\x73\x75\154\164\75\75\42\x73\x75\x63\x63\x65\x73\x73\x22\x29\173\44\155\x6f\x28\42\x23\x6d\x6f\137\155\145\x73\163\x61\x67\x65\x22\51\x2e\145\x6d\160\164\171\x28\x29\x2c\x24\155\x6f\x28\42\43\155\x6f\x5f\155\x65\x73\x73\x61\147\x65\x22\x29\x2e\141\160\x70\145\x6e\144\x28\x6f\x2e\x6d\x65\163\x73\141\147\x65\x29\x2c\x24\155\157\x28\42\x23\x6d\157\x5f\x6d\145\x73\x73\141\x67\x65\42\x29\x2e\x63\x73\163\50\x22\x62\x6f\x72\144\145\x72\55\164\157\x70\x22\x2c\x22\63\160\x78\x20\163\x6f\154\x69\x64\x20\x67\162\x65\x65\x6e\42\x29\x2c\44\x6d\x6f\50\42\x69\156\x70\165\164\133\156\141\x6d\145\75\145\155\x61\x69\x6c\137\x76\x65\x72\151\x66\x79\x5d\42\x29\56\x66\x6f\x63\x75\x73\x28\x29\175\145\154\163\x65\173\44\x6d\157\x28\x22\x23\155\157\137\x6d\x65\163\x73\141\x67\145\x22\x29\56\145\155\160\164\171\50\51\54\44\155\x6f\x28\42\x23\x6d\x6f\x5f\155\x65\163\163\141\x67\x65\42\x29\x2e\141\x70\160\145\x6e\x64\50\157\x2e\155\145\163\163\141\x67\145\x29\x2c\44\155\157\50\x22\x23\x6d\157\x5f\155\x65\163\x73\x61\147\145\x22\x29\x2e\143\x73\x73\x28\42\142\x6f\x72\x64\x65\162\55\164\157\160\42\x2c\x22\x33\160\x78\40\x73\157\x6c\151\144\x20\162\145\144\42\x29\x2c\44\155\x6f\x28\42\151\x6e\160\165\x74\133\156\141\x6d\145\x3d\160\150\157\x6e\145\x5f\166\145\162\x69\146\x79\x5d\42\51\x2e\146\157\143\165\163\x28\x29\175\x20\73\175\54\145\162\x72\x6f\162\x3a\146\x75\x6e\143\x74\x69\157\156\50\x6f\x2c\x65\x2c\x6e\51\173\175\x7d\x29\175\x29\73\175\x29\x3b\x3c\x2f\163\x63\162\151\160\164\76";
        return $YE;
    }
    function _handle_ulti_form($tT)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto EtC;
        }
        SessionUtils::addEmailVerified($this->_formSessionVar, $tT["\165\x73\145\x72\x5f\x65\155\141\x69\154"]);
        $this->sendChallenge('', $tT["\165\x73\x65\162\137\x65\155\141\x69\x6c"], null, null, VerificationType::EMAIL);
        goto uTr;
        EtC:
        SessionUtils::addPhoneVerified($this->_formSessionVar, $tT["\x75\x73\145\x72\x5f\x70\x68\157\x6e\x65"]);
        $this->sendChallenge('', null, null, $tT["\x75\x73\145\162\137\x70\150\157\x6e\x65"], VerificationType::PHONE);
        uTr:
    }
    function validate_umpro_submitted_value($qf, $Xd, $PP, $dc)
    {
        $x2 = array();
        switch ($qf) {
            case "\160\150\157\156\145":
                $this->processPhone($x2, $qf, $Xd, $PP, $dc);
                goto ywo;
            case "\165\163\145\162\x5f\145\155\141\151\x6c":
                $this->processEmail($x2, $qf, $Xd, $PP, $dc);
                goto ywo;
            case "\166\141\154\151\144\141\164\x65":
                $this->processOTPEntered($x2, $qf, $Xd, $PP, $dc);
                goto ywo;
        }
        LoX:
        ywo:
        return $x2;
    }
    function processPhone(&$x2, $qf, $Xd, $PP, $dc)
    {
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) != 0) {
            goto GTV;
        }
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto JX_;
        }
        if (!SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $Xd)) {
            goto VUn;
        }
        $x2 = array("\164\x79\x70\145" => $qf, "\x76\x61\x6c\x75\x65" => ihc_check_value_field($qf, $Xd, $PP, $dc));
        goto OGC;
        VUn:
        $x2 = array("\164\171\160\145" => $qf, "\166\141\154\x75\x65" => MoMessages::showMessage(MoMessages::PHONE_MISMATCH));
        OGC:
        goto EdB;
        JX_:
        $x2 = array("\x74\x79\160\145" => $qf, "\x76\x61\154\x75\145" => MoMessages::showMessage(MoMessages::PLEASE_VALIDATE));
        EdB:
        goto w3p;
        GTV:
        $x2 = array("\x74\171\x70\145" => $qf, "\166\141\154\x75\x65" => ihc_check_value_field($qf, $Xd, $PP, $dc));
        w3p:
    }
    function processEmail(&$x2, $qf, $Xd, $PP, $dc)
    {
        if (strcasecmp($this->_otpType, $this->_typeEmailTag) != 0) {
            goto KDl;
        }
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto uVA;
        }
        if (!SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $Xd)) {
            goto DEj;
        }
        $x2 = array("\164\x79\x70\145" => $qf, "\x76\x61\x6c\165\145" => ihc_check_value_field($qf, $Xd, $PP, $dc));
        goto E8n;
        DEj:
        $x2 = array("\164\171\160\x65" => $qf, "\166\141\x6c\x75\x65" => MoMessages::showMessage(MoMessages::EMAIL_MISMATCH));
        E8n:
        goto XLG;
        uVA:
        $x2 = array("\x74\x79\x70\145" => $qf, "\166\x61\154\x75\145" => MoMessages::showMessage(MoMessages::PLEASE_VALIDATE));
        XLG:
        goto iS_;
        KDl:
        $x2 = array("\x74\171\x70\x65" => $qf, "\x76\x61\x6c\165\145" => ihc_check_value_field($qf, $Xd, $PP, $dc));
        iS_:
    }
    function processOTPEntered(&$x2, $qf, $Xd, $PP, $dc)
    {
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto Bhg;
        }
        $this->validateAndProcessOTP($x2, $qf, $Xd);
        goto Bp7;
        Bhg:
        $x2 = array("\164\x79\x70\x65" => $qf, "\x76\141\x6c\x75\x65" => MoMessages::showMessage(MoMessages::PLEASE_VALIDATE));
        Bp7:
    }
    function validateAndProcessOTP(&$x2, $qf, $UE)
    {
        $CN = $this->getVerificationType();
        $this->validateChallenge($CN, NULL, $UE);
        if (!SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $CN)) {
            goto Uvw;
        }
        $this->unsetOTPSessionVariables();
        $x2 = array("\164\171\160\x65" => $qf, "\166\x61\x6c\165\x65" => 1);
        goto TtD;
        Uvw:
        $x2 = array("\x74\x79\160\x65" => $qf, "\166\x61\x6c\165\145" => MoUtility::_get_invalid_otp_method());
        TtD:
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
            goto pI0;
        }
        array_push($sq, $this->_phoneFormId);
        pI0:
        return $sq;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto MhR;
        }
        return;
        MhR:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\165\x6c\x74\x69\160\162\157\x5f\x65\x6e\141\x62\x6c\x65");
        $this->_otpType = $this->sanitizeFormPOST("\165\x6c\x74\151\160\162\157\x5f\164\171\160\145");
        update_mo_option("\x75\x6c\164\x69\x70\x72\x6f\137\145\x6e\141\x62\x6c\145", $this->_isFormEnabled);
        update_mo_option("\165\154\164\151\x70\x72\157\137\x74\x79\160\x65", $this->_otpType);
    }
}
