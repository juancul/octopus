<?php


namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoPHPSessions;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Traits\Instance;
use ReflectionException;
use WC_Emails;
use WC_Social_Login_Provider_Profile;
class WooCommerceSocialLoginForm extends FormHandler implements IFormHandler
{
    use Instance;
    private $_oAuthProviders = array("\x66\141\143\x65\142\157\x6f\153", "\x74\167\151\164\164\145\x72", "\147\157\x6f\147\154\145", "\141\x6d\x61\172\157\156", "\x6c\x69\156\153\145\144\x49\156", "\x70\x61\x79\x70\141\x6c", "\151\156\163\164\x61\147\x72\141\x6d", "\x64\151\x73\161\165\163", "\x79\x61\x68\157\x6f", "\x76\153");
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = TRUE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::WC_SOCIAL_LOGIN;
        $this->_otpType = "\160\x68\x6f\x6e\x65";
        $this->_phoneFormId = "\43\x6d\x6f\x5f\160\150\157\x6e\x65\137\156\165\155\x62\x65\162";
        $this->_formKey = "\127\103\x5f\x53\117\103\111\x41\x4c\x5f\114\x4f\x47\x49\x4e";
        $this->_formName = mo_("\x57\x6f\x6f\x63\x6f\155\155\145\162\x63\x65\40\x53\157\x63\151\x61\x6c\x20\x4c\x6f\x67\x69\x6e\x20\x3c\x69\x3e\50\x20\123\x4d\x53\40\x56\145\162\x69\146\151\x63\141\164\151\x6f\156\x20\x4f\156\x6c\171\x20\x29\74\x2f\x69\76");
        $this->_isFormEnabled = get_mo_option("\x77\143\137\163\x6f\x63\151\x61\154\137\154\x6f\x67\151\x6e\x5f\x65\x6e\141\142\154\x65");
        $this->_formDocuments = MoOTPDocs::WC_SOCIAL_LOGIN;
        parent::__construct();
    }
    function handleForm()
    {
        $this->includeRequiredFiles();
        foreach ($this->_oAuthProviders as $YV) {
            add_filter("\x77\x63\x5f\x73\x6f\143\151\141\154\x5f\154\157\x67\151\x6e\x5f" . $YV . "\x5f\x70\162\x6f\x66\151\154\x65", array($this, "\155\157\x5f\x77\143\x5f\163\157\x63\151\141\154\137\154\x6f\x67\151\156\137\x70\x72\157\146\x69\x6c\145"), 99, 2);
            add_filter("\x77\x63\x5f\x73\x6f\x63\x69\141\x6c\x5f\x6c\x6f\x67\151\x6e\137" . $YV . "\137\156\x65\167\x5f\165\163\145\162\137\144\x61\x74\141", array($this, "\x6d\157\137\x77\x63\137\163\157\x63\x69\x61\x6c\137\154\157\147\x69\156"), 99, 2);
            ea:
        }
        iv:
        $this->routeData();
    }
    function routeData()
    {
        if (array_key_exists("\157\160\164\x69\157\x6e", $_REQUEST)) {
            goto RX;
        }
        return;
        RX:
        switch (trim($_REQUEST["\x6f\160\x74\x69\x6f\156"])) {
            case "\155\x69\156\x69\157\x72\141\x6e\147\x65\55\141\x6a\141\170\x2d\x6f\164\160\x2d\x67\x65\x6e\145\162\141\164\x65":
                $this->_handle_wc_ajax_send_otp($_POST);
                goto qJ;
            case "\x6d\151\x6e\x69\157\x72\141\x6e\x67\x65\55\x61\x6a\141\x78\55\x6f\x74\160\x2d\166\141\154\x69\x64\x61\x74\145":
                $this->processOTPEntered($_REQUEST);
                goto qJ;
            case "\155\x6f\137\x61\x6a\141\x78\x5f\146\157\x72\155\x5f\166\x61\x6c\151\144\x61\164\x65":
                $this->_handle_wc_create_user_action($_POST);
                goto qJ;
        }
        G0:
        qJ:
    }
    function includeRequiredFiles()
    {
        if (function_exists("\151\163\137\160\x6c\x75\147\x69\x6e\137\x61\143\x74\x69\166\145")) {
            goto QW;
        }
        include_once ABSPATH . "\x77\x70\55\x61\x64\155\x69\156\57\151\156\143\x6c\165\144\145\163\57\x70\x6c\x75\147\151\156\56\x70\x68\x70";
        QW:
        if (!is_plugin_active("\x77\157\157\143\157\x6d\155\145\x72\143\145\55\x73\x6f\x63\151\x61\x6c\55\x6c\157\x67\x69\x6e\57\167\x6f\157\143\157\x6d\x6d\x65\162\x63\x65\x2d\x73\x6f\143\151\x61\x6c\x2d\x6c\x6f\x67\x69\x6e\56\x70\x68\160")) {
            goto hF;
        }
        require_once plugin_dir_path(MOV_DIR) . "\167\157\x6f\143\157\x6d\x6d\x65\x72\143\x65\x2d\163\x6f\x63\x69\141\154\55\x6c\157\147\151\x6e\57\x69\156\143\x6c\165\x64\x65\x73\57\143\154\x61\163\163\55\167\143\55\163\x6f\x63\151\141\x6c\x2d\x6c\157\x67\151\x6e\55\160\162\157\166\151\x64\145\162\x2d\x70\162\x6f\146\x69\x6c\145\x2e\160\x68\x70";
        hF:
    }
    function mo_wc_social_login_profile($ra, $sg)
    {
        MoUtility::initialize_transaction($this->_formSessionVar);
        MoPHPSessions::addSessionVar("\x77\143\137\x70\162\x6f\x76\151\x64\145\x72", $ra);
        $_SESSION["\167\x63\137\x70\x72\x6f\166\x69\x64\145\x72\137\151\144"] = maybe_serialize($sg);
        return $ra;
    }
    function mo_wc_social_login($ZP, $ra)
    {
        $this->sendChallenge(NULL, $ZP["\x75\x73\x65\x72\137\x65\x6d\x61\x69\154"], NULL, NULL, "\x65\170\x74\145\x72\156\141\x6c", NULL, array("\144\141\x74\x61" => $ZP, "\155\145\x73\163\141\147\145" => MoMessages::showMessage(MoMessages::PHONE_VALIDATION_MSG), "\146\157\x72\155" => "\127\103\137\123\117\103\x49\x41\114", "\x63\x75\x72\x6c" => MoUtility::currentPageUrl()));
    }
    function _handle_wc_create_user_action($Ir)
    {
        if (!(!$this->checkIfVerificationNotStarted() && SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType()))) {
            goto EV;
        }
        $this->create_new_wc_social_customer($Ir);
        EV:
    }
    function create_new_wc_social_customer($A2)
    {
        require_once plugin_dir_path(MOV_DIR) . "\x77\x6f\x6f\x63\x6f\x6d\x6d\145\162\x63\145\x2f\x69\x6e\x63\x6c\165\144\145\163\57\143\154\141\163\163\55\x77\143\55\x65\155\x61\x69\x6c\x73\x2e\x70\150\160";
        WC_Emails::init_transactional_emails();
        $iA = MoPHPSessions::getSessionVar("\167\x63\137\x70\x72\x6f\166\x69\144\x65\x72");
        $sg = maybe_unserialize($_SESSION["\x77\143\x5f\x70\162\157\166\151\144\x65\x72\x5f\x69\x64"]);
        $this->unsetOTPSessionVariables();
        $ra = new WC_Social_Login_Provider_Profile($sg, $iA);
        $l1 = $A2["\155\157\137\160\x68\157\156\x65\x5f\x6e\x75\155\x62\x65\162"];
        $A2 = array("\162\157\x6c\145" => "\x63\x75\x73\x74\x6f\155\145\x72", "\x75\x73\x65\162\137\x6c\157\147\x69\156" => $ra->has_email() ? sanitize_email($ra->get_email()) : $ra->get_nickname(), "\x75\163\x65\x72\x5f\145\155\x61\x69\x6c" => $ra->get_email(), "\165\163\145\x72\x5f\160\x61\163\x73" => wp_generate_password(), "\x66\x69\162\163\x74\x5f\156\x61\x6d\145" => $ra->get_first_name(), "\154\x61\x73\164\137\x6e\x61\x6d\x65" => $ra->get_last_name());
        if (!empty($A2["\165\x73\145\162\137\x6c\157\147\151\156"])) {
            goto by;
        }
        $A2["\x75\x73\145\162\137\x6c\157\x67\x69\x6e"] = $A2["\x66\x69\x72\163\x74\137\156\141\x6d\x65"] . $A2["\154\x61\x73\x74\x5f\156\x61\155\145"];
        by:
        $o0 = 1;
        $lM = $A2["\x75\163\145\162\137\154\157\147\151\x6e"];
        e_:
        if (!username_exists($A2["\x75\x73\145\x72\x5f\154\x6f\x67\151\156"])) {
            goto oI;
        }
        $A2["\x75\x73\145\x72\x5f\x6c\x6f\x67\151\x6e"] = $lM . $o0;
        $o0++;
        goto e_;
        oI:
        $Op = wp_insert_user($A2);
        update_user_meta($Op, "\142\151\154\x6c\x69\156\147\x5f\x70\150\x6f\x6e\x65", MoUtility::processPhoneNumber($l1));
        update_user_meta($Op, "\164\145\154\x65\160\150\x6f\x6e\x65", MoUtility::processPhoneNumber($l1));
        do_action("\x77\157\157\x63\157\155\x6d\x65\162\x63\x65\x5f\x63\162\145\x61\164\145\x64\137\x63\165\163\x74\157\x6d\145\162", $Op, $A2, false);
        $user = get_user_by("\x69\x64", $Op);
        $ra->update_customer_profile($user->ID, $user);
        if (!($Tg = apply_filters("\x77\x63\x5f\x73\x6f\x63\x69\x61\154\x5f\x6c\x6f\x67\151\156\137\x73\145\164\x5f\x61\165\164\x68\x5f\143\x6f\157\153\151\145", '', $user))) {
            goto hA;
        }
        wc_add_notice($Tg, "\156\x6f\164\151\143\145");
        goto Dq;
        hA:
        wc_set_customer_auth_cookie($user->ID);
        update_user_meta($user->ID, "\137\x77\x63\x5f\x73\x6f\143\x69\141\x6c\x5f\x6c\x6f\147\151\156\x5f" . $ra->get_provider_id() . "\x5f\154\157\147\151\156\137\164\x69\155\x65\163\x74\141\x6d\x70", current_time("\164\151\155\145\163\164\x61\155\x70"));
        update_user_meta($user->ID, "\137\167\x63\137\163\157\x63\x69\x61\x6c\137\154\x6f\x67\151\156\x5f" . $ra->get_provider_id() . "\x5f\x6c\x6f\x67\151\x6e\137\164\151\x6d\x65\163\x74\x61\155\160\x5f\x67\155\164", time());
        do_action("\167\143\137\x73\x6f\143\151\x61\154\x5f\x6c\157\x67\151\156\137\165\163\145\162\x5f\141\x75\x74\x68\x65\156\x74\151\x63\141\x74\145\x64", $user->ID, $ra->get_provider_id());
        Dq:
        if (is_wp_error($Op)) {
            goto Tg;
        }
        $this->redirect(null, $Op);
        goto JL;
        Tg:
        $this->redirect("\x65\162\162\x6f\x72", 0, $Op->get_error_code());
        JL:
    }
    function redirect($qf = null, $wc = 0, $gP = "\167\143\55\163\157\143\151\x61\x6c\55\154\157\147\x69\x6e\55\145\162\162\157\162")
    {
        $user = get_user_by("\x69\144", $wc);
        if (MoUtility::isBlank($user->user_email)) {
            goto pN;
        }
        $pX = get_transient("\x77\143\163\154\137" . md5($_SERVER["\122\105\115\117\124\105\137\101\104\104\x52"] . $_SERVER["\x48\x54\x54\x50\137\x55\x53\x45\122\x5f\101\x47\105\x4e\124"]));
        $pX = $pX ? esc_url(urldecode($pX)) : wc_get_page_permalink("\155\171\141\143\143\157\x75\156\x74");
        delete_transient("\x77\x63\163\154\x5f" . md5($_SERVER["\122\105\115\117\x54\105\x5f\101\104\x44\122"] . $_SERVER["\110\x54\x54\120\137\x55\x53\105\122\137\101\107\105\116\x54"]));
        goto Hr;
        pN:
        $pX = add_query_arg("\x77\x63\55\163\x6f\x63\151\x61\x6c\x2d\154\157\x67\151\x6e\x2d\155\151\x73\x73\x69\x6e\x67\55\145\x6d\x61\151\154", "\164\x72\x75\145", wc_customer_edit_account_url());
        Hr:
        if (!("\145\162\162\157\162" === $qf)) {
            goto q0;
        }
        $pX = add_query_arg($gP, "\x74\162\165\x65", $pX);
        q0:
        wp_safe_redirect(esc_url_raw($pX));
        die;
    }
    function handle_failed_verification($wE, $MQ, $TB, $au)
    {
        wp_send_json(MoUtility::createJson(MoUtility::_get_invalid_otp_method(), MoConstants::ERROR_JSON_TYPE));
    }
    function handle_post_verification($WE, $wE, $MQ, $eW, $TB, $HL, $au)
    {
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $au);
        wp_send_json(MoUtility::createJson(MoConstants::SUCCESS, MoConstants::SUCCESS_JSON_TYPE));
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar));
    }
    function _handle_wc_ajax_send_otp($tT)
    {
        if ($this->checkIfVerificationNotStarted()) {
            goto Z1;
        }
        $this->sendChallenge("\141\x6a\141\170\x5f\x70\150\x6f\156\145", '', null, trim($tT["\165\x73\x65\162\137\x70\150\157\x6e\x65"]), $this->_otpType, null, $tT);
        Z1:
    }
    function processOTPEntered($tT)
    {
        if (!$this->checkIfVerificationNotStarted()) {
            goto ll;
        }
        return;
        ll:
        if ($this->processPhoneNumber($tT)) {
            goto fO;
        }
        $this->validateChallenge($this->getVerificationType());
        goto V3;
        fO:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        V3:
    }
    function processPhoneNumber($tT)
    {
        $l1 = MoPHPSessions::getSessionVar("\x70\x68\157\x6e\x65\x5f\x6e\165\x6d\x62\x65\162\137\x6d\x6f");
        return strcmp($l1, MoUtility::processPhoneNumber($tT["\x75\163\x65\162\x5f\x70\150\x6f\156\x65"])) != 0;
    }
    function checkIfVerificationNotStarted()
    {
        return !SessionUtils::isOTPInitialized($this->_formSessionVar);
    }
    public function getPhoneNumberSelector($sq)
    {
        if (!$this->isFormEnabled()) {
            goto Ms;
        }
        array_push($sq, $this->_phoneFormId);
        Ms:
        return $sq;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto Ev;
        }
        return;
        Ev:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\167\143\137\163\157\x63\151\x61\x6c\x5f\154\x6f\147\x69\156\137\x65\x6e\x61\x62\x6c\x65");
        update_mo_option("\167\x63\137\x73\x6f\143\151\x61\x6c\x5f\x6c\x6f\x67\x69\156\137\145\156\141\142\x6c\x65", $this->_isFormEnabled);
    }
}
