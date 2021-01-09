<?php


namespace OTP\Helper;

use OTP\Objects\NotificationSettings;
use OTP\Objects\TabDetails;
use OTP\Objects\Tabs;
use ReflectionClass;
use ReflectionException;
use stdClass;
if (defined("\101\x42\123\120\x41\x54\x48")) {
    goto RC;
}
die;
RC:
class MoUtility
{
    public static function get_hidden_phone($l1)
    {
        return "\x78\x78\x78\170\x78\x78\x78" . substr($l1, strlen($l1) - 3);
    }
    public static function isBlank($Xd)
    {
        return !isset($Xd) || empty($Xd);
    }
    public static function createJson($Tg, $qf)
    {
        return array("\x6d\x65\x73\163\141\x67\x65" => $Tg, "\162\145\x73\165\x6c\164" => $qf);
    }
    public static function mo_is_curl_installed()
    {
        return in_array("\x63\165\162\154", get_loaded_extensions());
    }
    public static function currentPageUrl()
    {
        $Hl = "\150\164\164\x70";
        if (!(isset($_SERVER["\x48\124\124\120\x53"]) && $_SERVER["\x48\124\x54\x50\123"] == "\157\x6e")) {
            goto wN;
        }
        $Hl .= "\163";
        wN:
        $Hl .= "\x3a\x2f\57";
        if ($_SERVER["\x53\105\122\x56\x45\122\137\120\x4f\122\x54"] != "\70\x30") {
            goto z2;
        }
        $Hl .= $_SERVER["\x53\105\x52\x56\x45\x52\137\x4e\101\115\x45"] . $_SERVER["\122\x45\121\125\x45\123\124\x5f\x55\122\111"];
        goto oQ;
        z2:
        $Hl .= $_SERVER["\x53\105\x52\x56\x45\122\x5f\116\101\115\105"] . "\x3a" . $_SERVER["\x53\x45\122\126\x45\x52\x5f\120\117\122\x54"] . $_SERVER["\x52\105\121\x55\x45\123\124\x5f\x55\x52\111"];
        oQ:
        if (!function_exists("\141\x70\x70\x6c\171\x5f\146\x69\154\164\x65\x72\163")) {
            goto VA;
        }
        apply_filters("\155\x6f\x5f\x63\165\162\x6c\x5f\x70\x61\x67\145\137\165\x72\154", $Hl);
        VA:
        return $Hl;
    }
    public static function getDomain($Vy)
    {
        return $lk = substr(strrchr($Vy, "\x40"), 1);
    }
    public static function validatePhoneNumber($l1)
    {
        return preg_match(MoConstants::PATTERN_PHONE, MoUtility::processPhoneNumber($l1), $Pm);
    }
    public static function isCountryCodeAppended($l1)
    {
        return preg_match(MoConstants::PATTERN_COUNTRY_CODE, $l1, $Pm) ? true : false;
    }
    public static function processPhoneNumber($l1)
    {
        $l1 = preg_replace(MoConstants::PATTERN_SPACES_HYPEN, '', ltrim(trim($l1), "\x30"));
        $xI = CountryList::getDefaultCountryCode();
        $l1 = !isset($xI) || MoUtility::isCountryCodeAppended($l1) ? $l1 : $xI . $l1;
        return apply_filters("\x6d\x6f\x5f\160\162\x6f\143\145\x73\x73\137\160\150\x6f\x6e\x65", $l1);
    }
    public static function micr()
    {
        $Vy = get_mo_option("\141\x64\155\151\x6e\137\145\x6d\141\x69\x6c");
        $X5 = get_mo_option("\141\x64\155\151\156\x5f\x63\165\x73\x74\157\155\145\x72\x5f\x6b\145\171");
        if (!$Vy || !$X5 || !is_numeric(trim($X5))) {
            goto Ki;
        }
        return 1;
        goto dJ;
        Ki:
        return 0;
        dJ:
    }
    public static function rand()
    {
        $iD = wp_rand(0, 15);
        $cb = "\x30\61\62\x33\x34\65\x36\x37\x38\x39\141\x62\x63\x64\x65\146\x67\150\x69\x6a\x6b\154\x6d\156\157\160\x71\x72\x73\164\x75\166\x77\170\171\x7a\101\102\103\104\105\x46\x47\x48\x49\x4a\113\114\115\116\x4f\x50\121\x52\123\124\125\x56\127\130\x59\132";
        $rg = '';
        $IV = 0;
        ik:
        if (!($IV < $iD)) {
            goto In;
        }
        $rg .= $cb[wp_rand(0, strlen($cb) - 1)];
        bw:
        $IV++;
        goto ik;
        In:
        return $rg;
    }
    public static function micv()
    {
        $Vy = get_mo_option("\x61\144\155\x69\156\137\x65\155\x61\151\154");
        $X5 = get_mo_option("\x61\144\155\x69\x6e\137\143\165\163\x74\157\155\145\162\x5f\153\x65\171");
        $Ly = get_mo_option("\143\150\145\x63\153\137\154\156");
        if (!$Vy || !$X5 || !is_numeric(trim($X5))) {
            goto QA;
        }
        return $Ly ? $Ly : 0;
        goto rH;
        QA:
        return 0;
        rH:
    }
    public static function _handle_mo_check_ln($cw, $X5, $EO)
    {
        $Zw = MoMessages::FREE_PLAN_MSG;
        $ml = array();
        $vx = GatewayFunctions::instance();
        $H1 = json_decode(MocURLOTP::check_customer_ln($X5, $EO, $vx->getApplicationName()), true);
        if (strcasecmp($H1["\163\164\141\164\165\x73"], "\123\125\103\x43\105\x53\123") == 0) {
            goto Yl;
        }
        $H1 = json_decode(MocURLOTP::check_customer_ln($X5, $EO, "\167\160\137\x65\x6d\x61\x69\154\x5f\x76\x65\162\151\x66\x69\143\x61\x74\151\157\156\x5f\x69\x6e\164\x72\141\156\145\x74"), true);
        if (!MoUtility::sanitizeCheck("\x6c\151\x63\145\156\163\145\x50\154\x61\156", $H1)) {
            goto F1;
        }
        $Zw = MoMessages::INSTALL_PREMIUM_PLUGIN;
        F1:
        goto OT;
        Yl:
        if (!MoUtility::sanitizeCheck("\154\x69\x63\x65\156\163\145\120\x6c\141\156", $H1)) {
            goto p6;
        }
        $Zw = MoMessages::UPGRADE_MSG;
        $ml = array("\160\154\141\x6e" => $H1["\154\x69\143\145\x6e\x73\x65\x50\154\x61\x6e"]);
        update_mo_option("\143\x68\x65\x63\x6b\x5f\154\156", base64_encode($H1["\154\x69\x63\x65\x6e\163\x65\120\x6c\x61\x6e"]));
        p6:
        $Ul = isset($H1["\x65\x6d\141\x69\x6c\x52\x65\155\141\151\x6e\151\156\x67"]) ? $H1["\x65\155\x61\151\x6c\122\145\x6d\141\x69\156\x69\156\x67"] : 0;
        $GA = isset($H1["\163\155\163\122\x65\155\x61\151\156\151\156\147"]) ? $H1["\163\155\163\x52\145\155\x61\x69\156\151\156\147"] : 0;
        update_mo_option("\145\x6d\141\x69\x6c\x5f\x74\x72\x61\x6e\x73\141\x63\164\151\157\x6e\163\x5f\x72\145\x6d\141\x69\156\x69\x6e\147", $Ul);
        update_mo_option("\x70\x68\x6f\156\x65\137\164\162\x61\x6e\163\141\143\164\x69\157\x6e\x73\137\162\x65\x6d\141\151\156\151\156\x67", $GA);
        OT:
        if (!$cw) {
            goto bf;
        }
        do_action("\x6d\x6f\x5f\x72\145\x67\151\x73\164\x72\141\164\151\x6f\156\x5f\x73\x68\x6f\167\137\155\145\x73\163\x61\x67\145", MoMessages::showMessage($Zw, $ml), "\x53\125\103\x43\105\x53\x53");
        bf:
    }
    public static function initialize_transaction($form)
    {
        $Lj = new ReflectionClass(FormSessionVars::class);
        foreach ($Lj->getConstants() as $O5 => $Xd) {
            MoPHPSessions::unsetSession($Xd);
            yJ:
        }
        hN:
        SessionUtils::initializeForm($form);
    }
    public static function _get_invalid_otp_method()
    {
        return get_mo_option("\x69\x6e\166\141\154\151\x64\137\155\x65\163\163\141\147\145", "\x6d\157\x5f\x6f\164\x70\x5f") ? mo_(get_mo_option("\151\156\x76\x61\154\151\x64\x5f\155\145\163\163\x61\147\x65", "\155\157\137\157\164\160\137")) : MoMessages::showMessage(MoMessages::INVALID_OTP);
    }
    public static function _is_polylang_installed()
    {
        return function_exists("\x70\x6c\x6c\137\137") && function_exists("\160\154\154\x5f\162\x65\147\151\x73\164\x65\x72\x5f\163\x74\162\x69\156\147");
    }
    public static function replaceString(array $GD, $GM)
    {
        foreach ($GD as $O5 => $Xd) {
            $GM = str_replace("\173" . $O5 . "\175", $Xd, $GM);
            Iy:
        }
        qZ:
        return $GM;
    }
    private static function testResult()
    {
        $xw = new stdClass();
        $xw->status = MO_FAIL_MODE ? "\105\122\x52\x4f\122" : "\x53\x55\x43\103\105\x53\x53";
        return $xw;
    }
    public static function send_phone_notif($NZ, $Zw)
    {
        $Mz = function ($NZ, $Zw) {
            return json_decode(MocURLOTP::send_notif(new NotificationSettings($NZ, $Zw)));
        };
        $NZ = MoUtility::processPhoneNumber($NZ);
        $Zw = self::replaceString(array("\160\150\157\x6e\x65" => str_replace("\53", '', "\45\62\x42" . $NZ)), $Zw);
        $H1 = MO_TEST_MODE ? self::testResult() : $Mz($NZ, $Zw);
        return strcasecmp($H1->status, "\123\x55\103\x43\105\x53\123") == 0 ? true : false;
    }
    public static function send_email_notif($wk, $Y6, $yw, $Zo, $Tg)
    {
        $Mz = function ($wk, $Y6, $yw, $Zo, $Tg) {
            $Gp = new NotificationSettings($wk, $Y6, $yw, $Zo, $Tg);
            return json_decode(MocURLOTP::send_notif($Gp));
        };
        $H1 = MO_TEST_MODE ? self::testResult() : $Mz($wk, $Y6, $yw, $Zo, $Tg);
        return strcasecmp($H1->status, "\123\x55\103\103\x45\123\x53") == 0 ? true : false;
    }
    public static function sanitizeCheck($O5, $lb)
    {
        if (is_array($lb)) {
            goto JB;
        }
        return $lb;
        JB:
        $Xd = !array_key_exists($O5, $lb) || self::isBlank($lb[$O5]) ? false : $lb[$O5];
        return is_array($Xd) ? $Xd : sanitize_text_field($Xd);
    }
    public static function mclv()
    {
        $vx = GatewayFunctions::instance();
        return $vx->mclv();
    }
    public static function isMG()
    {
        $vx = GatewayFunctions::instance();
        return $vx->isMG();
    }
    public static function areFormOptionsBeingSaved($x7)
    {
        return current_user_can("\155\141\x6e\x61\147\x65\137\x6f\x70\164\x69\x6f\156\x73") && self::micr() && self::mclv() && isset($_POST["\x6f\160\x74\151\x6f\x6e"]) && $x7 == $_POST["\x6f\160\164\x69\x6f\x6e"];
    }
    public static function is_addon_activated()
    {
        if (!(self::micr() && self::mclv())) {
            goto Zl;
        }
        return;
        Zl:
        $l4 = TabDetails::instance();
        $b5 = add_query_arg(array("\x70\x61\147\x65" => $l4->_tabDetails[Tabs::ACCOUNT]->_menuSlug), remove_query_arg("\141\x64\144\x6f\156", $_SERVER["\122\105\121\125\105\123\124\x5f\x55\122\111"]));
        echo "\x3c\144\x69\166\x20\x73\x74\x79\154\x65\75\42\x64\x69\163\x70\154\141\171\x3a\x62\x6c\157\143\x6b\73\155\141\x72\x67\x69\156\55\164\157\x70\72\61\x30\160\x78\x3b\143\157\154\157\162\72\162\x65\x64\x3b\142\141\x63\153\x67\162\x6f\165\x6e\144\x2d\143\x6f\154\157\162\72\x72\x67\142\141\50\62\x35\x31\x2c\40\x32\63\62\54\x20\60\54\x20\60\56\61\x35\x29\x3b\12\11\x9\11\11\11\x9\11\11\160\141\144\x64\151\156\147\x3a\x35\160\170\73\x62\157\x72\144\145\x72\x3a\163\x6f\x6c\x69\x64\40\x31\x70\170\x20\162\x67\x62\x61\x28\62\65\65\x2c\x20\x30\54\40\71\x2c\40\60\x2e\x33\66\51\73\42\x3e\12\11\x9\11\40\x9\11\x3c\x61\40\150\x72\x65\146\75\42" . $b5 . "\42\76" . mo_("\126\141\x6c\151\x64\x61\x74\145\40\x79\x6f\165\x72\40\x70\x75\162\143\150\x61\x73\145") . "\74\x2f\141\76\x20\xa\x9\11\x9\40\x9\x9\11\11" . mo_("\x20\164\157\x20\x65\x6e\141\142\x6c\x65\x20\164\150\x65\x20\101\x64\x64\40\117\156") . "\74\57\144\151\x76\x3e";
    }
    public static function getActivePluginVersion($uw, $KW = 0)
    {
        if (function_exists("\147\x65\164\x5f\x70\x6c\x75\147\x69\x6e\163")) {
            goto ZA;
        }
        require_once ABSPATH . "\x77\160\x2d\141\x64\155\151\x6e\57\x69\156\x63\154\x75\144\x65\163\57\160\154\165\x67\151\156\56\160\150\160";
        ZA:
        $iQ = get_plugins();
        $G1 = get_option("\141\143\x74\x69\166\x65\x5f\160\x6c\165\147\151\x6e\163");
        foreach ($iQ as $O5 => $Xd) {
            if (!(strcasecmp($Xd["\x4e\141\x6d\x65"], $uw) == 0)) {
                goto Sl;
            }
            if (!in_array($O5, $G1)) {
                goto HE;
            }
            return (int) $Xd["\x56\x65\162\x73\151\x6f\156"][$KW];
            HE:
            Sl:
            QC:
        }
        KC:
        return null;
    }
}
