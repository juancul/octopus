<?php


namespace OTP\Helper;

use OTP\Objects\NotificationSettings;
if (defined("\x41\x42\x53\x50\101\x54\110")) {
    goto zA;
}
die;
zA:
class MocURLOTP
{
    public static function create_customer($Vy, $nP, $eW, $l1 = '', $Lp = '', $bN = '')
    {
        $u1 = MoConstants::HOSTNAME . "\x2f\155\x6f\x61\163\57\162\x65\163\x74\x2f\x63\165\163\x74\x6f\155\x65\x72\57\141\144\x64";
        $X5 = MoConstants::DEFAULT_CUSTOMER_KEY;
        $EO = MoConstants::DEFAULT_API_KEY;
        $K_ = array("\x63\x6f\x6d\x70\141\156\x79\116\x61\x6d\145" => $nP, "\141\x72\145\x61\x4f\x66\111\156\x74\145\x72\x65\163\x74" => MoConstants::AREA_OF_INTEREST, "\x66\151\162\163\164\x6e\x61\x6d\145" => $Lp, "\154\x61\163\x74\x6e\x61\x6d\x65" => $bN, "\145\x6d\141\151\x6c" => $Vy, "\160\150\x6f\156\x65" => $l1, "\x70\x61\163\x73\x77\x6f\162\x64" => $eW);
        $oX = json_encode($K_);
        $D6 = self::createAuthHeader($X5, $EO);
        $PG = self::callAPI($u1, $oX, $D6);
        return $PG;
    }
    public static function get_customer_key($Vy, $eW)
    {
        $u1 = MoConstants::HOSTNAME . "\x2f\x6d\x6f\141\163\x2f\x72\145\163\164\x2f\143\165\x73\164\x6f\155\x65\162\57\153\x65\x79";
        $X5 = MoConstants::DEFAULT_CUSTOMER_KEY;
        $EO = MoConstants::DEFAULT_API_KEY;
        $K_ = array("\145\155\141\151\x6c" => $Vy, "\x70\x61\163\163\x77\x6f\x72\x64" => $eW);
        $oX = json_encode($K_);
        $D6 = self::createAuthHeader($X5, $EO);
        $PG = self::callAPI($u1, $oX, $D6);
        return $PG;
    }
    public static function check_customer($Vy)
    {
        $u1 = MoConstants::HOSTNAME . "\57\x6d\x6f\141\163\57\x72\x65\163\164\x2f\143\165\x73\x74\x6f\x6d\145\x72\57\x63\x68\x65\143\153\x2d\151\x66\55\x65\170\151\x73\x74\x73";
        $X5 = MoConstants::DEFAULT_CUSTOMER_KEY;
        $EO = MoConstants::DEFAULT_API_KEY;
        $K_ = array("\x65\x6d\x61\x69\x6c" => $Vy);
        $oX = json_encode($K_);
        $D6 = self::createAuthHeader($X5, $EO);
        $PG = self::callAPI($u1, $oX, $D6);
        return $PG;
    }
    public static function mo_send_otp_token($fi, $Vy = '', $l1 = '')
    {
        $u1 = MoConstants::HOSTNAME . "\x2f\x6d\157\141\x73\x2f\x61\x70\x69\57\141\x75\164\x68\57\x63\x68\x61\x6c\x6c\145\x6e\x67\x65";
        $X5 = !MoUtility::isBlank(get_mo_option("\x61\144\155\x69\x6e\x5f\x63\x75\163\164\157\155\x65\162\x5f\x6b\145\x79")) ? get_mo_option("\141\144\155\151\156\x5f\x63\165\163\164\157\x6d\x65\x72\x5f\153\145\x79") : MoConstants::DEFAULT_CUSTOMER_KEY;
        $EO = !MoUtility::isBlank(get_mo_option("\x61\x64\x6d\151\156\137\x61\160\151\137\x6b\x65\x79")) ? get_mo_option("\x61\144\x6d\x69\156\137\x61\160\151\137\x6b\145\x79") : MoConstants::DEFAULT_API_KEY;
        $K_ = array("\143\165\163\164\x6f\x6d\145\162\x4b\x65\171" => $X5, "\145\x6d\141\x69\x6c" => $Vy, "\x70\x68\x6f\156\145" => $l1, "\x61\165\x74\x68\x54\x79\160\x65" => $fi, "\164\x72\x61\x6e\163\x61\x63\164\x69\157\x6e\116\x61\x6d\145" => MoConstants::AREA_OF_INTEREST);
        $oX = json_encode($K_);
        $D6 = self::createAuthHeader($X5, $EO);
        $PG = self::callAPI($u1, $oX, $D6);
        return $PG;
    }
    public static function validate_otp_token($pv, $UE)
    {
        $u1 = MoConstants::HOSTNAME . "\x2f\x6d\157\x61\x73\x2f\x61\x70\151\x2f\x61\x75\164\x68\57\x76\x61\x6c\151\144\141\164\145";
        $X5 = !MoUtility::isBlank(get_mo_option("\141\x64\155\x69\156\x5f\x63\x75\x73\164\x6f\155\145\x72\137\153\x65\171")) ? get_mo_option("\x61\x64\x6d\151\156\137\x63\165\x73\164\x6f\x6d\145\162\137\153\x65\171") : MoConstants::DEFAULT_CUSTOMER_KEY;
        $EO = !MoUtility::isBlank(get_mo_option("\x61\144\x6d\151\156\137\x61\160\x69\137\153\145\x79")) ? get_mo_option("\x61\x64\155\151\x6e\137\141\160\x69\137\x6b\145\171") : MoConstants::DEFAULT_API_KEY;
        $K_ = array("\164\170\x49\x64" => $pv, "\x74\157\x6b\x65\x6e" => $UE);
        $oX = json_encode($K_);
        $D6 = self::createAuthHeader($X5, $EO);
        $PG = self::callAPI($u1, $oX, $D6);
        return $PG;
    }
    public static function submit_contact_us($IB, $oJ, $Zy)
    {
        $current_user = wp_get_current_user();
        $u1 = MoConstants::HOSTNAME . "\57\155\x6f\141\163\57\x72\x65\x73\164\x2f\143\165\x73\164\x6f\155\x65\x72\x2f\x63\x6f\x6e\x74\x61\143\x74\55\x75\163";
        $Zy = "\x5b" . MoConstants::AREA_OF_INTEREST . "\40" . "\x28" . MoConstants::PLUGIN_TYPE . "\51" . "\135\72\40" . $Zy;
        $X5 = !MoUtility::isBlank(get_mo_option("\141\x64\155\x69\156\x5f\x63\165\x73\x74\x6f\x6d\x65\x72\137\153\145\171")) ? get_mo_option("\141\144\155\151\x6e\137\x63\165\163\164\x6f\155\145\x72\137\153\145\x79") : MoConstants::DEFAULT_CUSTOMER_KEY;
        $EO = !MoUtility::isBlank(get_mo_option("\x61\x64\x6d\x69\156\137\x61\x70\151\x5f\x6b\145\x79")) ? get_mo_option("\x61\x64\155\151\156\137\x61\160\x69\137\x6b\145\171") : MoConstants::DEFAULT_API_KEY;
        $K_ = array("\146\151\x72\163\164\116\141\155\x65" => $current_user->user_firstname, "\154\141\163\x74\x4e\x61\x6d\x65" => $current_user->user_lastname, "\x63\x6f\155\160\141\x6e\x79" => $_SERVER["\123\105\122\x56\105\122\x5f\x4e\101\115\105"], "\145\155\141\151\154" => $IB, "\143\143\105\155\141\x69\x6c" => MoConstants::FEEDBACK_EMAIL, "\x70\150\157\x6e\x65" => $oJ, "\x71\x75\x65\162\171" => $Zy);
        $Ak = json_encode($K_);
        $D6 = self::createAuthHeader($X5, $EO);
        $PG = self::callAPI($u1, $Ak, $D6);
        return true;
    }
    public static function forgot_password($Vy)
    {
        $u1 = MoConstants::HOSTNAME . "\x2f\155\x6f\x61\163\x2f\x72\145\x73\164\57\143\165\163\x74\x6f\x6d\x65\162\57\x70\x61\163\163\x77\157\162\x64\55\x72\x65\163\x65\x74";
        $X5 = get_mo_option("\141\x64\x6d\151\156\x5f\x63\x75\163\x74\157\155\x65\162\x5f\x6b\145\x79");
        $EO = get_mo_option("\x61\144\x6d\x69\x6e\x5f\141\160\151\x5f\153\x65\x79");
        $K_ = array("\x65\155\x61\151\154" => $Vy);
        $oX = json_encode($K_);
        $D6 = self::createAuthHeader($X5, $EO);
        $PG = self::callAPI($u1, $oX, $D6);
        return $PG;
    }
    public static function check_customer_ln($X5, $EO, $hf)
    {
        $u1 = MoConstants::HOSTNAME . "\57\155\x6f\x61\163\57\162\145\x73\x74\x2f\x63\165\163\x74\x6f\x6d\145\162\x2f\x6c\x69\x63\145\156\x73\x65";
        $K_ = array("\143\165\x73\164\x6f\155\145\162\x49\x64" => $X5, "\141\160\160\x6c\151\x63\x61\164\151\x6f\x6e\116\141\x6d\x65" => $hf, "\x6c\x69\x63\x65\156\x73\145\x54\171\160\x65" => !MoUtility::micr() ? "\104\105\115\x4f" : "\120\122\105\115\111\x55\115");
        $oX = json_encode($K_);
        $D6 = self::createAuthHeader($X5, $EO);
        $PG = self::callAPI($u1, $oX, $D6);
        return $PG;
    }
    public static function createAuthHeader($X5, $EO)
    {
        $Ft = self::getTimestamp();
        if (!MoUtility::isBlank($Ft)) {
            goto f1;
        }
        $Ft = round(microtime(true) * 1000);
        $Ft = number_format($Ft, 0, '', '');
        f1:
        $ZQ = $X5 . $Ft . $EO;
        $D6 = hash("\163\x68\141\65\61\62", $ZQ);
        $DI = array("\103\157\156\x74\x65\156\164\x2d\124\x79\x70\145" => "\x61\160\x70\154\x69\x63\141\x74\151\157\156\x2f\x6a\x73\x6f\156", "\x43\x75\x73\164\x6f\155\x65\x72\x2d\113\x65\x79" => $X5, "\x54\151\x6d\145\163\x74\141\155\160" => $Ft, "\x41\x75\164\x68\157\162\x69\x7a\x61\164\x69\x6f\x6e" => $D6);
        return $DI;
    }
    public static function getTimestamp()
    {
        $u1 = MoConstants::HOSTNAME . "\57\155\x6f\141\163\57\x72\145\x73\164\x2f\x6d\157\142\x69\154\145\57\x67\145\164\x2d\x74\x69\155\x65\x73\164\x61\x6d\x70";
        return self::callAPI($u1, null, null);
    }
    public static function callAPI($u1, $Kx, $W0 = array("\103\157\x6e\x74\x65\x6e\164\55\124\x79\160\145" => "\141\x70\160\154\151\143\x61\164\x69\x6f\x6e\x2f\x6a\163\x6f\x6e"), $yu = "\120\x4f\123\x54")
    {
        $Kc = array("\155\x65\x74\150\x6f\144" => $yu, "\142\157\144\171" => $Kx, "\x74\151\x6d\145\157\x75\x74" => "\x31\x30\x30\60\60", "\162\145\144\151\162\x65\143\164\151\157\156" => "\61\60", "\150\x74\x74\160\166\145\162\163\x69\157\x6e" => "\61\x2e\60", "\x62\154\157\x63\153\x69\x6e\147" => true, "\150\145\x61\x64\145\x72\x73" => $W0, "\x73\x73\154\166\145\x72\x69\x66\171" => MOV_SSL_VERIFY);
        $PG = wp_remote_post($u1, $Kc);
        if (!is_wp_error($PG)) {
            goto AU;
        }
        wp_die("\123\x6f\155\145\164\x68\x69\x6e\x67\x20\x77\x65\156\x74\x20\x77\162\157\x6e\147\72\x20\x3c\142\162\x2f\x3e\40{$PG->get_error_message()}");
        AU:
        return wp_remote_retrieve_body($PG);
    }
    public static function send_notif(NotificationSettings $Sc)
    {
        $vx = GatewayFunctions::instance();
        return $vx->mo_send_notif($Sc);
    }
}
