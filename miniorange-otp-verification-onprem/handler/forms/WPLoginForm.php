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
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
use WP_Error;
use WP_User;
class WPLoginForm extends FormHandler implements IFormHandler
{
    use Instance;
    private $_savePhoneNumbers;
    private $_byPassAdmin;
    private $_allowLoginThroughPhone;
    private $_skipPasswordCheck;
    private $_userLabel;
    private $_delayOtp;
    private $_delayOtpInterval;
    private $_skipPassFallback;
    private $_createUserAction;
    private $_timeStampMetaKey = "\x6d\157\166\x5f\154\x61\163\164\137\x76\x65\x72\x69\146\x69\145\x64\x5f\x64\164\164\155";
    protected function __construct()
    {
        $this->_isLoginOrSocialForm = TRUE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::WP_LOGIN_REG_PHONE;
        $this->_formSessionVar2 = FormSessionVars::WP_DEFAULT_LOGIN;
        $this->_phoneFormId = "\43\155\157\x5f\x70\150\157\x6e\145\137\x6e\x75\155\x62\x65\x72";
        $this->_typePhoneTag = "\155\157\137\x77\160\137\x6c\x6f\147\x69\x6e\137\x70\150\157\x6e\145\x5f\x65\156\141\x62\x6c\145";
        $this->_typeEmailTag = "\155\157\x5f\167\160\137\x6c\157\147\x69\x6e\137\x65\x6d\141\151\154\137\145\x6e\141\x62\154\x65";
        $this->_formKey = "\127\x50\x5f\104\105\x46\x41\125\114\124\x5f\114\x4f\107\x49\116";
        $this->_formName = mo_("\x57\x6f\x72\144\x50\162\x65\163\x73\40\x4c\157\147\x69\156\x20\106\x6f\x72\x6d");
        $this->_isFormEnabled = get_mo_option("\x77\x70\x5f\x6c\157\x67\x69\x6e\x5f\145\156\x61\142\154\145");
        $this->_userLabel = get_mo_option("\167\x70\137\165\163\x65\x72\156\141\x6d\145\137\154\x61\x62\145\154\x5f\164\x65\x78\x74");
        $this->_userLabel = $this->_userLabel ? mo_($this->_userLabel) : mo_("\125\163\145\x72\156\141\x6d\x65\x2c\x20\105\x2d\155\141\151\154\x20\x6f\x72\40\x50\150\157\x6e\145\x20\x4e\x6f\x2e");
        $this->_skipPasswordCheck = get_mo_option("\x77\x70\137\154\157\x67\151\x6e\137\x73\x6b\151\160\x5f\x70\141\163\x73\167\x6f\x72\144");
        $this->_allowLoginThroughPhone = get_mo_option("\167\x70\137\x6c\157\147\x69\x6e\137\x61\x6c\x6c\157\167\x5f\x70\150\157\156\145\137\154\x6f\147\x69\x6e");
        $this->_skipPassFallback = get_mo_option("\167\160\x5f\x6c\157\147\x69\x6e\x5f\x73\153\151\x70\137\x70\141\163\x73\x77\157\x72\144\137\146\141\154\x6c\x62\x61\x63\153");
        $this->_delayOtp = get_mo_option("\167\160\137\154\x6f\x67\151\x6e\137\144\x65\x6c\x61\x79\137\x6f\164\x70");
        $this->_delayOtpInterval = get_mo_option("\167\x70\137\x6c\x6f\x67\151\x6e\x5f\144\145\154\x61\x79\x5f\x6f\164\160\x5f\151\x6e\x74\145\162\x76\141\x6c");
        $this->_delayOtpInterval = $this->_delayOtpInterval ? $this->_delayOtpInterval : 43800;
        $this->_formDocuments = MoOTPDocs::LOGIN_FORM;
        if (!($this->_skipPasswordCheck || $this->_allowLoginThroughPhone)) {
            goto PK;
        }
        add_action("\x6c\x6f\147\x69\156\137\145\x6e\161\x75\145\x75\x65\x5f\x73\x63\x72\x69\x70\164\x73", array($this, "\155\151\156\151\x6f\x72\x61\x6e\147\145\x5f\162\145\x67\151\163\x74\145\x72\137\x6c\x6f\147\x69\156\137\x73\143\x72\x69\160\164"));
        add_action("\167\160\x5f\x65\x6e\x71\165\x65\x75\145\x5f\x73\x63\x72\151\160\x74\x73", array($this, "\155\x69\x6e\x69\157\162\x61\x6e\147\145\x5f\162\x65\147\151\163\164\x65\x72\x5f\154\157\147\151\156\137\x73\x63\162\x69\160\x74"));
        PK:
        parent::__construct();
    }
    function handleForm()
    {
        $this->_otpType = get_mo_option("\x77\x70\137\154\x6f\147\x69\156\137\x65\156\141\x62\x6c\x65\x5f\x74\171\160\145");
        $this->_phoneKey = get_mo_option("\x77\x70\x5f\x6c\157\x67\151\156\x5f\x6b\x65\x79");
        $this->_savePhoneNumbers = get_mo_option("\167\x70\137\154\157\147\x69\156\x5f\162\x65\147\151\x73\164\145\x72\137\160\x68\x6f\156\145");
        $this->_byPassAdmin = get_mo_option("\x77\x70\137\154\157\x67\151\156\x5f\x62\171\x70\141\x73\x73\x5f\141\x64\155\151\x6e");
        $this->_restrictDuplicates = get_mo_option("\x77\x70\137\154\157\x67\x69\156\137\x72\145\x73\x74\x72\151\143\164\x5f\x64\165\x70\x6c\x69\143\141\x74\x65\163");
        add_filter("\141\165\164\x68\x65\x6e\x74\x69\x63\x61\164\x65", array($this, "\137\x68\x61\156\144\154\145\x5f\x6d\157\x5f\167\160\137\154\157\147\x69\x6e"), 99, 3);
        add_action("\x77\160\x5f\141\152\141\x78\137\x6d\x6f\55\141\x64\x6d\151\156\x2d\143\x68\x65\143\x6b", array($this, "\x69\163\101\144\155\151\x6e"));
        add_action("\167\160\x5f\141\x6a\x61\x78\137\156\x6f\160\162\x69\x76\137\155\157\x2d\x61\144\155\x69\156\x2d\x63\150\145\x63\x6b", array($this, "\151\163\x41\144\155\x69\x6e"));
        if (!class_exists("\x55\x4d")) {
            goto ai;
        }
        add_filter("\167\160\x5f\x61\165\164\150\x65\x6e\x74\151\143\141\x74\145\137\x75\x73\x65\x72", array($this, "\137\x67\x65\164\137\141\156\x64\x5f\162\x65\164\x75\162\156\x5f\165\163\x65\x72"), 99, 2);
        ai:
        $this->routeData();
    }
    function isAdmin()
    {
        $EN = MoUtility::sanitizeCheck("\165\x73\x65\162\156\141\155\x65", $_POST);
        $user = is_email($EN) ? get_user_by("\145\x6d\141\151\154", $EN) : get_user_by("\x6c\x6f\147\151\x6e", $EN);
        $rt = MoConstants::SUCCESS_JSON_TYPE;
        $rt = $user ? in_array("\x61\x64\155\x69\x6e\151\x73\x74\162\x61\x74\157\x72", $user->roles) ? $rt : "\145\x72\x72\x6f\x72" : "\145\x72\x72\157\x72";
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_EXISTS), $rt));
    }
    function routeData()
    {
        if (array_key_exists("\157\160\164\x69\x6f\x6e", $_REQUEST)) {
            goto ze;
        }
        return;
        ze:
        switch (trim($_REQUEST["\157\x70\164\x69\157\x6e"])) {
            case "\155\x69\156\x69\157\162\x61\x6e\147\x65\55\141\x6a\x61\x78\55\x6f\164\x70\x2d\x67\x65\x6e\145\x72\x61\x74\145":
                $this->_handle_wp_login_ajax_send_otp();
                goto D2;
            case "\x6d\151\156\151\x6f\162\x61\x6e\x67\145\55\x61\152\141\x78\55\x6f\164\160\55\x76\x61\154\x69\x64\141\164\145":
                $this->_handle_wp_login_ajax_form_validate_action();
                goto D2;
            case "\155\157\x5f\141\152\141\170\x5f\x66\157\x72\x6d\x5f\x76\x61\x6c\151\144\x61\x74\145":
                $this->_handle_wp_login_create_user_action();
                goto D2;
        }
        Em:
        D2:
    }
    function miniorange_register_login_script()
    {
        wp_register_script("\155\x6f\x6c\x6f\x67\x69\x6e", MOV_URL . "\151\156\143\154\165\x64\x65\163\57\x6a\163\x2f\154\x6f\x67\x69\156\146\157\162\155\56\x6d\x69\156\x2e\x6a\x73", array("\152\x71\165\x65\162\171"));
        wp_localize_script("\x6d\x6f\x6c\157\x67\x69\x6e", "\x6d\x6f\x76\141\162\x6c\x6f\147\151\156", array("\165\x73\145\x72\114\x61\x62\145\x6c" => $this->_allowLoginThroughPhone ? $this->_userLabel : null, "\x73\153\151\x70\120\x77\144\103\x68\x65\143\153" => $this->_skipPasswordCheck, "\163\153\151\x70\120\167\x64\x46\141\x6c\154\142\141\143\153" => $this->_skipPassFallback, "\x62\165\x74\164\x6f\156\164\x65\170\x74" => mo_("\x4c\x6f\147\x69\x6e\x20\167\151\x74\x68\x20\x4f\124\120"), "\x69\x73\x41\144\x6d\x69\x6e\x41\x63\x74\x69\157\156" => "\155\157\55\x61\144\155\151\x6e\55\143\x68\145\143\153", "\142\x79\120\x61\163\x73\101\144\x6d\x69\156" => $this->_byPassAdmin, "\163\151\x74\x65\125\122\114" => wp_ajax_url()));
        wp_enqueue_script("\155\x6f\x6c\157\x67\151\x6e");
    }
    function _get_and_return_user($EN, $eW)
    {
        if (!is_object($EN)) {
            goto zJ;
        }
        return $EN;
        zJ:
        $user = $this->getUser($EN, $eW);
        if (!is_wp_error($user)) {
            goto q9;
        }
        return $user;
        q9:
        UM()->login()->auth_id = $user->data->ID;
        UM()->form()->errors = null;
        return $user;
    }
    function byPassLogin($user, $Zm)
    {
        $aO = get_userdata($user->data->ID);
        $HM = $aO->roles;
        return in_array("\x61\x64\155\x69\156\151\163\164\162\x61\x74\x6f\x72", $HM) && $this->_byPassAdmin || $Zm || $this->delayOTPProcess($user->data->ID);
    }
    function _handle_wp_login_create_user_action()
    {
        $sQ = function ($Ir) {
            $EN = MoUtility::sanitizeCheck("\154\157\147", $Ir);
            if ($EN) {
                goto lo;
            }
            $Dv = array_filter($Ir, function ($O5) {
                return strpos($O5, "\x75\x73\145\x72\x6e\141\155\145") === 0;
            }, ARRAY_FILTER_USE_KEY);
            $EN = !empty($Dv) ? array_shift($Dv) : $EN;
            lo:
            return is_email($EN) ? get_user_by("\145\x6d\x61\x69\x6c", $EN) : get_user_by("\x6c\x6f\147\x69\x6e", $EN);
        };
        $Ir = $_POST;
        if (SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $this->getVerificationType())) {
            goto er;
        }
        return;
        er:
        $user = $sQ($Ir);
        update_user_meta($user->data->ID, $this->_phoneKey, $this->check_phone_length($Ir["\155\157\x5f\160\x68\157\x6e\145\x5f\x6e\165\x6d\142\145\x72"]));
        $this->login_wp_user($user->data->user_login);
    }
    function login_wp_user($vy, $HL = null)
    {
        $user = is_email($vy) ? get_user_by("\145\x6d\x61\x69\x6c", $vy) : ($this->allowLoginThroughPhone() && MoUtility::validatePhoneNumber($vy) ? $this->getUserFromPhoneNumber($vy) : get_user_by("\154\x6f\x67\151\x6e", $vy));
        wp_set_auth_cookie($user->data->ID);
        if (!($this->_delayOtp && $this->_delayOtpInterval > 0)) {
            goto aD;
        }
        update_user_meta($user->data->ID, $this->_timeStampMetaKey, time());
        aD:
        $this->unsetOTPSessionVariables();
        do_action("\167\160\x5f\154\x6f\147\x69\156", $user->user_login, $user);
        $Ei = MoUtility::isBlank($HL) ? site_url() : $HL;
        wp_redirect($Ei);
        die;
    }
    function _handle_mo_wp_login($user, $EN, $eW)
    {
        if (MoUtility::isBlank($EN)) {
            goto Q_;
        }
        $Zm = $this->skipOTPProcess($eW);
        $user = $this->getUser($EN, $eW);
        if (!is_wp_error($user)) {
            goto EB;
        }
        return $user;
        EB:
        if (!$this->byPassLogin($user, $Zm)) {
            goto De;
        }
        return $user;
        De:
        $this->startOTPVerificationProcess($user, $EN, $eW);
        Q_:
        return $user;
    }
    function startOTPVerificationProcess($user, $EN, $eW)
    {
        $au = $this->getVerificationType();
        if (!(SessionUtils::isStatusMatch($this->_formSessionVar, self::VALIDATED, $au) || SessionUtils::isStatusMatch($this->_formSessionVar2, self::VALIDATED, $au))) {
            goto nL;
        }
        return;
        nL:
        if ($au === VerificationType::PHONE) {
            goto Kp;
        }
        if (!($au === VerificationType::EMAIL)) {
            goto hy;
        }
        $Vy = $user->data->user_email;
        $this->startEmailVerification($EN, $Vy);
        hy:
        goto Hg;
        Kp:
        $TB = get_user_meta($user->data->ID, $this->_phoneKey, true);
        $TB = $this->check_phone_length($TB);
        $this->askPhoneAndStartVerification($user, $this->_phoneKey, $EN, $TB);
        $this->fetchPhoneAndStartVerification($EN, $eW, $TB);
        Hg:
    }
    function getUser($EN, $eW = null)
    {
        $user = is_email($EN) ? get_user_by("\145\155\141\151\154", $EN) : get_user_by("\x6c\157\147\x69\156", $EN);
        if (!($this->_allowLoginThroughPhone && MoUtility::validatePhoneNumber($EN))) {
            goto lp;
        }
        $user = $this->getUserFromPhoneNumber($EN);
        lp:
        if (!($user && !$this->isLoginWithOTP($user->roles))) {
            goto u4;
        }
        $user = wp_authenticate_username_password(NULL, $user->data->user_login, $eW);
        u4:
        return $user ? $user : new WP_Error("\111\116\x56\x41\114\111\104\137\125\123\105\122\116\101\x4d\x45", mo_("\40\74\142\x3e\105\x52\122\117\x52\x3a\x3c\57\142\76\x20\x49\x6e\166\x61\154\151\x64\40\x55\163\145\x72\116\141\x6d\x65\x2e\x20"));
    }
    function getUserFromPhoneNumber($EN)
    {
        global $wpdb;
        $KA = $wpdb->get_row("\x53\x45\x4c\105\103\x54\x20\x60\x75\163\145\162\137\x69\144\x60\40\x46\122\117\x4d\40\x60{$wpdb->prefix}\x75\163\x65\x72\155\145\164\141\x60" . "\127\x48\105\x52\105\x20\x60\155\x65\x74\141\x5f\x6b\x65\x79\x60\x20\x3d\x20\x27{$this->_phoneKey}\x27\40\x41\116\104\40\x60\155\x65\x74\141\x5f\x76\141\154\x75\145\x60\40\x3d\x20\40\47{$EN}\x27");
        return !MoUtility::isBlank($KA) ? get_userdata($KA->user_id) : false;
    }
    function askPhoneAndStartVerification($user, $O5, $EN, $TB)
    {
        if (MoUtility::isBlank($TB)) {
            goto ri;
        }
        return;
        ri:
        if (!$this->savePhoneNumbers()) {
            goto yz;
        }
        MoUtility::initialize_transaction($this->_formSessionVar);
        $this->sendChallenge(NULL, $user->data->user_login, NULL, NULL, "\145\x78\x74\145\x72\156\141\154", NULL, array("\144\141\164\x61" => array("\x75\163\145\162\137\x6c\157\x67\151\156" => $EN), "\155\145\x73\163\x61\147\x65" => MoMessages::showMessage(MoMessages::REGISTER_PHONE_LOGIN), "\x66\x6f\x72\x6d" => $O5, "\x63\165\x72\x6c" => MoUtility::currentPageUrl()));
        goto Ar;
        yz:
        miniorange_site_otp_validation_form(null, null, null, MoMessages::showMessage(MoMessages::PHONE_NOT_FOUND), null, null);
        Ar:
    }
    function fetchPhoneAndStartVerification($EN, $eW, $TB)
    {
        MoUtility::initialize_transaction($this->_formSessionVar2);
        $WE = isset($_REQUEST["\x72\145\x64\x69\x72\x65\143\164\x5f\164\x6f"]) ? $_REQUEST["\162\x65\x64\x69\162\x65\x63\164\x5f\164\x6f"] : MoUtility::currentPageUrl();
        $this->sendChallenge($EN, null, null, $TB, VerificationType::PHONE, $eW, $WE, false);
    }
    function startEmailVerification($EN, $Vy)
    {
        MoUtility::initialize_transaction($this->_formSessionVar2);
        $this->sendChallenge($EN, $Vy, null, null, VerificationType::EMAIL);
    }
    function _handle_wp_login_ajax_send_otp()
    {
        $tT = $_POST;
        if ($this->restrictDuplicates() && !MoUtility::isBlank($this->getUserFromPhoneNumber($tT["\165\163\x65\x72\x5f\160\x68\157\156\145"]))) {
            goto Z7;
        }
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto JR;
        }
        goto t_;
        Z7:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_EXISTS), MoConstants::ERROR_JSON_TYPE));
        goto t_;
        JR:
        $this->sendChallenge("\x61\152\x61\170\137\160\x68\157\156\x65", '', null, trim($tT["\x75\163\145\162\137\160\x68\157\x6e\x65"]), VerificationType::PHONE, null, $tT);
        t_:
    }
    function _handle_wp_login_ajax_form_validate_action()
    {
        $tT = $_POST;
        if (SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto GG;
        }
        return;
        GG:
        $l1 = MoPHPSessions::getSessionVar("\160\x68\157\x6e\145\137\x6e\x75\155\142\145\162\x5f\155\x6f");
        if (strcmp($l1, $this->check_phone_length($tT["\x75\163\145\162\137\160\x68\157\156\145"]))) {
            goto ET;
        }
        $this->validateChallenge($this->getVerificationType());
        goto sh;
        ET:
        wp_send_json(MoUtility::createJson(MoMessages::showMessage(MoMessages::PHONE_MISMATCH), MoConstants::ERROR_JSON_TYPE));
        sh:
    }
    function handle_failed_verification($wE, $MQ, $TB, $au)
    {
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto xx;
        }
        SessionUtils::addStatus($this->_formSessionVar, self::VERIFICATION_FAILED, $au);
        wp_send_json(MoUtility::createJson(MoUtility::_get_invalid_otp_method(), MoConstants::ERROR_JSON_TYPE));
        xx:
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar2)) {
            goto k2;
        }
        miniorange_site_otp_validation_form($wE, $MQ, $TB, MoUtility::_get_invalid_otp_method(), "\160\150\x6f\156\x65", FALSE);
        k2:
    }
    function handle_post_verification($WE, $wE, $MQ, $eW, $TB, $HL, $au)
    {
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            goto XE;
        }
        SessionUtils::addStatus($this->_formSessionVar, self::VALIDATED, $au);
        wp_send_json(MoUtility::createJson('', MoConstants::SUCCESS_JSON_TYPE));
        XE:
        if (!SessionUtils::isOTPInitialized($this->_formSessionVar2)) {
            goto EF;
        }
        $EN = MoUtility::isBlank($wE) ? MoUtility::sanitizeCheck("\x6c\157\x67", $_POST) : $wE;
        $EN = MoUtility::isBlank($EN) ? MoUtility::sanitizeCheck("\x75\x73\x65\x72\x6e\141\x6d\x65", $_POST) : $EN;
        $this->login_wp_user($EN, $HL);
        EF:
    }
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession(array($this->_txSessionId, $this->_formSessionVar, $this->_formSessionVar2));
    }
    public function getPhoneNumberSelector($sq)
    {
        if (!$this->isFormEnabled()) {
            goto Fe;
        }
        array_push($sq, $this->_phoneFormId);
        Fe:
        return $sq;
    }
    private function isLoginWithOTP($P5 = array())
    {
        $TE = mo_("\x4c\157\x67\x69\x6e\x20\x77\151\164\x68\40\117\x54\120");
        if (!(in_array("\141\144\155\151\x6e\x69\163\x74\x72\x61\x74\157\162", $P5) && $this->_byPassAdmin)) {
            goto Z9;
        }
        return false;
        Z9:
        return MoUtility::sanitizeCheck("\167\160\55\x73\x75\x62\x6d\x69\164", $_POST) == $TE || MoUtility::sanitizeCheck("\154\157\147\151\156", $_POST) == $TE || MoUtility::sanitizeCheck("\154\157\x67\x69\156\x74\171\160\x65", $_POST) == $TE;
    }
    private function skipOTPProcess($eW)
    {
        return $this->_skipPasswordCheck && $this->_skipPassFallback && isset($eW) && !$this->isLoginWithOTP();
    }
    private function check_phone_length($l1)
    {
        $GL = MoUtility::processPhoneNumber($l1);
        return strlen($GL) >= 5 ? $GL : '';
    }
    private function delayOTPProcess($wc)
    {
        if (!($this->_delayOtp && $this->_delayOtpInterval < 0)) {
            goto U3;
        }
        return TRUE;
        U3:
        $pI = get_user_meta($wc, $this->_timeStampMetaKey, true);
        if (!MoUtility::isBlank($pI)) {
            goto m5;
        }
        return FALSE;
        m5:
        $wm = time() - $pI;
        return $this->_delayOtp && $wm < $this->_delayOtpInterval * 60;
    }
    function handleFormOptions()
    {
        if (MoUtility::areFormOptionsBeingSaved($this->getFormOption())) {
            goto PE;
        }
        return;
        PE:
        $this->_isFormEnabled = $this->sanitizeFormPOST("\167\160\x5f\x6c\157\x67\151\156\137\145\x6e\141\142\154\x65");
        $this->_savePhoneNumbers = $this->sanitizeFormPOST("\x77\x70\137\154\x6f\x67\x69\x6e\x5f\x72\145\147\x69\x73\164\145\162\137\x70\150\x6f\x6e\145");
        $this->_byPassAdmin = $this->sanitizeFormPOST("\x77\x70\137\154\157\147\151\156\x5f\142\x79\160\141\x73\x73\137\141\x64\155\x69\x6e");
        $this->_phoneKey = $this->sanitizeFormPOST("\x77\x70\137\154\157\x67\151\156\x5f\x70\x68\157\156\145\x5f\146\x69\x65\154\144\x5f\153\145\171");
        $this->_allowLoginThroughPhone = $this->sanitizeFormPOST("\x77\x70\x5f\x6c\x6f\147\x69\156\x5f\x61\x6c\x6c\x6f\x77\137\160\x68\157\x6e\x65\137\x6c\x6f\x67\x69\156");
        $this->_restrictDuplicates = $this->sanitizeFormPOST("\167\160\137\x6c\x6f\147\151\156\137\162\x65\163\164\x72\x69\143\164\x5f\x64\x75\x70\154\x69\143\141\x74\145\163");
        $this->_otpType = $this->sanitizeFormPOST("\x77\160\137\154\157\x67\151\x6e\x5f\145\x6e\x61\x62\x6c\145\x5f\164\171\x70\145");
        $this->_skipPasswordCheck = $this->sanitizeFormPOST("\x77\160\137\x6c\x6f\147\x69\156\137\x73\153\x69\160\x5f\160\x61\x73\x73\167\x6f\162\x64");
        $this->_userLabel = $this->sanitizeFormPOST("\167\x70\137\x75\163\x65\x72\156\x61\x6d\x65\x5f\x6c\x61\x62\145\x6c\137\164\145\x78\164");
        $this->_skipPassFallback = $this->sanitizeFormPOST("\167\160\137\154\157\x67\151\x6e\137\163\153\x69\160\x5f\x70\x61\x73\163\x77\157\162\144\x5f\146\141\x6c\154\x62\141\x63\x6b");
        $this->_delayOtp = $this->sanitizeFormPOST("\167\x70\x5f\x6c\157\147\x69\156\137\144\x65\154\x61\x79\137\157\164\160");
        $this->_delayOtpInterval = $this->sanitizeFormPOST("\x77\x70\137\x6c\x6f\x67\x69\156\x5f\144\x65\154\141\x79\137\x6f\x74\x70\x5f\x69\x6e\x74\145\162\x76\141\154");
        update_mo_option("\x77\160\137\154\x6f\x67\151\x6e\x5f\x65\x6e\x61\x62\154\145\137\164\x79\x70\x65", $this->_otpType);
        update_mo_option("\x77\160\137\x6c\x6f\147\x69\x6e\x5f\x65\x6e\141\142\154\145", $this->_isFormEnabled);
        update_mo_option("\167\160\x5f\x6c\157\147\x69\156\x5f\162\x65\x67\x69\x73\164\145\x72\137\160\x68\x6f\x6e\x65", $this->_savePhoneNumbers);
        update_mo_option("\167\x70\x5f\154\x6f\x67\151\156\x5f\x62\171\160\141\x73\163\x5f\x61\x64\155\151\156", $this->_byPassAdmin);
        update_mo_option("\x77\x70\x5f\x6c\x6f\x67\151\156\137\x6b\x65\171", $this->_phoneKey);
        update_mo_option("\x77\160\137\x6c\157\147\151\156\x5f\141\154\154\x6f\167\x5f\x70\x68\x6f\156\145\x5f\154\157\x67\151\x6e", $this->_allowLoginThroughPhone);
        update_mo_option("\167\x70\137\x6c\x6f\147\151\x6e\137\x72\x65\163\x74\162\x69\x63\164\137\144\165\x70\154\151\x63\141\164\x65\x73", $this->_restrictDuplicates);
        update_mo_option("\x77\160\x5f\154\157\147\151\156\x5f\163\x6b\151\x70\x5f\x70\x61\163\x73\x77\x6f\162\144", $this->_skipPasswordCheck);
        update_mo_option("\167\x70\137\154\x6f\147\x69\156\137\x73\x6b\151\160\137\x70\141\x73\163\167\x6f\162\x64\x5f\x66\141\154\154\142\x61\x63\x6b", $this->_skipPassFallback);
        update_mo_option("\x77\160\x5f\x75\x73\145\x72\x6e\141\x6d\x65\x5f\154\x61\x62\x65\154\137\x74\x65\170\164", $this->_userLabel);
        update_mo_option("\x77\160\137\x6c\x6f\147\x69\156\137\x64\x65\x6c\x61\171\x5f\x6f\164\160", $this->_delayOtp);
        update_mo_option("\167\160\x5f\x6c\157\x67\151\156\137\x64\x65\154\141\171\137\x6f\x74\160\137\x69\156\x74\145\162\166\141\x6c", $this->_delayOtpInterval);
    }
    public function savePhoneNumbers()
    {
        return $this->_savePhoneNumbers;
    }
    function byPassCheckForAdmins()
    {
        return $this->_byPassAdmin;
    }
    function allowLoginThroughPhone()
    {
        return $this->_allowLoginThroughPhone;
    }
    public function getSkipPasswordCheck()
    {
        return $this->_skipPasswordCheck;
    }
    public function getUserLabel()
    {
        return mo_($this->_userLabel);
    }
    public function getSkipPasswordCheckFallback()
    {
        return $this->_skipPassFallback;
    }
    public function isDelayOtp()
    {
        return $this->_delayOtp;
    }
    public function getDelayOtpInterval()
    {
        return $this->_delayOtpInterval;
    }
}
