<?php


namespace OTP\Handler;

if (defined("\101\x42\123\120\x41\x54\110")) {
    goto A1O;
}
die;
A1O:
use OTP\Helper\GatewayFunctions;
use OTP\Helper\MoConstants;
use OTP\Helper\MocURLOTP;
use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
use OTP\Objects\BaseActionHandler;
use OTP\Traits\Instance;
class MoRegistrationHandler extends BaseActionHandler
{
    use Instance;
    function __construct()
    {
        parent::__construct();
        $this->_nonce = "\x6d\157\x5f\162\145\147\137\x61\143\x74\x69\157\156\x73";
        add_action("\x61\144\x6d\151\x6e\x5f\x69\156\151\164", array($this, "\x68\141\x6e\144\154\145\137\143\165\x73\164\157\155\x65\x72\x5f\162\x65\x67\151\163\164\x72\141\x74\x69\157\156"));
    }
    function handle_customer_registration()
    {
        if (current_user_can("\x6d\x61\156\x61\x67\x65\x5f\157\x70\164\x69\x6f\156\x73")) {
            goto MgQ;
        }
        return;
        MgQ:
        if (isset($_POST["\x6f\160\164\151\157\x6e"])) {
            goto WbC;
        }
        return;
        WbC:
        $hK = trim($_POST["\x6f\160\x74\151\x6f\156"]);
        switch ($hK) {
            case "\155\x6f\x5f\x72\145\x67\151\163\x74\162\141\164\151\x6f\x6e\137\x72\x65\x67\151\x73\x74\145\x72\137\x63\165\x73\164\157\x6d\145\162":
                $this->_register_customer($_POST);
                goto QfQ;
            case "\155\157\137\162\145\147\151\163\164\x72\x61\x74\151\x6f\x6e\x5f\x63\157\156\156\x65\143\x74\x5f\166\145\162\151\146\171\137\143\165\163\x74\157\155\145\x72":
                $this->_verify_customer($_POST);
                goto QfQ;
            case "\155\x6f\137\x72\x65\147\x69\163\164\162\x61\164\x69\157\x6e\x5f\166\x61\154\151\x64\141\164\145\x5f\157\164\x70":
                $this->_validate_otp($_POST);
                goto QfQ;
            case "\x6d\157\137\x72\145\x67\151\x73\164\x72\141\164\151\x6f\x6e\137\162\145\x73\x65\156\144\x5f\x6f\x74\160":
                $this->_send_otp_token(get_mo_option("\x61\x64\x6d\151\x6e\x5f\x65\x6d\141\151\x6c"), '', "\x45\x4d\101\111\114");
                goto QfQ;
            case "\x6d\x6f\137\x72\x65\147\x69\x73\164\x72\x61\164\151\157\x6e\x5f\x70\x68\x6f\156\145\x5f\x76\x65\162\x69\146\151\x63\x61\x74\x69\157\156":
                $this->_send_phone_otp_token($_POST);
                goto QfQ;
            case "\x6d\157\x5f\x72\145\x67\x69\x73\164\x72\x61\164\151\x6f\x6e\137\147\x6f\x5f\x62\141\143\x6b":
                $this->_revert_back_registration();
                goto QfQ;
            case "\x6d\x6f\x5f\162\145\x67\x69\x73\164\162\x61\x74\x69\x6f\156\x5f\x66\157\162\147\x6f\164\137\160\141\x73\163\167\157\162\144":
                $this->_reset_password();
                goto QfQ;
            case "\x6d\157\137\147\157\x5f\x74\x6f\137\154\x6f\147\x69\x6e\x5f\160\x61\x67\x65":
            case "\162\145\155\157\166\x65\x5f\x61\143\143\157\x75\156\164":
                $this->removeAccount();
                goto QfQ;
            case "\155\x6f\x5f\x72\145\x67\x69\x73\x74\x72\141\x74\x69\157\x6e\x5f\x76\x65\162\x69\x66\x79\x5f\x6c\x69\143\x65\x6e\x73\x65":
                $this->_vlk($_POST);
                goto QfQ;
        }
        xEF:
        QfQ:
    }
    function _register_customer($post)
    {
        $this->isValidRequest();
        $Vy = sanitize_email($_POST["\145\155\141\x69\x6c"]);
        $nP = sanitize_text_field($_POST["\143\x6f\155\160\141\x6e\171"]);
        $Lp = sanitize_text_field($_POST["\146\156\x61\155\x65"]);
        $bN = sanitize_text_field($_POST["\154\x6e\141\155\x65"]);
        $eW = sanitize_text_field($_POST["\x70\141\x73\x73\167\157\162\144"]);
        $We = sanitize_text_field($_POST["\x63\157\x6e\146\x69\x72\x6d\120\141\x73\x73\167\x6f\162\144"]);
        if (!(strlen($eW) < 6 || strlen($We) < 6)) {
            goto ETN;
        }
        do_action("\155\157\137\x72\x65\x67\151\x73\x74\162\141\164\151\157\x6e\x5f\x73\x68\x6f\x77\137\155\x65\163\x73\141\147\x65", MoMessages::showMessage(MoMessages::PASS_LENGTH), "\x45\122\x52\x4f\122");
        return;
        ETN:
        if (!($eW != $We)) {
            goto Dda;
        }
        delete_mo_option("\x76\145\x72\x69\146\x79\137\x63\165\163\x74\157\x6d\145\x72");
        do_action("\155\157\137\x72\x65\147\151\x73\x74\x72\x61\164\x69\157\156\x5f\163\150\157\x77\x5f\x6d\x65\x73\163\x61\x67\145", MoMessages::showMessage(MoMessages::PASS_MISMATCH), "\x45\122\122\117\x52");
        return;
        Dda:
        if (!(MoUtility::isBlank($Vy) || MoUtility::isBlank($eW) || MoUtility::isBlank($We))) {
            goto OjV;
        }
        do_action("\155\157\137\x72\145\147\x69\163\x74\x72\141\x74\x69\x6f\x6e\x5f\x73\150\157\167\x5f\x6d\145\163\163\x61\x67\145", MoMessages::showMessage(MoMessages::REQUIRED_FIELDS), "\x45\122\122\x4f\122");
        return;
        OjV:
        update_mo_option("\x63\157\x6d\x70\141\x6e\171\x5f\x6e\141\x6d\x65", $nP);
        update_mo_option("\x66\x69\162\x73\x74\137\156\141\155\x65", $Lp);
        update_mo_option("\154\x61\x73\164\137\x6e\141\155\x65", $bN);
        update_mo_option("\x61\144\155\x69\156\x5f\x65\155\141\x69\x6c", $Vy);
        update_mo_option("\141\144\x6d\x69\156\137\x70\x61\x73\163\167\157\x72\x64", $eW);
        $H1 = json_decode(MocURLOTP::check_customer($Vy), true);
        switch ($H1["\x73\x74\x61\x74\x75\x73"]) {
            case "\103\x55\123\124\x4f\x4d\x45\x52\x5f\116\117\124\x5f\106\x4f\x55\116\x44":
                $this->_send_otp_token($Vy, '', "\x45\x4d\x41\x49\114");
                goto li9;
            default:
                $this->_get_current_customer($Vy, $eW);
                goto li9;
        }
        c1R:
        li9:
    }
    function _send_otp_token($Vy, $l1, $fi)
    {
        $this->isValidRequest();
        $H1 = json_decode(MocURLOTP::mo_send_otp_token($fi, $Vy, $l1), true);
        if (strcasecmp($H1["\x73\x74\141\x74\165\x73"], "\x53\x55\x43\x43\x45\123\123") == 0) {
            goto eEv;
        }
        update_mo_option("\x72\x65\x67\151\163\164\162\x61\164\151\x6f\156\137\x73\x74\x61\164\165\163", "\115\117\x5f\117\x54\x50\x5f\104\105\x4c\x49\x56\105\x52\105\x44\137\106\101\x49\114\125\x52\105");
        do_action("\x6d\157\137\162\145\147\x69\163\164\162\x61\164\151\x6f\156\137\x73\x68\157\167\137\x6d\x65\163\x73\x61\x67\145", MoMessages::showMessage(MoMessages::ERR_OTP), "\x45\122\122\117\122");
        goto Yoy;
        eEv:
        update_mo_option("\164\x72\x61\156\x73\x61\143\x74\x69\x6f\156\111\x64", $H1["\164\170\111\144"]);
        update_mo_option("\x72\x65\147\x69\163\x74\162\x61\164\x69\157\x6e\137\163\164\x61\x74\x75\x73", "\x4d\x4f\x5f\117\124\x50\x5f\x44\x45\114\x49\126\105\x52\x45\104\137\x53\x55\103\x43\105\123\x53");
        if ($fi == "\x45\x4d\x41\111\x4c") {
            goto kmG;
        }
        do_action("\x6d\157\x5f\x72\145\147\151\163\x74\x72\141\164\151\x6f\156\x5f\163\150\157\x77\137\x6d\x65\x73\163\x61\x67\145", MoMessages::showMessage(MoMessages::OTP_SENT, array("\155\x65\164\x68\157\144" => $l1)), "\123\125\103\x43\x45\x53\x53");
        goto KJ4;
        kmG:
        do_action("\155\157\x5f\x72\145\147\151\163\x74\162\x61\x74\x69\157\156\137\x73\x68\x6f\167\137\155\145\163\163\x61\x67\x65", MoMessages::showMessage(MoMessages::OTP_SENT, array("\x6d\145\164\x68\x6f\x64" => $Vy)), "\123\125\x43\103\x45\123\x53");
        KJ4:
        Yoy:
    }
    private function _get_current_customer($Vy, $eW)
    {
        $H1 = MocURLOTP::get_customer_key($Vy, $eW);
        $X5 = json_decode($H1, true);
        if (json_last_error() == JSON_ERROR_NONE) {
            goto lX3;
        }
        update_mo_option("\141\x64\x6d\x69\x6e\137\145\x6d\141\151\x6c", $Vy);
        update_mo_option("\x76\x65\x72\x69\x66\171\x5f\x63\165\x73\x74\x6f\155\x65\162", "\x74\x72\165\145");
        delete_mo_option("\x6e\x65\167\137\x72\145\x67\151\x73\x74\162\x61\164\x69\x6f\x6e");
        do_action("\155\x6f\x5f\162\145\x67\x69\x73\x74\x72\x61\164\x69\157\x6e\137\163\x68\x6f\x77\137\x6d\145\163\163\141\x67\x65", MoMessages::showMessage(MoMessages::ACCOUNT_EXISTS), "\105\122\122\117\122");
        goto zik;
        lX3:
        update_mo_option("\141\x64\x6d\x69\156\x5f\145\x6d\141\x69\x6c", $Vy);
        update_mo_option("\x61\x64\155\151\x6e\137\x70\150\x6f\156\145", $X5["\x70\150\157\x6e\x65"]);
        $this->save_success_customer_config($X5["\x69\x64"], $X5["\141\x70\151\x4b\145\x79"], $X5["\164\x6f\x6b\145\x6e"], $X5["\x61\x70\160\x53\x65\143\162\145\164"]);
        MoUtility::_handle_mo_check_ln(false, $X5["\x69\x64"], $X5["\141\x70\151\113\x65\171"]);
        do_action("\x6d\x6f\137\x72\x65\x67\x69\163\164\x72\x61\x74\x69\x6f\x6e\x5f\163\x68\157\167\137\155\145\163\x73\141\x67\x65", MoMessages::showMessage(MoMessages::REG_SUCCESS), "\x53\x55\x43\103\x45\123\x53");
        zik:
    }
    function save_success_customer_config($HI, $EO, $P6, $jI)
    {
        update_mo_option("\x61\x64\155\x69\156\137\x63\165\x73\x74\x6f\155\145\x72\137\x6b\145\171", $HI);
        update_mo_option("\x61\144\155\151\156\137\x61\x70\x69\x5f\153\x65\171", $EO);
        update_mo_option("\143\165\163\x74\x6f\x6d\145\162\x5f\x74\157\x6b\145\156", $P6);
        delete_mo_option("\x76\145\x72\151\x66\x79\137\143\165\163\x74\x6f\155\x65\162");
        delete_mo_option("\156\x65\x77\x5f\x72\x65\147\151\x73\164\x72\141\164\151\157\156");
        delete_mo_option("\141\144\155\x69\156\137\160\141\163\x73\x77\x6f\162\x64");
    }
    function _validate_otp($post)
    {
        $this->isValidRequest();
        $NH = sanitize_text_field($post["\x6f\164\x70\x5f\x74\x6f\153\x65\156"]);
        $Vy = get_mo_option("\x61\144\155\x69\156\x5f\145\x6d\x61\x69\154");
        $nP = get_mo_option("\143\157\x6d\160\x61\x6e\x79\x5f\156\x61\x6d\x65");
        $eW = get_mo_option("\x61\144\x6d\151\x6e\137\x70\x61\x73\x73\167\x6f\x72\144");
        if (!MoUtility::isBlank($NH)) {
            goto kS0;
        }
        update_mo_option("\x72\x65\x67\x69\163\x74\x72\x61\x74\x69\157\x6e\x5f\163\164\x61\164\x75\x73", "\x4d\117\x5f\x4f\x54\120\x5f\126\x41\114\x49\104\101\124\111\x4f\x4e\137\x46\x41\x49\x4c\125\x52\105");
        do_action("\155\x6f\137\162\x65\147\151\x73\164\x72\x61\x74\x69\x6f\156\x5f\163\150\x6f\x77\137\x6d\x65\x73\163\x61\x67\145", MoMessages::showMessage(MoMessages::REQUIRED_OTP), "\x45\122\x52\117\122");
        return;
        kS0:
        $H1 = json_decode(MocURLOTP::validate_otp_token(get_mo_option("\x74\x72\141\x6e\x73\x61\143\x74\x69\x6f\x6e\111\x64"), $NH), true);
        if (strcasecmp($H1["\163\x74\x61\164\165\163"], "\x53\x55\x43\103\x45\123\123") == 0) {
            goto j3n;
        }
        update_mo_option("\x72\x65\x67\x69\x73\164\x72\141\164\151\x6f\x6e\137\x73\164\141\x74\x75\x73", "\x4d\x4f\137\117\124\120\137\126\x41\114\111\x44\101\124\x49\x4f\116\137\106\x41\x49\x4c\x55\122\105");
        do_action("\x6d\x6f\137\x72\145\x67\x69\163\x74\162\141\164\x69\157\156\137\163\150\157\167\137\x6d\x65\x73\163\x61\147\x65", MoUtility::_get_invalid_otp_method(), "\x45\122\x52\x4f\x52");
        goto Mmf;
        j3n:
        $X5 = json_decode(MocURLOTP::create_customer($Vy, $nP, $eW, $l1 = '', $Lp = '', $bN = ''), true);
        if (strcasecmp($X5["\x73\x74\141\164\165\163"], "\103\x55\x53\x54\117\115\x45\x52\x5f\x55\123\x45\122\116\101\115\105\x5f\x41\x4c\122\105\101\104\x59\137\105\130\x49\x53\124\x53") == 0) {
            goto vRy;
        }
        if (strcasecmp($X5["\x73\x74\x61\x74\x75\x73"], "\x46\x41\111\x4c\105\x44") == 0 && $X5["\x6d\x65\163\163\141\x67\x65"] == "\x45\155\141\151\x6c\40\x69\163\x20\x6e\x6f\164\40\x65\156\164\145\162\x70\162\x69\x73\x65\40\x65\x6d\141\x69\154\x2e") {
            goto riQ;
        }
        if (!(strcasecmp($X5["\163\164\x61\164\x75\163"], "\123\125\103\103\x45\x53\123") == 0)) {
            goto V1S;
        }
        $this->save_success_customer_config($X5["\x69\144"], $X5["\x61\x70\151\x4b\x65\x79"], $X5["\x74\x6f\x6b\x65\156"], $X5["\x61\160\160\x53\x65\143\x72\145\x74"]);
        update_mo_option("\x72\145\147\151\x73\164\x72\141\164\151\157\x6e\137\x73\x74\141\164\x75\163", "\115\117\137\103\125\123\x54\x4f\x4d\x45\122\137\126\x41\x4c\111\104\x41\x54\111\x4f\x4e\x5f\x52\x45\107\111\123\124\122\101\124\111\117\116\137\103\x4f\115\x50\114\105\124\105");
        update_mo_option("\145\x6d\141\151\x6c\x5f\164\x72\141\156\163\141\x63\164\x69\157\156\x73\137\162\145\x6d\141\151\156\151\156\147", MoConstants::EMAIL_TRANS_REMAINING);
        update_mo_option("\x70\150\x6f\x6e\x65\137\x74\x72\141\x6e\x73\141\x63\164\x69\x6f\156\x73\x5f\162\x65\x6d\x61\151\156\x69\156\147", MoConstants::PHONE_TRANS_REMAINING);
        do_action("\155\x6f\137\x72\145\147\151\163\x74\162\141\x74\x69\157\x6e\137\163\x68\157\x77\137\155\145\x73\163\x61\x67\x65", MoMessages::showMessage(MoMessages::REG_COMPLETE), "\x53\125\x43\x43\x45\x53\123");
        header("\x4c\x6f\x63\x61\164\x69\157\x6e\x3a\40\x61\x64\x6d\x69\x6e\x2e\160\x68\x70\x3f\x70\141\147\x65\75\x70\x72\x69\143\151\156\x67");
        V1S:
        goto o_1;
        riQ:
        do_action("\155\x6f\x5f\162\x65\x67\x69\x73\x74\x72\x61\164\151\157\156\x5f\x73\x68\157\167\137\x6d\145\163\163\x61\x67\145", MoMessages::showMessage(MoMessages::ENTERPRIZE_EMAIL), "\105\122\x52\x4f\x52");
        o_1:
        goto UzR;
        vRy:
        $this->_get_current_customer($Vy, $eW);
        UzR:
        Mmf:
    }
    function _send_phone_otp_token($post)
    {
        $this->isValidRequest();
        $l1 = sanitize_text_field($_POST["\x70\x68\157\x6e\x65\x5f\156\165\155\142\x65\x72"]);
        $l1 = str_replace("\40", '', $l1);
        $yA = "\x2f\133\134\x2b\x5d\x5b\x30\x2d\x39\x5d\x7b\x31\x2c\63\175\133\60\55\x39\x5d\173\x31\60\x7d\57";
        if (preg_match($yA, $l1, $Pm, PREG_OFFSET_CAPTURE)) {
            goto eQW;
        }
        update_mo_option("\162\x65\147\151\x73\x74\x72\x61\164\151\x6f\156\137\163\164\141\x74\165\x73", "\x4d\x4f\x5f\117\x54\120\x5f\x44\x45\114\x49\126\105\x52\105\104\x5f\x46\101\111\x4c\x55\x52\x45");
        do_action("\155\157\137\x72\x65\147\x69\x73\164\x72\141\164\x69\x6f\x6e\137\x73\150\x6f\167\x5f\155\x65\163\163\x61\x67\145", MoMessages::showMessage(MoMessages::INVALID_SMS_OTP), "\x45\122\x52\117\122");
        goto jrw;
        eQW:
        update_mo_option("\x61\x64\x6d\x69\x6e\x5f\x70\150\157\156\145", $l1);
        $this->_send_otp_token('', $l1, "\123\115\123");
        jrw:
    }
    function _verify_customer($post)
    {
        $this->isValidRequest();
        $Vy = sanitize_email($post["\x65\155\x61\151\154"]);
        $eW = stripslashes($post["\x70\x61\163\x73\x77\157\x72\144"]);
        if (!(MoUtility::isBlank($Vy) || MoUtility::isBlank($eW))) {
            goto rgl;
        }
        do_action("\155\x6f\x5f\x72\145\x67\151\x73\164\x72\141\x74\x69\x6f\x6e\137\163\x68\x6f\167\x5f\155\x65\163\x73\x61\x67\x65", MoMessages::showMessage(MoMessages::REQUIRED_FIELDS), "\105\x52\122\117\x52");
        return;
        rgl:
        $this->_get_current_customer($Vy, $eW);
    }
    function _reset_password()
    {
        $this->isValidRequest();
        $Vy = get_mo_option("\141\144\155\151\156\137\145\155\x61\151\154");
        if (!$Vy) {
            goto lYe;
        }
        $Dt = json_decode(MocURLOTP::forgot_password($Vy));
        if ($Dt->status == "\x53\125\103\x43\x45\123\123") {
            goto mLC;
        }
        do_action("\155\157\137\x72\145\x67\151\x73\164\162\141\x74\x69\157\156\x5f\x73\150\x6f\x77\x5f\155\x65\x73\163\x61\147\x65", MoMessages::showMessage(MoMessages::UNKNOWN_ERROR), "\105\x52\122\117\122");
        goto gma;
        mLC:
        do_action("\155\157\137\x72\145\147\x69\x73\164\162\141\164\x69\157\156\137\x73\150\157\167\x5f\x6d\x65\x73\163\141\x67\145", MoMessages::showMessage(MoMessages::RESET_PASS), "\123\x55\103\103\x45\123\123");
        gma:
        goto myr;
        lYe:
        do_action("\x6d\157\x5f\x72\145\x67\151\163\x74\x72\141\x74\151\x6f\x6e\137\163\150\x6f\167\137\155\145\x73\163\x61\147\x65", MoMessages::showMessage(MoMessages::FORGOT_PASSWORD_MESSAGE), "\x53\125\x43\x43\x45\x53\123");
        myr:
    }
    function _revert_back_registration()
    {
        $this->isValidRequest();
        update_mo_option("\x72\x65\x67\x69\x73\x74\x72\141\x74\151\157\156\x5f\163\x74\x61\164\x75\x73", '');
        delete_mo_option("\x6e\145\x77\137\x72\145\147\x69\163\164\x72\141\x74\151\157\x6e");
        delete_mo_option("\x76\x65\x72\x69\146\171\x5f\143\165\x73\x74\x6f\x6d\x65\162");
        delete_mo_option("\x61\x64\155\151\156\x5f\145\155\x61\x69\154");
        delete_mo_option("\163\x6d\x73\137\x6f\x74\160\137\x63\x6f\x75\x6e\164");
        delete_mo_option("\x65\155\141\x69\x6c\x5f\157\x74\x70\x5f\143\157\x75\x6e\x74");
    }
    function removeAccount()
    {
        $this->isValidRequest();
        $this->flush_cache();
        wp_clear_scheduled_hook("\150\157\165\162\x6c\171\x53\x79\x6e\x63");
        delete_mo_option("\x74\x72\x61\x6e\x73\x61\x63\164\151\x6f\x6e\x49\x64");
        delete_mo_option("\141\144\155\151\x6e\x5f\x70\141\163\x73\167\x6f\x72\144");
        delete_mo_option("\162\145\x67\151\163\164\162\141\x74\151\157\x6e\137\163\x74\141\164\165\163");
        delete_mo_option("\141\x64\x6d\x69\156\137\x70\150\x6f\x6e\145");
        delete_mo_option("\x6e\x65\x77\137\162\x65\147\x69\163\164\x72\141\164\151\157\156");
        delete_mo_option("\x61\144\155\x69\x6e\x5f\143\x75\x73\164\157\155\x65\162\137\x6b\x65\171");
        delete_mo_option("\141\144\x6d\x69\156\x5f\x61\160\151\137\x6b\x65\x79");
        delete_mo_option("\x63\x75\163\164\157\155\145\x72\137\164\x6f\x6b\145\156");
        delete_mo_option("\166\x65\x72\151\146\171\x5f\x63\x75\163\164\157\155\x65\x72");
        delete_mo_option("\155\x65\163\163\141\x67\145");
        delete_mo_option("\x63\150\x65\x63\x6b\137\154\156");
        update_mo_option("\166\x65\162\x69\146\x79\137\x63\165\163\x74\x6f\155\145\162", true);
    }
    function flush_cache()
    {
        $vx = GatewayFunctions::instance();
        $vx->flush_cache();
    }
    function _vlk($post)
    {
        $vx = GatewayFunctions::instance();
        $vx->_vlk($post);
    }
}
