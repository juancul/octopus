<?php


namespace OTP\Handler\Forms;

use mysql_xdevapi\Session;
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
class FormCraftPremiumForm extends FormHandler implements IFormHandler
{
    use Instance;
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::FORMCRAFT;
        $this->_typePhoneTag = "\155\157\137\146\x6f\x72\155\x63\162\x61\x66\x74\137\160\150\157\156\x65\x5f\145\x6e\x61\x62\154\145";
        $this->_typeEmailTag = "\155\157\x5f\x66\157\x72\155\x63\x72\x61\146\164\137\x65\x6d\x61\151\154\137\x65\156\141\x62\x6c\145";
        $this->_formKey = "\x46\x4f\122\x4d\103\122\x41\106\124\x50\122\105\x4d\111\x55\115";
        $this->_formName = mo_("\x46\x6f\162\x6d\103\x72\141\x66\164\40\50\x50\162\145\155\151\165\x6d\x20\126\145\x72\163\x69\157\x6e\51");
        $this->_isFormEnabled = get_mo_option("\146\143\x70\162\145\x6d\x69\165\155\x5f\x65\156\141\x62\x6c\145");
        $this->_phoneFormId = array();
        $this->_formDocuments = MoOTPDocs::FORMCRAFT_PREMIUM;
        parent::__construct();
    }
    function handleForm()
    {
        if (MoUtility::getActivePluginVersion("\x46\157\162\155\x43\x72\141\x66\164")) {
            goto ca;
        }
        return;
        ca:
        $this->_otpType = get_mo_option("\x66\143\160\x72\145\155\x69\x75\x6d\x5f\145\156\141\142\x6c\x65\x5f\164\x79\x70\145");
        $this->_formDetails = maybe_unserialize(get_mo_option("\146\143\x70\x72\x65\x6d\x69\x75\155\x5f\157\x74\160\x5f\x65\156\141\142\154\145\144"));
        if (!empty($this->_formDetails)) {
            goto Qf;
        }
        return;
        Qf:
        if ($this->isFormCraftVersion3Installed()) {
            goto wv;
        }
        foreach ($this->_formDetails as $O5 => $Xd) {
            array_push($this->_phoneFormId, "\x2e\156\x66\x6f\162\x6d\x5f\154\151\x20\x69\156\x70\x75\164\133\156\141\155\x65\136\x3d" . $Xd["\160\150\157\156\x65\153\x65\x79"] . "\x5d");
            nl:
        }
        Wy:
        goto VV;
        wv:
        foreach ($this->_formDetails as $O5 => $Xd) {
            array_push($this->_phoneFormId, "\x69\x6e\x70\x75\164\x5b\156\141\x6d\145\x5e\x3d" . $Xd["\160\x68\157\156\x65\153\x65\171"] . "\135");
            cb:
        }
        Rs:
        VV:
        add_action("\x77\x70\137\x61\152\x61\x78\137\x66\157\x72\155\x63\162\x61\x66\x74\x5f\x73\x75\142\155\151\164", array($this, "\166\141\x6c\x69\144\x61\x74\145\137\146\x6f\162\x6d\x63\162\141\x66\164\x5f\146\x6f\x72\x6d\x5f\x73\165\x62\155\x69\x74"), 1);
        add_action("\x77\x70\137\141\x6a\141\x78\x5f\x6e\157\x70\x72\151\166\137\x66\157\162\x6d\x63\162\x61\146\x74\137\x73\x75\142\x6d\151\x74", array($this, "\x76\141\154\x69\x64\x61\x74\145\137\146\157\x72\x6d\143\162\x61\146\164\137\x66\x6f\162\x6d\x5f\x73\x75\x62\155\151\x74"), 1);
        add_action("\167\160\x5f\x61\x6a\141\170\137\x66\x6f\x72\155\x63\x72\141\x66\x74\63\x5f\146\x6f\x72\155\x5f\163\165\142\155\x69\164", array($this, "\x76\x61\154\x69\x64\x61\x74\145\137\x66\x6f\162\155\143\162\141\x66\164\x5f\x66\x6f\x72\155\x5f\x73\165\x62\155\151\x74"), 1);
        add_action("\x77\x70\x5f\x61\x6a\x61\x78\x5f\x6e\157\x70\x72\151\166\137\x66\157\x72\155\143\162\x61\146\164\x33\137\x66\157\162\x6d\x5f\x73\165\x62\x6d\151\164", array($this, "\x76\x61\154\x69\x64\x61\x74\x65\137\x66\157\x72\155\x63\162\141\146\164\137\146\x6f\162\155\137\163\165\142\155\151\164"), 1);
        add_action("\x77\x70\137\x65\x6e\x71\x75\x65\165\145\137\x73\x63\162\151\x70\164\x73", array($this, "\x65\156\161\165\145\x75\x65\137\x73\143\x72\151\x70\x74\x5f\x6f\156\x5f\x70\x61\x67\145"));
        $this->routeData();
    }
    function routeData()
    {
        if (array_key_exists("\x6f\160\x74\x69\x6f\x6e", $_GET)) {
            goto tg;
        }
        return;
        tg:
        switch (trim($_GET["\x6f\x70\x74\x69\157\x6e"])) {
            case "\155\151\156\x69\x6f\162\141\x6e\x67\x65\x2d\x66\x6f\162\x6d\x63\162\x61\146\164\160\162\x65\x6d\151\165\155\55\x76\145\x72\151\x66\x79":
                $this->_handle_formcraft_form($_POST);
                goto SU;
            case "\x6d\x69\156\151\x6f\162\x61\156\147\145\55\146\x6f\162\155\143\162\x61\x66\x74\x70\x72\145\x6d\x69\165\155\x2d\x66\157\x72\x6d\55\x6f\164\160\55\x65\x6e\141\x62\154\145\144":
                wp_send_json($this->isVerificationEnabledForThisForm($_POST["\146\157\x72\155\x5f\x69\x64"]));
                goto SU;
        }
        o9:
        SU:
    }
    function _handle_formcraft_form($tT)
    {
        if ($this->isVerificationEnabledForThisForm($_POST["\146\157\x72\155\137\151\x64"])) {
            goto n5;
        }
        return;
        n5:
        MoUtility::initialize_transaction($this->_formSessionVar);
        if (strcasecmp($this->_otpType, $this->_typePhoneTag) == 0) {
            goto hm;
        }
        $this->_send_otp_to_email($tT);
        goto jm;
        hm:
        $this->_send_otp_to_phone($tT);
        jm:
    }
    function _send_otp_to_phone($tT)
    {
        if (array_key_exists("\165\163\x65\162\x5f\x70\150\x6f\x6e\x65", $tT) && !MoUtility::isBlank($tT["\165\x73\145\x72\137\160\x68\157\x6e\145"])) {
            goto aA;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE), MoConstants::ERROR_JSON_TYPE));
        goto KR;
        aA:
        SessionUtils::addPhoneVerified($this->_formSessionVar, $tT["\x75\163\145\162\137\x70\x68\x6f\x6e\x65"]);
        $this->sendChallenge("\x74\x65\x73\x74", '', null, trim($tT["\165\x73\145\162\x5f\x70\x68\157\156\x65"]), VerificationType::PHONE);
        KR:
    }
    function _send_otp_to_email($tT)
    {
        if (array_key_exists("\x75\x73\x65\x72\x5f\x65\x6d\x61\x69\154", $tT) && !MoUtility::isBlank($tT["\x75\x73\x65\x72\137\145\155\x61\151\154"])) {
            goto YX;
        }
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL), MoConstants::ERROR_JSON_TYPE));
        goto FH;
        YX:
        SessionUtils::addEmailVerified($this->_formSessionVar, $tT["\165\163\x65\x72\x5f\x65\155\x61\151\x6c"]);
        $this->sendChallenge("\x74\x65\x73\x74", $tT["\x75\x73\x65\x72\137\145\x6d\141\x69\x6c"], null, $tT["\165\x73\145\162\x5f\x65\155\x61\151\154"], VerificationType::EMAIL);
        FH:
    }
    function validate_formcraft_form_submit()
    {
        $HI = $_POST["\151\x64"];
        if ($this->isVerificationEnabledForThisForm($HI)) {
            goto ii;
        }
        return;
        ii:
        $p8 = $this->parseSubmittedData($_POST, $HI);
        $this->checkIfVerificationNotStarted($p8);
        $l1 = is_array($p8["\160\x68\x6f\156\x65"]["\166\141\154\165\x65"]) ? $p8["\x70\150\x6f\156\145"]["\166\141\154\x75\145"][0] : $p8["\x70\x68\x6f\x6e\x65"]["\166\x61\154\165\x65"];
        $Vy = is_array($p8["\x65\x6d\x61\x69\154"]["\x76\x61\154\x75\x65"]) ? $p8["\x65\155\x61\x69\154"]["\x76\x61\154\165\x65"][0] : $p8["\145\155\141\151\154"]["\x76\x61\x6c\165\x65"];
        $fk = is_array($p8["\157\164\x70"]["\166\x61\154\165\145"]) ? $p8["\157\x74\x70"]["\166\x61\x6c\165\145"][0] : $p8["\157\164\160"]["\x76\141\x6c\x75\145"];
        $au = $this->getVerificationType();
        if ($au === VerificationType::PHONE && !SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar, $l1)) {
            goto y9;
        }
        if ($au === VerificationType::EMAIL && !SessionUtils::isEmailVerifiedMatch($this->_formSessionVar, $Vy)) {
            goto e0;
        }
        goto lN;
        y9:
        $this->sendJSONErrorMessage(MoMessages::showMessage(MoMessages::PHONE_MISMATCH), $p8["\x70\x68\157\x6e\145"]["\x66\x69\145\154\144"]);
        goto lN;
        e0:
        $this->sendJSONErrorMessage(MoMessages::showMessage(MoMessages::EMAIL_MISMATCH), $p8["\145\x6d\x61\x69\x6c"]["\146\151\x65\154\x64"]);
        lN:
        if (!MoUtility::isBlank($p8["\x6f\x74\160"]["\x76\141\154\165\x65"])) {
            goto yg;
        }
        $this->sendJSONErrorMessage(MoUtility::_get_invalid_otp_method(), $p8["\x6f\164\x70"]["\146\151\x65\x6c\x64"]);
        yg:
        SessionUtils::setFormOrFieldId($this->_formSessionVar, $p8["\x6f\164\160"]["\146\151\x65\154\144"]);
        $this->validateChallenge($au, NULL, $fk);
    }
    function enqueue_script_on_page()
    {
        wp_register_script("\146\143\x70\162\145\155\151\165\x6d\x73\143\162\x69\x70\164", MOV_URL . "\x69\156\x63\154\165\144\145\x73\57\152\163\x2f\x66\x6f\x72\x6d\143\x72\141\x66\164\160\162\x65\155\x69\165\x6d\x2e\155\151\x6e\x2e\152\163\x3f\166\x65\x72\163\151\157\156\75" . MOV_VERSION, array("\x6a\x71\165\x65\162\x79"));
        wp_localize_script("\146\x63\160\162\x65\x6d\x69\165\x6d\163\x63\x72\x69\x70\164", "\155\157\x66\143\160\166\x61\162\x73", array("\151\155\147\x55\x52\114" => MOV_LOADER_URL, "\146\x6f\x72\155\x43\162\141\x66\x74\106\x6f\162\155\x73" => $this->_formDetails, "\x73\x69\164\145\x55\122\x4c" => site_url(), "\157\x74\x70\x54\171\x70\145" => $this->_otpType, "\142\x75\164\164\157\156\x54\145\170\164" => mo_("\103\154\151\143\153\x20\150\x65\x72\145\40\164\x6f\x20\163\145\x6e\144\x20\x4f\124\120"), "\x62\x75\164\x74\157\156\x54\151\164\x6c\x65" => $this->_otpType == $this->_typePhoneTag ? mo_("\120\154\x65\x61\x73\x65\x20\145\156\x74\x65\162\x20\141\x20\120\150\157\x6e\x65\x20\x4e\x75\x6d\142\145\x72\x20\x74\x6f\40\x65\x6e\x61\x62\x6c\x65\x20\164\150\x69\x73\x20\x66\x69\145\x6c\144\x2e") : mo_("\x50\x6c\145\141\x73\145\40\x65\156\164\145\x72\40\141\40\120\x68\x6f\x6e\145\40\x4e\x75\x6d\x62\145\x72\x20\x74\157\x20\145\x6e\141\x62\x6c\145\40\164\150\x69\163\40\x66\x69\x65\154\x64\56"), "\x61\152\x61\x78\x75\162\x6c" => wp_ajax_url(), "\164\171\160\145\120\150\x6f\156\x65" => $this->_typePhoneTag, "\x63\x6f\165\x6e\x74\162\171\x44\162\x6f\x70" => get_mo_option("\x73\150\x6f\167\x5f\144\162\157\160\144\x6f\167\x6e\137\157\x6e\137\146\x6f\162\x6d"), "\x76\145\x72\x73\x69\x6f\x6e\x33" => $this->isFormCraftVersion3Installed()));
        wp_enqueue_script("\x66\143\x70\x72\x65\155\151\165\155\x73\x63\162\x69\x70\x74");
    }
    function parseSubmittedData($post, $HI)
    {
        $tT = array();
        $form = $this->_formDetails[$HI];
        foreach ($post as $O5 => $Xd) {
            if (!(strpos($O5, "\x66\151\x65\154\x64") === FALSE)) {
                goto tZ;
            }
            goto Vx;
            tZ:
            $this->getValueAndFieldFromPost($tT, "\x65\x6d\141\x69\154", $O5, str_replace("\40", "\137", $form["\145\155\x61\x69\x6c\x6b\x65\171"]), $Xd);
            $this->getValueAndFieldFromPost($tT, "\x70\x68\157\x6e\145", $O5, str_replace("\x20", "\x5f", $form["\x70\x68\157\156\145\153\145\x79"]), $Xd);
            $this->getValueAndFieldFromPost($tT, "\157\164\160", $O5, str_replace("\40", "\x5f", $form["\x76\145\162\x69\x66\171\113\145\x79"]), $Xd);
            Vx:
        }
        G2:
        return $tT;
    }
    function getValueAndFieldFromPost(&$tT, $E1, $ec, $fS, $Xd)
    {
        if (!(is_null($tT[$E1]) && strpos($ec, $fS, 0) !== FALSE)) {
            goto nx;
        }
        $tT[$E1]["\166\x61\154\x75\x65"] = $this->isFormCraftVersion3Installed() && $E1 == "\157\164\160" ? $Xd[0] : $Xd;
        $pP = strpos($ec, "\146\x69\145\x6c\144", 0);
        $tT[$E1]["\146\x69\145\154\x64"] = $this->isFormCraftVersion3Installed() ? $ec : substr($ec, $pP, strpos($ec, "\137", $pP) - $pP);
        nx:
    }
    function isVerificationEnabledForThisForm($HI)
    {
        return array_key_exists($HI, $this->_formDetails);
    }
    function sendJSONErrorMessage($errors, $DH)
    {
        if ($this->isFormCraftVersion3Installed()) {
            goto lX;
        }
        $PG["\x65\x72\162\157\x72\163"] = mo_("\120\154\145\141\163\x65\x20\143\157\162\x72\145\143\x74\40\x74\150\x65\x20\x65\162\162\x6f\x72\163\40\x61\156\x64\40\164\x72\171\x20\141\147\141\x69\156");
        $PG[$DH][0] = $errors;
        goto nR;
        lX:
        $PG["\x66\x61\151\x6c\145\144"] = mo_("\x50\x6c\145\x61\163\145\x20\x63\157\x72\x72\x65\143\x74\40\x74\x68\x65\x20\x65\x72\x72\157\162\x73\x20\x61\156\144\40\x74\x72\171\40\x61\147\x61\151\156");
        $PG["\145\162\x72\157\162\x73"][$DH] = $errors;
        nR:
        echo json_encode($PG);
        die;
    }
    function checkIfVerificationNotStarted($p8)
    {
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto J_;
        }
        return;
        J_:
        if ($this->_otpType == $this->_typePhoneTag) {
            goto H3;
        }
        $this->sendJSONErrorMessage(MoMessages::showMessage(MoMessages::PLEASE_VALIDATE), $p8["\145\155\x61\x69\154"]["\x66\151\x65\x6c\144"]);
        goto mC;
        H3:
        $this->sendJSONErrorMessage(MoMessages::showMessage(MoMessages::PLEASE_VALIDATE), $p8["\160\x68\157\156\x65"]["\x66\x69\145\x6c\x64"]);
        mC:
    }
    function handle_failed_verification($wE, $MQ, $TB, $au)
    {
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto kt;
        }
        return;
        kt:
        $K5 = SessionUtils::getFormOrFieldId($this->_formSessionVar);
        $this->sendJSONErrorMessage(MoUtility::_get_invalid_otp_method(), $K5);
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
        if (!($this->isFormEnabled() && $this->_otpType == $this->_typePhoneTag)) {
            goto OI;
        }
        $sq = array_merge($sq, $this->_phoneFormId);
        OI:
        return $sq;
    }
    function getFieldId($tT, $p8)
    {
        foreach ($p8 as $form) {
            if (!($form["\x65\x6c\145\155\x65\x6e\x74\x44\x65\x66\141\165\x6c\x74\x73"]["\x6d\x61\x69\156\x5f\x6c\x61\x62\145\154"] == $tT)) {
                goto yb;
            }
            return $form["\x69\144\145\156\164\x69\x66\x69\145\162"];
            yb:
            yq:
        }
        CO:
        return NULL;
    }
    function getFormCraftFormDataFromID($HI)
    {
        global $wpdb, $ac;
        $M5 = $wpdb->get_var("\x53\105\x4c\105\103\124\40\x6d\x65\164\141\x5f\142\x75\151\154\144\145\162\40\106\x52\x4f\x4d\x20{$ac}\40\127\110\x45\122\105\40\x69\x64\75{$HI}");
        $M5 = json_decode(stripcslashes($M5), 1);
        return $M5["\x66\151\x65\154\144\x73"];
    }
    function isFormCraftVersion3Installed()
    {
        return MoUtility::getActivePluginVersion("\x46\157\x72\x6d\x43\x72\141\x66\x74") == 3 ? true : false;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto YT;
        }
        return;
        YT:
        if (MoUtility::getActivePluginVersion("\106\x6f\162\155\x43\x72\x61\146\164")) {
            goto uk;
        }
        return;
        uk:
        $form = array();
        foreach (array_filter($_POST["\146\x63\x70\x72\x65\x6d\x69\165\x6d\x5f\x66\157\x72\x6d"]["\146\157\x72\155"]) as $O5 => $Xd) {
            !$this->isFormCraftVersion3Installed() ? $this->processAndGetFormData($_POST, $O5, $Xd, $form) : $this->processAndGetForm3Data($_POST, $O5, $Xd, $form);
            Mo:
        }
        d1:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\x66\x63\160\162\145\x6d\x69\x75\155\x5f\145\156\x61\142\x6c\145");
        $this->_otpType = $this->sanitizeFormPOST("\146\143\160\x72\145\155\x69\x75\155\137\145\x6e\141\x62\x6c\x65\137\164\171\x70\145");
        $this->_formDetails = !empty($form) ? $form : '';
        update_mo_option("\146\x63\x70\162\x65\155\151\165\x6d\x5f\x65\156\141\x62\154\145", $this->_isFormEnabled);
        update_mo_option("\x66\143\160\162\x65\x6d\x69\165\x6d\x5f\145\156\141\142\154\x65\x5f\x74\x79\x70\x65", $this->_otpType);
        update_mo_option("\146\x63\160\162\x65\155\x69\165\155\137\157\164\x70\137\145\x6e\141\142\154\145\144", maybe_serialize($this->_formDetails));
    }
    function processAndGetFormData($post, $O5, $Xd, &$form)
    {
        $form[$Xd] = array("\x65\155\x61\x69\x6c\x6b\x65\x79" => str_replace("\40", "\40", $post["\146\143\160\162\x65\155\151\165\x6d\x5f\146\157\x72\x6d"]["\145\x6d\x61\x69\x6c\x6b\x65\171"][$O5]) . "\x5f\145\x6d\x61\151\x6c\x5f\x65\x6d\x61\x69\x6c\137", "\x70\x68\157\x6e\145\153\145\171" => str_replace("\40", "\x20", $post["\x66\143\160\162\145\x6d\x69\x75\x6d\137\x66\157\162\155"]["\x70\x68\157\x6e\145\153\x65\x79"][$O5]) . "\x5f\x74\x65\x78\164\x5f", "\x76\x65\x72\151\x66\171\x4b\x65\x79" => str_replace("\x20", "\x20", $post["\x66\x63\160\162\x65\155\x69\x75\155\137\146\157\x72\155"]["\x76\145\162\151\146\171\x4b\x65\171"][$O5]) . "\137\x74\x65\170\164\137", "\x70\150\x6f\x6e\x65\x5f\163\x68\157\x77" => $post["\146\x63\x70\162\145\x6d\x69\x75\155\137\146\x6f\162\x6d"]["\x70\x68\x6f\x6e\145\x6b\145\x79"][$O5], "\x65\155\141\151\154\137\163\150\157\167" => $post["\146\x63\160\162\145\x6d\x69\x75\155\137\x66\157\x72\155"]["\x65\x6d\141\x69\154\x6b\x65\x79"][$O5], "\x76\145\162\151\x66\171\137\163\x68\157\167" => $post["\x66\143\160\x72\x65\x6d\x69\165\x6d\x5f\x66\157\162\155"]["\166\x65\162\x69\146\x79\x4b\x65\171"][$O5]);
    }
    function processAndGetForm3Data($post, $O5, $Xd, &$form)
    {
        $p8 = $this->getFormCraftFormDataFromID($Xd);
        if (!MoUtility::isBlank($p8)) {
            goto DP;
        }
        return;
        DP:
        $form[$Xd] = array("\145\x6d\141\151\x6c\x6b\x65\x79" => $this->getFieldId($post["\146\x63\x70\x72\x65\155\151\165\155\x5f\x66\157\162\155"]["\x65\155\141\x69\x6c\153\x65\171"][$O5], $p8), "\160\150\x6f\x6e\x65\x6b\x65\171" => $this->getFieldId($post["\146\x63\160\162\x65\x6d\x69\x75\x6d\137\x66\157\x72\155"]["\x70\150\157\156\145\x6b\x65\171"][$O5], $p8), "\x76\145\162\x69\x66\x79\x4b\145\x79" => $this->getFieldId($post["\x66\143\160\x72\x65\x6d\x69\x75\155\x5f\x66\157\162\155"]["\x76\145\162\151\146\x79\113\145\171"][$O5], $p8), "\160\150\157\x6e\x65\137\x73\x68\x6f\x77" => $post["\146\143\x70\162\145\155\x69\x75\x6d\x5f\x66\157\x72\x6d"]["\x70\x68\x6f\156\145\x6b\145\171"][$O5], "\145\155\x61\x69\x6c\137\163\150\157\167" => $post["\x66\143\x70\x72\x65\x6d\151\165\x6d\x5f\146\157\162\155"]["\x65\x6d\x61\x69\x6c\x6b\x65\x79"][$O5], "\x76\x65\162\x69\x66\x79\x5f\163\x68\157\x77" => $post["\x66\143\x70\x72\x65\155\151\x75\155\137\x66\157\162\x6d"]["\x76\145\x72\151\146\x79\113\x65\171"][$O5]);
    }
}
