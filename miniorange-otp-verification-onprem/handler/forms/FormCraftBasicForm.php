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
class FormCraftBasicForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::FORMCRAFT;
        $this->_typePhoneTag = "\x6d\x6f\137\x66\x6f\x72\155\143\162\141\146\164\137\x70\150\157\x6e\x65\x5f\145\156\x61\x62\154\x65";
        $this->_typeEmailTag = "\x6d\157\x5f\146\x6f\x72\x6d\x63\x72\141\x66\x74\137\x65\155\x61\151\x6c\137\x65\156\x61\x62\154\145";
        $this->_formKey = "\x46\117\122\x4d\103\122\101\x46\x54\x42\101\123\x49\103";
        $this->_formName = mo_("\x46\x6f\162\155\103\x72\141\x66\x74\x20\102\141\x73\151\x63\40\50\x46\162\x65\x65\x20\126\145\162\163\x69\157\156\51");
        $this->_isFormEnabled = get_mo_option("\146\157\162\155\143\x72\x61\146\x74\137\145\x6e\141\x62\154\x65");
        $this->_phoneFormId = array();
        $this->_formDocuments = MoOTPDocs::FORMCRAFT_BASIC_LINK;
        parent::__construct();
    }
    function handleForm()
    {
        if ($this->isFormCraftPluginInstalled()) {
            goto aLt;
        }
        return;
        aLt:
        $this->_otpType = get_mo_option("\x66\x6f\x72\155\x63\162\141\146\164\x5f\x65\156\141\142\x6c\145\x5f\164\171\160\145");
        $this->_formDetails = maybe_unserialize(get_mo_option("\x66\157\162\155\143\x72\141\146\164\x5f\x6f\164\160\137\x65\156\141\x62\x6c\145\144"));
        if (!empty($this->_formDetails)) {
            goto PpJ;
        }
        return;
        PpJ:
        foreach ($this->_formDetails as $O5 => $Xd) {
            array_push($this->_phoneFormId, "\133\144\x61\x74\141\55\x69\x64\x3d" . $O5 . "\x5d\40\x69\x6e\160\x75\164\133\156\141\x6d\145\75" . $Xd["\x70\x68\x6f\156\x65\153\x65\171"] . "\135");
            OEW:
        }
        j7r:
        add_action("\x77\160\x5f\x61\152\x61\170\x5f\x66\x6f\162\155\x63\162\141\x66\164\x5f\x62\x61\x73\151\143\137\x66\x6f\x72\155\x5f\x73\165\142\155\151\164", array($this, "\x76\x61\x6c\x69\144\141\x74\x65\x5f\x66\x6f\x72\x6d\x63\162\141\x66\164\x5f\146\157\x72\155\137\x73\165\142\x6d\151\164"), 1);
        add_action("\167\160\137\141\x6a\141\170\137\x6e\157\x70\x72\x69\x76\x5f\146\x6f\162\155\x63\x72\x61\x66\164\137\142\x61\163\151\143\x5f\x66\157\162\155\137\163\x75\142\x6d\x69\x74", array($this, "\x76\x61\x6c\151\144\x61\164\x65\137\146\x6f\162\155\x63\x72\141\146\x74\137\146\157\162\155\x5f\x73\x75\x62\155\x69\x74"), 1);
        add_action("\x77\160\x5f\x65\156\x71\165\145\165\145\137\x73\x63\162\x69\x70\x74\x73", array($this, "\145\156\x71\165\145\x75\x65\137\x73\x63\x72\151\x70\x74\137\157\156\137\160\141\x67\145"));
        $this->routeData();
    }
    function routeData()
    {
        if (array_key_exists("\x6f\160\x74\151\x6f\156", $_GET)) {
            goto cv8;
        }
        return;
        cv8:
        switch (trim($_GET["\157\x70\x74\x69\157\x6e"])) {
            case "\155\151\156\x69\x6f\162\141\x6e\x67\145\55\x66\157\x72\x6d\143\x72\x61\146\164\x2d\x76\145\162\151\x66\171":
                $this->_handle_formcraft_form($_POST);
                goto hz3;
            case "\x6d\151\156\151\x6f\162\x61\x6e\x67\145\55\x66\157\x72\x6d\x63\162\141\146\164\x2d\146\x6f\162\155\x2d\157\164\x70\55\x65\156\141\x62\154\x65\144":
                wp_send_json($this->isVerificationEnabledForThisForm($_POST["\x66\157\x72\x6d\x5f\x69\144"]));
                goto hz3;
        }
        QCO:
        hz3:
    }
    function _handle_formcraft_form($tT)
    {
        if ($this->isVerificationEnabledForThisForm($_POST["\146\x6f\x72\x6d\x5f\x69\x64"])) {
            goto NWs;
        }
        return;
        NWs:
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) === 0) {
            goto tfN;
        }
        $this->_send_otp_to_email($tT);
        goto upO;
        tfN:
        $this->_send_otp_to_phone($tT);
        upO:
    }
    function _send_otp_to_phone($tT)
    {
        if (array_key_exists("\165\163\145\x72\137\x70\150\x6f\x6e\x65", $tT) && !MoUtility::isBlank($tT["\165\163\x65\x72\x5f\160\150\x6f\x6e\145"])) {
            goto WNq;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        goto qOu;
        WNq:
        SessionUtils::addPhoneVerified($this->_formSessionVar, $tT["\165\163\x65\x72\x5f\160\150\x6f\x6e\x65"]);
        $this->sendChallenge("\x74\x65\163\x74", '', null, trim($tT["\165\163\145\162\x5f\160\x68\x6f\x6e\x65"]), VerificationType::PHONE);
        qOu:
    }
    function _send_otp_to_email($tT)
    {
        if (array_key_exists("\165\x73\145\162\x5f\145\x6d\x61\151\154", $tT) && !MoUtility::isBlank($tT["\165\x73\x65\162\137\x65\155\x61\151\154"])) {
            goto dtX;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        goto qrr;
        dtX:
        SessionUtils::addEmailVerified($this->_formSessionVar, $tT["\x75\x73\145\x72\x5f\x65\x6d\x61\x69\154"]);
        $this->sendChallenge("\x74\x65\x73\x74", $tT["\x75\x73\145\162\x5f\x65\155\141\x69\x6c"], null, $tT["\x75\x73\x65\162\137\145\x6d\141\151\x6c"], VerificationType::EMAIL);
        qrr:
    }
    function validate_formcraft_form_submit()
    {
        $HI = $_POST["\x69\x64"];
        if ($this->isVerificationEnabledForThisForm($HI)) {
            goto WNt;
        }
        return;
        WNt:
        $this->checkIfVerificationNotStarted($HI);
        $p8 = $this->_formDetails[$HI];
        $au = $this->getVerificationType();
        if ($au === VerificationType::PHONE && !SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $_POST[$p8["\160\150\x6f\x6e\145\153\145\x79"]])) {
            goto HVy;
        }
        if ($au === VerificationType::EMAIL && !SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $_POST[$p8["\x65\x6d\x61\x69\x6c\153\x65\x79"]])) {
            goto ppr;
        }
        goto lzt;
        HVy:
        $this->sendJSONErrorMessage(array("\x65\162\x72\x6f\162\x73" => array($this->_formDetails[$HI]["\160\x68\157\x6e\x65\x6b\x65\x79"] => MoMessages::showMessage(MoMessages::PHONE_MISMATCH))));
        goto lzt;
        ppr:
        $this->sendJSONErrorMessage(array("\x65\162\x72\157\162\x73" => array($this->_formDetails[$HI]["\x65\155\141\x69\x6c\x6b\x65\171"] => MoMessages::showMessage(MoMessages::EMAIL_MISMATCH))));
        lzt:
        if (MoUtility::sanitizeCheck($_POST, $p8["\x76\145\x72\x69\x66\171\113\145\171"])) {
            goto Wme;
        }
        $this->sendJSONErrorMessage(array("\x65\x72\x72\x6f\x72\163" => array($this->_formDetails[$HI]["\166\145\x72\151\146\171\x4b\x65\x79"] => MoUtility::_get_invalid_otp_method())));
        Wme:
        SessionUtils::setFormOrFieldId($this->_formSessionVar, $HI);
        $this->validateChallenge($au, NULL, $_POST[$p8["\166\x65\162\x69\x66\x79\x4b\145\171"]]);
    }
    function enqueue_script_on_page()
    {
        wp_register_script("\x66\157\162\155\x63\162\x61\146\x74\x73\x63\x72\151\160\x74", MOV_URL . "\x69\156\143\154\x75\144\145\163\57\152\163\x2f\146\157\x72\x6d\x63\162\x61\x66\164\x62\x61\163\151\x63\x2e\155\x69\156\x2e\152\x73\77\x76\x65\162\163\151\x6f\x6e\x3d" . MOV_VERSION, array("\152\x71\165\x65\x72\171"));
        wp_localize_script("\146\157\162\x6d\143\x72\x61\146\164\x73\x63\x72\x69\160\x74", "\155\x6f\x66\143\166\141\x72\163", array("\151\x6d\x67\x55\x52\x4c" => MOV_LOADER_URL, "\146\157\162\x6d\103\x72\x61\146\x74\x46\x6f\162\x6d\x73" => $this->_formDetails, "\x73\x69\164\145\x55\122\x4c" => site_url(), "\157\164\160\x54\171\160\145" => $this->_otpType, "\x62\165\164\164\157\156\x54\x65\x78\x74" => mo_("\x43\154\x69\x63\x6b\x20\x68\145\x72\145\x20\x74\157\40\x73\145\156\144\40\117\x54\x50"), "\x62\x75\164\x74\x6f\x6e\x54\x69\164\154\x65" => $this->_otpType === $this->_typePhoneTag ? mo_("\x50\154\x65\x61\x73\x65\40\x65\156\x74\145\162\40\141\40\120\x68\x6f\x6e\x65\40\116\x75\x6d\142\145\162\x20\x74\x6f\40\145\156\x61\142\x6c\145\40\x74\150\x69\163\40\x66\151\145\154\144\x2e") : mo_("\x50\x6c\145\141\x73\145\x20\x65\156\164\145\162\x20\141\x20\120\150\157\156\x65\x20\116\x75\155\x62\145\x72\x20\x74\x6f\40\x65\156\141\142\154\x65\x20\164\150\x69\x73\x20\x66\151\x65\x6c\144\56"), "\141\x6a\141\170\165\x72\x6c" => wp_ajax_url(), "\x74\x79\x70\145\x50\150\157\156\x65" => $this->_typePhoneTag, "\143\x6f\x75\156\x74\x72\171\104\x72\157\160" => get_mo_option("\x73\x68\157\x77\137\144\162\157\x70\144\157\167\156\137\157\156\x5f\x66\157\x72\155")));
        wp_enqueue_script("\146\x6f\162\x6d\x63\162\141\x66\x74\163\x63\162\x69\160\x74");
    }
    function isVerificationEnabledForThisForm($HI)
    {
        return array_key_exists($HI, $this->_formDetails);
    }
    function sendJSONErrorMessage($errors)
    {
        $PG["\x66\x61\151\154\145\x64"] = mo_("\x50\x6c\x65\141\x73\145\x20\x63\x6f\x72\x72\x65\143\x74\x20\164\150\145\x20\145\162\162\157\162\x73");
        $PG["\145\x72\162\x6f\162\163"] = $errors;
        echo json_encode($PG);
        die;
    }
    function checkIfVerificationNotStarted($HI)
    {
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto tjV;
        }
        return;
        tjV:
        $Le = MoMessages::showMessage(MoMessages::PLEASE_VALIDATE);
        if ($this->_otpType === $this->_typePhoneTag) {
            goto fqN;
        }
        $this->sendJSONErrorMessage(array("\145\162\162\x6f\x72\163" => array($this->_formDetails[$HI]["\x65\155\141\x69\x6c\x6b\x65\x79"] => $Le)));
        goto xzk;
        fqN:
        $this->sendJSONErrorMessage(array("\x65\x72\x72\x6f\162\163" => array($this->_formDetails[$HI]["\160\150\x6f\x6e\x65\153\x65\171"] => $Le)));
        xzk:
    }
    function handle_failed_verification($wE, $MQ, $TB, $au)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto O_Q;
        }
        return;
        O_Q:
        $tb = SessionUtils::getFormOrFieldId($this->_formSessionVar);
        $this->sendJSONErrorMessage(array("\145\162\x72\157\162\163" => array($this->_formDetails[$tb]["\166\145\x72\151\146\171\113\145\x79"] => MoUtility::_get_invalid_otp_method())));
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
            goto Klm;
        }
        $sq = array_merge($sq, $this->_phoneFormId);
        Klm:
        return $sq;
    }
    function isFormCraftPluginInstalled()
    {
        return MoUtility::getActivePluginVersion("\106\x6f\x72\155\103\162\x61\146\x74") < 3 ? true : false;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto b3H;
        }
        return;
        b3H:
        if ($this->isFormCraftPluginInstalled()) {
            goto nu_;
        }
        return;
        nu_:
        if (array_key_exists("\146\157\x72\x6d\x63\162\141\x66\x74\137\x66\x6f\x72\155", $_POST)) {
            goto HEl;
        }
        return;
        HEl:
        foreach (array_filter($_POST["\146\157\162\x6d\143\x72\x61\x66\164\137\x66\157\162\x6d"]["\146\x6f\x72\x6d"]) as $O5 => $Xd) {
            $p8 = $this->getFormCraftFormDataFromID($Xd);
            if (!MoUtility::isBlank($p8)) {
                goto HtN;
            }
            goto Qx4;
            HtN:
            $Xv = $this->getFieldIDs($_POST, $O5, $p8);
            $form[$Xd] = array("\145\x6d\x61\151\154\153\145\171" => $Xv["\x65\155\141\x69\x6c\x4b\x65\171"], "\160\150\x6f\x6e\145\153\x65\171" => $Xv["\x70\150\157\x6e\145\x4b\x65\x79"], "\166\x65\162\x69\146\171\x4b\x65\171" => $Xv["\x76\145\x72\151\146\171\113\145\171"], "\160\x68\x6f\156\x65\137\163\150\157\167" => $_POST["\x66\157\162\155\143\162\141\x66\164\x5f\x66\x6f\x72\x6d"]["\x70\x68\157\x6e\x65\153\145\171"][$O5], "\x65\155\141\x69\x6c\x5f\x73\x68\x6f\x77" => $_POST["\x66\157\162\x6d\x63\x72\141\146\164\137\146\x6f\x72\155"]["\145\155\141\x69\154\x6b\145\x79"][$O5], "\x76\145\x72\x69\146\171\x5f\x73\150\x6f\167" => $_POST["\x66\x6f\x72\x6d\x63\x72\x61\146\x74\x5f\146\x6f\x72\x6d"]["\166\x65\x72\151\146\171\x4b\x65\171"][$O5]);
            Qx4:
        }
        WhN:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\146\x6f\x72\155\143\x72\x61\146\164\137\x65\x6e\x61\x62\154\x65");
        $this->_otpType = $this->sanitizeFormPOST("\x66\157\x72\155\x63\x72\141\146\x74\137\x65\156\141\142\x6c\145\x5f\164\x79\160\145");
        $this->_formDetails = !empty($form) ? $form : '';
        update_mo_option("\146\157\x72\x6d\143\162\141\146\164\137\x65\156\x61\x62\154\145", $this->_isFormEnabled);
        update_mo_option("\146\157\x72\x6d\143\x72\x61\146\x74\x5f\145\156\141\142\154\145\137\164\x79\x70\x65", $this->_otpType);
        update_mo_option("\x66\x6f\x72\x6d\x63\x72\x61\146\x74\x5f\157\x74\160\x5f\x65\156\x61\x62\154\x65\x64", maybe_serialize($this->_formDetails));
    }
    private function getFieldIDs($tT, $O5, $p8)
    {
        $Xv = array("\x65\155\141\x69\x6c\113\x65\x79" => '', "\x70\x68\x6f\156\x65\x4b\145\x79" => '', "\166\145\162\x69\146\x79\x4b\145\x79" => '');
        if (!empty($tT)) {
            goto vhk;
        }
        return $Xv;
        vhk:
        foreach ($p8 as $form) {
            if (!(strcasecmp($form["\x65\x6c\x65\x6d\145\x6e\164\x44\145\x66\x61\165\154\x74\163"]["\155\141\x69\x6e\137\154\x61\x62\145\154"], $tT["\146\157\162\x6d\x63\162\x61\146\x74\x5f\x66\x6f\162\155"]["\x65\155\x61\x69\x6c\153\x65\x79"][$O5]) === 0)) {
                goto OH_;
            }
            $Xv["\145\155\x61\151\x6c\113\x65\x79"] = $form["\151\144\x65\x6e\x74\x69\146\151\145\x72"];
            OH_:
            if (!(strcasecmp($form["\145\154\145\155\x65\156\164\104\145\146\x61\x75\x6c\164\163"]["\155\141\151\x6e\137\154\141\x62\x65\154"], $tT["\x66\x6f\x72\155\x63\x72\x61\146\164\x5f\146\x6f\x72\x6d"]["\x70\x68\157\x6e\x65\153\x65\x79"][$O5]) === 0)) {
                goto Ng6;
            }
            $Xv["\x70\150\157\156\145\x4b\x65\171"] = $form["\151\x64\145\x6e\x74\151\146\151\145\x72"];
            Ng6:
            if (!(strcasecmp($form["\145\x6c\x65\x6d\145\x6e\164\x44\145\x66\x61\165\154\164\163"]["\x6d\x61\151\156\137\x6c\141\142\x65\x6c"], $tT["\146\x6f\x72\155\x63\162\x61\146\x74\x5f\x66\x6f\x72\155"]["\166\145\x72\151\146\x79\113\x65\x79"][$O5]) === 0)) {
                goto leM;
            }
            $Xv["\166\145\x72\151\x66\x79\x4b\x65\x79"] = $form["\151\x64\145\x6e\164\151\146\151\x65\x72"];
            leM:
            oGx:
        }
        R29:
        return $Xv;
    }
    function getFormCraftFormDataFromID($HI)
    {
        global $wpdb, $forms_table;
        $M5 = $wpdb->get_var("\123\x45\x4c\105\x43\x54\40\155\x65\164\141\137\142\x75\x69\154\144\x65\x72\40\x46\x52\117\115\40{$forms_table}\40\x57\110\x45\122\x45\40\151\x64\x3d{$HI}");
        $M5 = json_decode(stripcslashes($M5), 1);
        return $M5["\146\x69\x65\x6c\144\163"];
    }
}
