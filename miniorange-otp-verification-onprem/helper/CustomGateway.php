<?php


namespace OTP\Helper;

if (defined("\101\x42\123\x50\101\x54\x48")) {
    goto gd;
}
die;
gd:
use OTP\Handler\MoOTPActionHandlerHandler;
use OTP\Objects\NotificationSettings;
class CustomGateway
{
    protected $applicationName;
    public function hourlySync()
    {
        if ($this->ch_xdigit()) {
            goto y1;
        }
        $this->daoptions();
        y1:
    }
    public function flush_cache()
    {
        if (MO_TEST_MODE) {
            goto Lx;
        }
        if (!$this->mclv()) {
            goto XI;
        }
        $this->mius();
        XI:
        goto kc;
        Lx:
        delete_mo_option("\x73\151\x74\x65\137\145\155\x61\151\x6c\137\x63\153\x6c");
        delete_mo_option("\145\155\141\151\154\137\166\x65\162\x69\x66\x69\143\141\164\151\157\156\137\154\153");
        kc:
    }
    public function _vlk($post)
    {
        if (!MoUtility::isBlank($post["\x65\x6d\x61\x69\154\x5f\x6c\x6b"])) {
            goto kO;
        }
        do_action("\x6d\x6f\x5f\x72\145\x67\x69\x73\x74\162\x61\x74\151\157\156\x5f\x73\150\157\167\x5f\x6d\145\163\x73\x61\147\145", MoMessages::showMessage(MoMessages::REQUIRED_FIELDS), MoConstants::ERROR);
        return;
        kO:
        $II = trim($_POST["\x65\155\141\x69\x6c\x5f\x6c\153"]);
        $Qh = json_decode($this->ccl(), true);
        switch ($Qh["\x73\164\x61\164\x75\x73"]) {
            case "\x53\x55\x43\103\105\x53\123":
                $this->_vlk_success($II);
                goto ro;
            default:
                $this->_vlk_fail();
                goto ro;
        }
        vk:
        ro:
    }
    public function mclv()
    {
        $O5 = get_mo_option("\143\x75\x73\x74\x6f\x6d\x65\162\137\164\157\153\x65\x6e");
        $hz = isset($O5) && !empty($O5) ? AEncryption::decrypt_data(get_mo_option("\x73\x69\164\145\x5f\145\155\141\x69\154\x5f\x63\x6b\x6c"), $O5) : "\x66\141\x6c\163\x65";
        $bR = get_mo_option("\x65\155\x61\151\154\137\x76\x65\162\x69\x66\151\x63\x61\x74\151\157\156\137\154\x6b");
        $Vy = get_mo_option("\141\144\x6d\151\156\x5f\x65\155\x61\151\x6c");
        $X5 = get_mo_option("\x61\144\155\x69\156\x5f\x63\165\163\x74\157\155\x65\x72\x5f\153\145\171");
        return $hz == "\x74\162\x75\x65" && $bR && $Vy && $X5 && is_numeric(trim($X5));
    }
    public function isMG()
    {
        return FALSE;
    }
    public function getApplicationName()
    {
        return $this->applicationName;
    }
    private function ch_xdigit()
    {
        if (get_mo_option("\x73\x69\x74\145\x5f\x65\155\x61\x69\154\x5f\143\x6b\x6c")) {
            goto wo;
        }
        return FALSE;
        wo:
        $O5 = get_mo_option("\143\165\163\164\x6f\155\145\162\x5f\x74\x6f\x6b\x65\156");
        return AEncryption::decrypt_data(get_mo_option("\x73\151\x74\x65\137\145\x6d\141\151\154\x5f\143\153\154"), $O5) == "\x74\162\165\145";
    }
    private function daoptions()
    {
        delete_mo_option("\167\160\137\144\145\146\x61\165\x6c\x74\x5f\x65\x6e\141\142\x6c\145");
        delete_mo_option("\167\143\137\144\145\146\141\165\154\164\137\145\156\141\x62\154\x65");
        delete_mo_option("\160\x62\x5f\144\x65\146\141\165\x6c\164\137\x65\156\141\142\154\x65");
        delete_mo_option("\165\155\x5f\144\x65\146\141\x75\x6c\x74\x5f\145\156\x61\x62\154\145");
        delete_mo_option("\163\151\155\x70\154\x72\x5f\144\145\146\141\165\154\164\x5f\x65\x6e\x61\x62\154\x65");
        delete_mo_option("\x65\166\145\156\164\x5f\x64\145\146\x61\165\154\164\137\x65\x6e\141\142\154\x65");
        delete_mo_option("\x62\142\160\137\x64\145\146\141\x75\154\x74\x5f\145\156\x61\x62\x6c\145");
        delete_mo_option("\143\x72\x66\x5f\144\145\146\141\x75\x6c\x74\137\x65\x6e\x61\142\x6c\145");
        delete_mo_option("\165\x75\x6c\164\x72\x61\x5f\x64\145\146\141\x75\x6c\x74\x5f\x65\156\141\142\x6c\145");
        delete_mo_option("\x77\143\x5f\143\x68\145\143\x6b\157\x75\x74\x5f\145\x6e\x61\x62\154\x65");
        delete_mo_option("\165\x70\155\x65\x5f\144\145\146\141\x75\x6c\164\137\145\156\141\x62\x6c\x65");
        delete_mo_option("\x70\x69\145\137\x64\145\146\x61\x75\x6c\x74\x5f\x65\x6e\141\x62\x6c\x65");
        delete_mo_option("\x63\146\x37\x5f\x63\x6f\x6e\164\141\x63\164\137\x65\x6e\x61\142\154\145");
        delete_mo_option("\143\x6c\141\163\x73\x69\x66\171\x5f\145\156\x61\x62\154\145");
        delete_mo_option("\147\x66\x5f\143\x6f\x6e\x74\x61\x63\164\x5f\145\156\x61\142\154\x65");
        delete_mo_option("\x6e\152\x61\x5f\x65\x6e\141\x62\x6c\145");
        delete_mo_option("\156\x69\x6e\x6a\x61\137\x66\x6f\x72\x6d\137\145\x6e\x61\142\x6c\x65");
        delete_mo_option("\x74\155\154\x5f\145\156\x61\142\x6c\x65");
        delete_mo_option("\165\154\164\x69\160\162\157\137\x65\x6e\x61\142\x6c\145");
        delete_mo_option("\165\x73\145\162\160\x72\157\x5f\144\x65\x66\x61\x75\154\164\x5f\x65\156\141\x62\154\145");
        delete_mo_option("\x77\160\x5f\x6c\157\x67\x69\156\x5f\x65\156\x61\x62\x6c\x65");
        delete_mo_option("\x66\157\162\x6d\x63\162\x61\x66\164\137\x70\x72\x65\x6d\151\x75\x6d\x5f\x65\156\x61\x62\x6c\145");
        delete_mo_option("\167\x70\x5f\x6d\x65\155\142\145\162\x5f\x72\x65\147\x5f\x65\x6e\x61\142\x6c\145");
        delete_mo_option("\x67\146\137\157\x74\160\137\145\156\x61\x62\x6c\x65\x64");
        delete_mo_option("\x77\143\x5f\x73\157\143\x69\x61\154\137\x6c\157\x67\x69\x6e\x5f\x65\156\x61\x62\154\x65");
        delete_mo_option("\146\157\162\155\x63\162\141\x66\x74\x5f\x65\156\x61\x62\x6c\145");
        delete_mo_option("\x6d\157\x5f\x63\165\163\x74\157\155\145\162\137\166\x61\x6c\x69\x64\x61\164\151\x6f\156\x5f\141\144\x6d\x69\x6e\137\145\x6d\x61\151\x6c");
        delete_mo_option("\167\160\x63\157\x6d\155\x65\156\164\137\x65\156\141\142\x6c\x65");
        delete_mo_option("\144\x6f\x63\144\x69\162\145\x63\x74\137\145\x6e\141\x62\x6c\x65");
        delete_mo_option("\x77\x70\146\x6f\x72\155\137\x65\156\x61\x62\x6c\145");
        delete_mo_option("\x63\162\146\137\x6f\164\x70\x5f\x65\156\x61\x62\x6c\x65\144");
        delete_mo_option("\143\x61\x6c\144\145\x72\141\137\x65\x6e\x61\142\x6c\x65");
        delete_mo_option("\146\157\x72\155\155\x61\153\145\x72\137\145\156\x61\x62\154\145");
        delete_mo_option("\x75\155\x5f\160\162\157\146\151\x6c\x65\x5f\145\156\x61\x62\x6c\145");
        delete_mo_option("\x76\x69\x73\165\141\154\x5f\146\x6f\162\x6d\137\145\x6e\x61\142\154\x65");
        delete_mo_option("\x66\162\x6d\137\146\x6f\x72\155\x5f\145\x6e\141\142\x6c\145");
        delete_mo_option("\x77\143\137\x62\151\x6c\154\x69\x6e\147\137\145\156\141\142\154\145");
    }
    private function _vlk_success($II)
    {
        $H1 = json_decode($this->vml($II), true);
        if (strcasecmp($H1["\x73\x74\x61\x74\165\x73"], "\x53\x55\x43\103\x45\123\x53") == 0) {
            goto aB;
        }
        if (strcasecmp($H1["\x73\164\x61\x74\x75\163"], "\106\101\111\x4c\x45\104") == 0) {
            goto fi;
        }
        do_action("\155\x6f\137\162\145\x67\x69\163\x74\162\x61\x74\x69\x6f\156\137\x73\150\x6f\167\x5f\x6d\145\x73\x73\x61\147\x65", MoMessages::showMessage(MoMessages::UNKNOWN_ERROR), "\x45\x52\122\117\122");
        goto w_;
        fi:
        if (strcasecmp($H1["\x6d\x65\x73\x73\141\147\145"], "\x43\x6f\x64\x65\x20\150\x61\x73\40\x45\x78\160\151\162\x65\144") == 0) {
            goto xq;
        }
        do_action("\x6d\157\137\x72\x65\147\151\163\164\x72\141\x74\151\x6f\x6e\137\163\150\x6f\x77\x5f\x6d\x65\163\163\141\147\x65", MoMessages::showMessage(MoMessages::INVALID_LK), "\105\122\122\117\122");
        goto hg;
        xq:
        do_action("\x6d\x6f\x5f\x72\145\147\x69\x73\x74\x72\x61\x74\151\157\156\137\x73\150\x6f\167\x5f\x6d\x65\x73\x73\x61\x67\145", MoMessages::showMessage(MoMessages::LK_IN_USE), "\x45\122\122\117\x52");
        hg:
        w_:
        goto DB;
        aB:
        $O5 = get_mo_option("\x63\165\163\164\157\155\x65\162\x5f\164\x6f\153\145\156");
        update_mo_option("\x65\155\x61\x69\x6c\137\x76\x65\162\151\x66\x69\143\141\164\151\x6f\x6e\137\154\153", AEncryption::encrypt_data($II, $O5));
        update_mo_option("\163\151\164\145\x5f\145\155\141\x69\x6c\137\x63\153\154", AEncryption::encrypt_data("\x74\162\165\x65", $O5));
        do_action("\x6d\x6f\137\x72\x65\x67\151\163\x74\162\141\164\151\157\x6e\x5f\x73\x68\x6f\x77\137\x6d\145\x73\163\x61\x67\145", MoMessages::showMessage(MoMessages::VERIFIED_LK), "\x53\x55\103\103\105\x53\x53");
        DB:
    }
    private function _vlk_fail()
    {
        $O5 = get_mo_option("\143\165\x73\x74\x6f\x6d\145\x72\137\164\x6f\x6b\x65\156");
        update_mo_option("\163\151\164\x65\137\x65\155\x61\x69\x6c\137\143\153\154", AEncryption::encrypt_data("\146\141\x6c\x73\145", $O5));
        do_action("\155\x6f\137\x72\x65\x67\x69\x73\x74\x72\141\164\151\x6f\156\137\x73\150\157\167\137\155\145\163\x73\x61\147\145", MoMessages::showMessage(MoMessages::NEED_UPGRADE_MSG), "\105\122\x52\117\122");
    }
    private function vml($II)
    {
        $u1 = MoConstants::HOSTNAME . "\57\x6d\x6f\141\x73\x2f\141\x70\151\57\x62\141\143\x6b\x75\x70\143\157\x64\145\57\x76\145\x72\x69\146\x79";
        $X5 = get_mo_option("\x61\144\x6d\151\x6e\x5f\143\x75\x73\x74\157\x6d\145\x72\x5f\153\x65\x79");
        $EO = get_mo_option("\141\144\155\151\156\x5f\x61\160\151\x5f\153\x65\171");
        $K_ = array("\143\157\144\x65" => $II, "\x63\165\x73\164\157\155\145\x72\x4b\x65\x79" => $X5, "\x61\x64\144\151\x74\151\157\156\141\x6c\106\x69\145\154\144\163" => array("\x66\x69\x65\154\144\61" => site_url()));
        $oX = json_encode($K_);
        $D6 = MocURLOTP::createAuthHeader($X5, $EO);
        $PG = MocURLOTP::callAPI($u1, $oX, $D6);
        return $PG;
    }
    private function ccl()
    {
        $u1 = MoConstants::HOSTNAME . "\x2f\155\157\x61\163\x2f\x72\x65\x73\x74\x2f\143\x75\x73\x74\x6f\x6d\145\162\x2f\x6c\151\143\x65\156\x73\x65";
        $X5 = get_mo_option("\x61\x64\155\151\x6e\137\x63\165\x73\164\x6f\155\x65\162\137\153\x65\171");
        $EO = get_mo_option("\141\x64\155\x69\x6e\137\x61\160\x69\x5f\x6b\x65\x79");
        $K_ = array("\x63\x75\163\x74\157\155\145\162\x49\x64" => $X5, "\141\160\x70\x6c\x69\x63\141\164\151\157\x6e\116\141\x6d\x65" => $this->applicationName);
        $oX = json_encode($K_);
        $D6 = MocURLOTP::createAuthHeader($X5, $EO);
        $PG = MocURLOTP::callAPI($u1, $oX, $D6);
        return $PG;
    }
    private function mius()
    {
        $u1 = MoConstants::HOSTNAME . "\57\x6d\157\x61\163\57\x61\x70\151\x2f\142\x61\x63\153\x75\160\x63\x6f\x64\x65\x2f\165\160\144\141\x74\x65\163\164\x61\x74\165\163";
        $X5 = get_mo_option("\141\144\155\151\156\x5f\143\x75\x73\x74\157\155\145\x72\x5f\x6b\x65\x79");
        $EO = get_mo_option("\x61\x64\155\151\156\x5f\x61\x70\151\137\x6b\145\171");
        $O5 = get_mo_option("\x63\x75\163\x74\157\155\145\162\x5f\164\157\x6b\145\156");
        $II = AEncryption::decrypt_data(get_mo_option("\145\155\141\151\x6c\x5f\x76\x65\x72\x69\146\151\x63\x61\164\x69\157\156\x5f\x6c\153"), $O5);
        $K_ = array("\143\x6f\144\145" => $II, "\143\x75\163\164\x6f\155\145\x72\113\x65\x79" => $X5);
        $oX = json_encode($K_);
        $D6 = MocURLOTP::createAuthHeader($X5, $EO);
        $PG = MocURLOTP::callAPI($u1, $oX, $D6);
        return $PG;
    }
    public function custom_wp_mail_from_name($rS)
    {
        return get_mo_option("\x63\165\163\x74\x6f\x6d\x5f\x65\x6d\141\x69\154\137\146\x72\x6f\x6d\137\156\x61\155\145") ? get_mo_option("\x63\x75\163\164\157\155\x5f\145\x6d\x61\151\x6c\x5f\146\162\157\155\137\156\x61\155\145") : $rS;
    }
    function _mo_configure_sms_template($T3)
    {
        $LA = trim($T3["\x6d\157\137\143\165\x73\164\157\x6d\x65\x72\137\x76\x61\x6c\x69\x64\x61\164\x69\x6f\156\x5f\x63\x75\x73\164\x6f\155\137\x73\x6d\163\x5f\x6d\163\147"]);
        $LA = str_replace(PHP_EOL, "\x25\x30\x61", $LA);
        update_mo_option("\143\165\163\x74\x6f\155\137\163\x6d\x73\x5f\155\163\x67", $LA);
        update_mo_option("\x63\165\x73\164\157\155\137\x73\155\163\137\147\141\164\145\x77\141\171", $T3["\155\157\x5f\143\165\163\164\157\x6d\x65\x72\137\166\x61\154\x69\144\141\164\x69\x6f\156\x5f\x63\165\163\x74\x6f\x6d\137\x73\x6d\x73\x5f\x67\x61\164\x65\x77\x61\171"]);
        do_action("\x6d\157\137\x72\145\147\151\x73\x74\x72\141\x74\151\157\x6e\137\163\x68\157\167\137\155\x65\163\163\x61\147\x65", MoMessages::showMessage(MoMessages::SMS_TEMPLATE_SAVED), "\x53\125\103\103\x45\123\x53");
    }
    function _mo_configure_email_template($T3)
    {
        update_mo_option("\x63\165\x73\164\157\x6d\137\145\155\141\x69\x6c\137\x6d\163\147", wpautop($T3["\155\157\137\x63\165\x73\164\x6f\155\x65\162\137\x76\x61\154\x69\x64\x61\164\x69\x6f\x6e\137\143\x75\163\x74\157\155\137\145\x6d\x61\151\x6c\137\x6d\x73\147"]));
        update_mo_option("\143\165\x73\x74\157\x6d\137\145\155\x61\151\x6c\137\x73\x75\142\152\145\143\x74", sanitize_text_field($T3["\155\157\137\x63\165\163\x74\x6f\x6d\x65\162\137\166\x61\x6c\x69\144\x61\164\x69\x6f\156\x5f\143\x75\163\164\x6f\x6d\x5f\145\x6d\x61\x69\154\x5f\x73\165\142\x6a\145\143\164"]));
        update_mo_option("\x63\165\163\x74\157\155\x5f\145\x6d\x61\x69\x6c\x5f\x66\162\x6f\155\x5f\x69\144", sanitize_text_field($T3["\155\157\137\x63\165\163\x74\x6f\x6d\x65\x72\137\166\x61\x6c\x69\x64\x61\x74\151\157\x6e\x5f\x63\x75\x73\x74\157\155\137\145\155\141\151\154\137\146\162\x6f\x6d\x5f\x69\144"]));
        update_mo_option("\x63\x75\163\164\x6f\155\137\145\155\x61\x69\154\x5f\x66\x72\157\x6d\137\x6e\141\x6d\x65", sanitize_text_field($T3["\x6d\x6f\137\143\165\x73\x74\x6f\x6d\145\x72\137\166\141\x6c\x69\x64\x61\x74\151\157\x6e\x5f\x63\165\x73\x74\x6f\x6d\137\x65\155\x61\151\154\137\x66\x72\x6f\155\137\156\x61\155\x65"]));
        do_action("\155\x6f\137\162\145\147\x69\163\164\x72\x61\164\x69\157\x6e\x5f\x73\150\157\x77\x5f\155\145\x73\163\x61\x67\x65", MoMessages::showMessage(MoMessages::EMAIL_TEMPLATE_SAVED), "\123\125\103\x43\105\x53\123");
    }
    public function showConfigurationPage($i4)
    {
        $Fy = get_mo_option("\x63\165\163\164\157\x6d\137\163\x6d\x73\137\155\163\x67") ? get_mo_option("\x63\x75\x73\164\157\x6d\137\x73\x6d\x73\x5f\155\x73\x67") : MoMessages::showMessage(MoMessages::DEFAULT_SMS_TEMPLATE);
        $Fy = mo_($Fy);
        $gs = get_mo_option("\143\x75\x73\x74\x6f\155\137\x73\x6d\x73\137\x67\141\x74\145\x77\141\x79") ? get_mo_option("\143\165\163\164\x6f\x6d\x5f\x73\155\x73\x5f\x67\x61\164\x65\x77\141\x79") : '';
        $hs = get_mo_option("\x63\165\163\164\x6f\155\137\x65\155\x61\x69\x6c\137\x73\x75\142\x6a\145\x63\164") ? get_mo_option("\143\x75\x73\x74\x6f\x6d\x5f\x65\x6d\141\151\x6c\137\163\x75\142\152\x65\x63\164") : MoMessages::showMessage(MoMessages::EMAIL_SUBJECT);
        $v1 = get_mo_option("\143\165\x73\x74\x6f\155\137\x65\x6d\141\151\154\x5f\x66\162\x6f\155\137\x69\x64") ? get_mo_option("\143\165\x73\x74\157\155\x5f\145\x6d\x61\151\x6c\137\x66\x72\157\155\137\151\144") : get_mo_option("\141\x64\155\x69\156\x5f\x65\x6d\141\151\x6c");
        $FX = get_mo_option("\x63\x75\x73\x74\x6f\x6d\x5f\x65\x6d\x61\151\x6c\137\x66\x72\157\155\137\x6e\x61\155\145") ? get_mo_option("\x63\165\163\x74\x6f\x6d\137\145\155\x61\x69\x6c\x5f\146\162\157\x6d\137\x6e\x61\x6d\x65") : get_bloginfo("\x6e\x61\155\x65");
        $H1 = get_mo_option("\x63\165\163\164\157\x6d\x5f\x65\155\141\x69\154\x5f\155\x73\147") ? stripslashes(get_mo_option("\x63\x75\x73\164\157\x6d\x5f\x65\x6d\141\151\x6c\137\x6d\x73\147")) : MoMessages::showMessage(MoMessages::DEFAULT_EMAIL_TEMPLATE);
        $hY = "\x63\165\163\x74\157\155\x65\155\x61\151\x6c\145\144\151\164\x6f\162";
        $F4 = array("\155\145\144\151\141\x5f\x62\165\164\x74\x6f\156\163" => false, "\x74\x65\170\x74\141\162\x65\x61\137\156\x61\x6d\x65" => "\155\x6f\137\x63\x75\163\x74\157\x6d\x65\162\137\x76\141\x6c\151\144\141\164\x69\157\156\137\143\x75\x73\164\x6f\155\x5f\x65\155\x61\x69\154\x5f\x6d\163\x67", "\145\144\151\x74\x6f\162\137\150\x65\x69\x67\150\164" => "\x31\67\x30\x70\170", "\x77\160\x61\x75\164\157\160" => false);
        $yJ = MoOTPActionHandlerHandler::instance();
        $jG = $yJ->getNonceValue();
        $sB = wp_nonce_field($jG);
        $L9 = mo_("\x53\x4d\123\x20\103\x4f\116\106\x49\x47\x55\x52\x41\124\x49\x4f\x4e");
        $Sa = mo_("\123\115\123\40\124\145\x6d\x70\x6c\141\x74\145");
        $nr = mo_("\x45\x6e\164\x65\162\x20\117\124\x50\x20\123\115\x53\40\x4d\x65\163\163\x61\147\145");
        $Xe = mo_("\x45\156\x74\x65\162\x20\171\157\165\162\x20\123\115\x53\40\x67\141\164\x65\x77\x61\171\x20\125\x52\114");
        $Dr = mo_("\123\x4d\123\x20\107\x61\x74\145\x77\x61\x79\x20\125\x52\114");
        $pN = mo_("\x59\x6f\165\40\156\x65\x65\x64\40\x74\x6f\x20\167\x72\x69\164\x65\40\43\43\x6f\x74\x70\x23\x23\x20\x77\150\145\162\x65\40\171\157\165\40\x77\151\163\150\x20\164\x6f\40\x70\154\x61\x63\x65\x20\147\145\x6e\x65\162\x61\164\x65\x64\x20\157\x74\160\40\x69\x6e\40\164\x68\151\163\40\164\x65\x6d\160\154\x61\164\145\x2e");
        $ZS = mo_("\131\x6f\165\x20\x77\151\154\x6c\x20\x6e\145\145\144\40\164\157\x20\160\x6c\141\143\x65\40\x79\157\x75\x72\40\123\x4d\123\x20\147\141\164\x65\167\141\171\x20\125\x52\114\x20\x69\156\40\x74\x68\x65\40\146\151\145\154\144\40\x61\x62\157\166\145\40\x69\x6e\40\x6f\x72\144\x65\162\40\x74\157\x20\x62\145\40\12\40\40\40\40\x20\40\x20\x20\40\40\x20\40\40\40\40\x20\40\x20\40\40\40\x20\40\x20\40\40\40\x20\40\40\x20\40\x20\40\x20\40\x61\142\x6c\145\40\164\157\40\x73\145\156\144\x20\x4f\124\120\x73\40\164\x6f\40\164\150\145\40\165\x73\x65\x72\x27\163\40\x70\x68\x6f\156\145\x2e") . "\74\142\162\x2f\x3e" . mo_("\131\157\x75\x20\167\151\154\154\40\x62\x65\40\x61\142\154\x65\x20\x74\x6f\40\x67\145\x74\x20\164\150\151\x73\x20\125\x52\114\x20\x66\x72\157\155\x20\x79\157\x75\x72\40\123\115\123\40\147\x61\x74\145\x77\141\x79\x20\160\x72\157\x76\151\144\145\x72\x2e");
        $kD = mo_("\x49\x66\40\x79\x6f\165\x20\x61\162\145\40\150\x61\166\151\156\x67\x20\x74\x72\157\165\x62\154\145\x20\151\x6e\x20\146\x69\156\144\x69\156\x67\40\x79\x6f\x75\x72\40\x67\141\164\145\x77\141\x79\x20\125\x52\x4c\40\164\x68\145\x6e\x20\171\x6f\x75\x20\144\162\157\160\x20\x75\163\40\141\x6e\x20\xa\40\x20\x20\x20\40\x20\x20\x20\x20\40\x20\40\40\40\40\40\40\x20\x20\x20\40\x20\x20\40\40\x20\40\x20\40\x20\40\40\40\x20\x20\40\145\x6d\x61\151\154\x20\x61\164\x20" . MoConstants::FEEDBACK_EMAIL . "\x2e\x20\127\x65\40\x77\151\154\x6c\40\150\145\x6c\160\40\171\157\165\x20\167\151\164\x68\x20\x74\x68\x65\x20\163\x65\164\165\160\56");
        $qn = "\x45\x78\x61\x6d\160\x6c\x65\72\x2d\40\150\164\164\160\72\x2f\57\x61\154\145\x72\164\x73\56\163\151\156\146\151\156\x69\x2e\143\x6f\155\57\x61\x70\151\57\x77\145\x62\62\x73\155\163\x2e\160\x68\160\165\163\145\162\x6e\x61\x6d\x65\75\x58\x59\x5a\46\x70\141\x73\x73\167\x6f\x72\144\x3d\x70\141\x73\x73\x77\157\x72\x64\46\164\x6f\75\x23\x23\x70\150\157\x6e\145\43\43\46\163\x65\x6e\x64\145\162\x3d\x73\x65\156\144\x65\162\151\x64\x26\x6d\145\163\x73\141\147\145\75\43\43\155\145\163\x73\141\x67\145\43\x23";
        $mt = mo_("\x43\101\x4e\x4e\x4f\124\x20\x46\x49\116\104\40\124\110\x45\40\x47\101\x54\105\x57\101\x59\x20\125\x52\x4c\x3f");
        $L_ = mo_("\123\x61\x76\x65\x20\x53\x4d\x53\x20\103\157\156\x66\151\x67\165\x72\141\x74\x69\x6f\156\163");
        $Zj = mo_("\105\x4d\101\x49\114\x20\103\117\x4e\106\x49\x47\x55\x52\x41\124\x49\117\x4e");
        $lj = mo_("\x59\157\x75\x20\x6e\x65\x65\144\40\x74\157\40\x63\157\156\146\x69\x67\x75\162\145\x20\171\x6f\x75\x72\x20\x70\150\160\56\151\156\151\40\146\151\x6c\x65\40\x77\x69\x74\150\x20\123\115\x54\120\x20\163\145\x74\164\151\x6e\x67\163\40\x74\157\40\x62\x65\x20\141\x62\154\145\40\x74\157\40\163\145\x6e\144\x20\x65\x6d\x61\151\154\x73\x2e");
        $k2 = mo_("\x53\x61\x76\x65\x20\105\x6d\x61\151\154\40\103\x6f\x6e\146\151\147\165\162\141\164\x69\x6f\x6e\163");
        $un = mo_("\105\x6e\x74\x65\x72\40\x79\157\165\162\40\117\124\120\40\x45\155\x61\151\x6c\x20\123\x75\x62\152\145\143\x74");
        $lm = mo_("\105\156\164\x65\x72\x20\116\x61\x6d\145");
        $En = mo_("\x45\x6e\x74\x65\162\x20\x65\x6d\141\x69\154\40\x61\x64\x64\162\145\x73\163");
        $vg = mo_("\106\x72\157\155\40\111\x44");
        $ef = mo_("\106\162\157\155\40\x4e\141\155\x65");
        $Zo = mo_("\123\165\142\152\x65\x63\x74");
        $JH = mo_("\x42\x6f\x64\x79");
        include MOV_DIR . "\x76\151\x65\167\x73\57\143\x63\157\156\x66\x69\x67\165\x72\x61\164\151\x6f\x6e\x2e\160\x68\x70";
    }
    public function mo_send_otp_token($s7, $Vy, $l1)
    {
        if (MO_TEST_MODE) {
            goto FR;
        }
        $H1 = $this->send_otp_token($s7, $Vy, $l1);
        return json_decode($H1, TRUE);
        goto uS;
        FR:
        return array("\163\x74\x61\164\165\x73" => "\x53\125\103\103\x45\x53\x53", "\164\x78\x49\144" => MoUtility::rand());
        uS:
    }
    public function mo_send_notif(NotificationSettings $Sc)
    {
        $PG = $Sc->sendSMS ? self::send_sms_token($Sc->message, $Sc->phoneNumber) : self::send_email_token($Sc->message, $Sc->toEmail, $Sc->fromEmail, $Sc->subject);
        return !is_null($PG) ? json_encode(array("\x73\x74\x61\x74\x75\163" => "\123\x55\x43\x43\105\123\x53")) : json_encode(array("\163\x74\x61\x74\165\163" => "\105\x52\122\117\122"));
    }
    private function send_otp_token($s7, $Vy = null, $l1 = null)
    {
        $SX = get_mo_option("\x6f\x74\x70\137\154\145\x6e\147\x74\150") ? get_mo_option("\157\x74\160\x5f\154\145\x6e\147\x74\x68") : 5;
        $fk = wp_rand(pow(10, $SX - 1), pow(10, $SX) - 1);
        $X5 = get_mo_option("\x61\144\155\151\156\137\x63\165\x73\164\x6f\155\145\162\137\x6b\x65\171");
        $ZQ = $X5 . $fk;
        $pv = hash("\163\x68\x61\x35\61\62", $ZQ);
        $PG = self::httpRequest($s7, $fk, $Vy, $l1);
        if ($PG) {
            goto I0;
        }
        $H1 = array("\x73\x74\x61\164\165\x73" => "\x46\101\111\114\x55\122\x45");
        goto ex;
        I0:
        MoPHPSessions::addSessionVar("\155\x6f\137\157\x74\x70\164\x6f\x6b\145\x6e", true);
        MoPHPSessions::addSessionVar("\x73\x65\x6e\164\x5f\x6f\x6e", time());
        $H1 = array("\163\x74\x61\164\165\163" => "\123\x55\103\x43\x45\123\123", "\x74\x78\x49\x64" => $pv);
        ex:
        return json_encode($H1);
    }
    private function httpRequest($s7, $fk, $Vy = null, $l1 = null)
    {
        $PG = null;
        switch ($s7) {
            case "\123\115\123":
                $Tg = get_mo_option("\x63\x75\x73\x74\x6f\x6d\137\163\155\163\x5f\x6d\163\x67") ? mo_(get_mo_option("\143\165\x73\x74\x6f\x6d\137\163\x6d\x73\137\155\x73\x67")) : mo_(MoMessages::showMessage(MoMessages::DEFAULT_SMS_TEMPLATE));
                $Tg = mo_($Tg);
                $Tg = str_replace("\43\43\x6f\x74\x70\x23\x23", $fk, $Tg);
                $PG = $this->send_sms_token($Tg, $l1);
                goto vy;
            case "\105\x4d\101\111\x4c":
                $Tg = get_mo_option("\x63\x75\163\164\157\x6d\137\x65\155\x61\151\x6c\137\x6d\163\x67") ? mo_(get_mo_option("\x63\165\x73\x74\157\x6d\137\x65\155\141\x69\154\x5f\155\163\x67")) : mo_(MoMessages::showMessage(MoMessages::DEFAULT_EMAIL_TEMPLATE));
                $Tg = mo_($Tg);
                $Tg = stripslashes($Tg);
                $Tg = str_replace("\x23\x23\x6f\x74\x70\43\43", $fk, $Tg);
                $wk = get_mo_option("\x63\165\x73\164\x6f\155\137\145\x6d\x61\151\x6c\x5f\146\x72\x6f\x6d\137\x69\x64");
                $Zo = get_mo_option("\x63\x75\163\164\157\155\137\x65\x6d\x61\x69\154\137\163\x75\x62\152\x65\x63\x74");
                $Y6 = get_mo_option("\x63\x75\163\x74\x6f\155\137\145\155\141\x69\x6c\137\x66\x72\157\155\x5f\156\141\x6d\145");
                $PG = $this->send_email_token($Tg, $Vy, $wk, $Zo, $Y6);
                goto vy;
        }
        HJ:
        vy:
        return $PG;
    }
    private function send_sms_token($Tg, $l1)
    {
        $u1 = get_mo_option("\143\165\x73\x74\x6f\155\x5f\x73\155\x73\x5f\147\x61\164\x65\x77\141\x79");
        $Tg = str_replace("\x20", "\x2b", $Tg);
        $u1 = str_replace("\x23\43\x6d\x65\x73\x73\x61\147\x65\x23\x23", $Tg, $u1);
        $u1 = str_replace("\43\43\x70\x68\x6f\x6e\x65\43\43", apply_filters("\155\157\137\146\x69\x6c\164\145\x72\x5f\x70\x68\157\156\x65\137\142\x65\x66\157\162\145\x5f\x61\x70\151\x5f\x63\141\154\154", $l1), $u1);
        $u1 = apply_filters("\143\165\163\x74\x6f\x6d\x69\x7a\x65\137\157\x74\x70\x5f\165\x72\x6c\137\x62\145\x66\157\162\145\x5f\141\x70\151\137\143\141\x6c\154", $u1, $Tg, apply_filters("\155\x6f\x5f\x66\151\x6c\164\145\162\137\x70\x68\157\156\145\x5f\142\145\x66\x6f\162\x65\137\141\x70\x69\137\x63\x61\x6c\x6c", $l1));
        $PG = MocURLOTP::callAPI($u1, null, null);
        return $PG;
    }
    private function send_email_token($Tg, $Vy, $wk = null, $Zo = null, $Y6 = null)
    {
        $wk = !MoUtility::isBlank($wk) ? $wk : MoConstants::FROM_EMAIL;
        $Zo = !MoUtility::isBlank($Zo) ? $Zo : MoMessages::showMessage(MoMessages::EMAIL_SUBJECT);
        $Y6 = !MoUtility::isBlank($Y6) ? $Y6 : $wk;
        $W0 = "\x46\162\157\x6d\72" . $Y6 . "\40\x3c" . $wk . "\x3e\x20\12";
        $W0 .= MoConstants::HEADER_CONTENT_TYPE;
        $H1 = $Tg;
        return ini_get("\x53\x4d\124\x50") != FALSE || ini_get("\163\155\164\160\x5f\160\157\162\164") != FALSE ? wp_mail($Vy, $Zo, $H1, $W0) : false;
    }
    public function mo_validate_otp_token($Cz, $NH)
    {
        return MO_TEST_MODE ? MO_FAIL_MODE ? array("\163\164\141\164\x75\163" => '') : array("\163\164\141\x74\x75\x73" => "\x53\125\x43\x43\105\x53\123") : $this->validate_otp_token($Cz, $NH);
    }
    private function validate_otp_token($pv, $UE)
    {
        $X5 = get_mo_option("\x61\x64\x6d\x69\x6e\x5f\x63\165\163\164\157\155\145\x72\x5f\153\145\171");
        if (MoPHPSessions::getSessionVar("\x6d\x6f\137\157\x74\160\164\x6f\153\145\x6e")) {
            goto eW;
        }
        $H1 = array("\x73\x74\141\x74\x75\x73" => MoConstants::FAILURE);
        goto QE;
        eW:
        $a_ = $this->checkTimeStamp(MoPHPSessions::getSessionVar("\163\145\x6e\x74\x5f\x6f\156"), time());
        $a_ = $this->checkTransactionId($X5, $UE, $pv, $a_);
        if ($a_) {
            goto Oh;
        }
        $H1 = array("\163\164\x61\164\165\163" => MoConstants::FAILURE);
        goto vJ;
        Oh:
        $H1 = array("\163\164\x61\x74\165\163" => MoConstants::SUCCESS);
        vJ:
        MoPHPSessions::unsetSession("\x24\x6d\x6f\x5f\x6f\164\160\x74\157\153\145\156");
        QE:
        return $H1;
    }
    private function checkTimeStamp($AY, $ch)
    {
        $cE = get_mo_option("\x6f\x74\x70\x5f\166\141\154\151\x64\x69\164\x79") ? get_mo_option("\x6f\x74\160\x5f\x76\x61\154\x69\144\151\x74\x79") : 5;
        $MF = round(abs($ch - $AY) / 60, 2);
        return $MF > $cE ? false : true;
    }
    private function checkTransactionId($X5, $UE, $pv, $a_)
    {
        if ($a_) {
            goto zU;
        }
        return false;
        zU:
        $ZQ = $X5 . $UE;
        $Yd = hash("\x73\x68\141\x35\61\62", $ZQ);
        return $Yd === $pv;
    }
}
