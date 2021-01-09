<?php


namespace OTP\Helper;

use OTP\Objects\IMoSessions;
if (defined("\101\x42\123\120\x41\124\110")) {
    goto qi;
}
die;
qi:
class MoPHPSessions implements IMoSessions
{
    static function addSessionVar($O5, $k8)
    {
        switch (MOV_SESSION_TYPE) {
            case "\x43\117\117\x4b\x49\x45":
                setcookie($O5, maybe_serialize($k8));
                goto u5;
            case "\123\105\123\123\111\x4f\116":
                self::checkSession();
                $_SESSION[$O5] = maybe_serialize($k8);
                goto u5;
            case "\103\x41\x43\x48\x45":
                if (wp_cache_add($O5, maybe_serialize($k8))) {
                    goto Sd;
                }
                wp_cache_replace($O5, maybe_serialize($k8));
                Sd:
                goto u5;
            case "\x54\122\x41\x4e\x53\111\105\116\124":
                if (!isset($_COOKIE["\x74\x72\x61\x6e\163\151\x65\156\x74\137\153\x65\x79"])) {
                    goto TV;
                }
                $Gg = $_COOKIE["\x74\162\141\156\x73\x69\x65\x6e\x74\x5f\153\x65\x79"];
                goto Ni;
                TV:
                if (!wp_cache_get("\164\162\141\156\163\151\x65\x6e\164\x5f\x6b\145\171")) {
                    goto xY;
                }
                $Gg = wp_cache_get("\164\x72\x61\x6e\163\x69\x65\x6e\x74\x5f\153\145\x79");
                goto Ce;
                xY:
                $Gg = MoUtility::rand();
                if (!ob_get_contents()) {
                    goto MO;
                }
                ob_clean();
                MO:
                setcookie("\x74\x72\x61\156\x73\151\145\156\164\137\153\145\171", $Gg, time() + 12 * HOUR_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN);
                wp_cache_add("\164\x72\x61\156\x73\x69\x65\156\x74\137\x6b\145\171", $Gg);
                Ce:
                Ni:
                set_site_transient($Gg . $O5, $k8, 12 * HOUR_IN_SECONDS);
                goto u5;
        }
        RW:
        u5:
    }
    static function getSessionVar($O5)
    {
        switch (MOV_SESSION_TYPE) {
            case "\103\x4f\117\x4b\x49\105":
                return maybe_unserialize($_COOKIE[$O5]);
            case "\x53\105\x53\123\111\x4f\x4e":
                self::checkSession();
                return maybe_unserialize(MoUtility::sanitizeCheck($O5, $_SESSION));
            case "\x43\x41\103\x48\105":
                return maybe_unserialize(wp_cache_get($O5));
            case "\x54\x52\101\116\123\111\105\x4e\124":
                $Gg = isset($_COOKIE["\164\162\141\156\163\151\x65\156\x74\137\153\145\x79"]) ? $_COOKIE["\164\x72\x61\156\x73\x69\145\x6e\164\137\153\145\171"] : wp_cache_get("\164\162\x61\156\163\x69\145\156\164\x5f\x6b\145\x79");
                return get_site_transient($Gg . $O5);
        }
        pi:
        it:
    }
    static function unsetSession($O5)
    {
        switch (MOV_SESSION_TYPE) {
            case "\x43\117\x4f\113\111\x45":
                unset($_COOKIE[$O5]);
                setcookie($O5, '', time() - 15 * 60);
                goto Mj;
            case "\123\105\x53\x53\111\x4f\116":
                self::checkSession();
                unset($_SESSION[$O5]);
                goto Mj;
            case "\x43\101\103\110\105":
                wp_cache_delete($O5);
                goto Mj;
            case "\124\x52\x41\116\x53\x49\x45\116\x54":
                $Gg = isset($_COOKIE["\164\162\x61\x6e\163\x69\x65\x6e\x74\x5f\x6b\x65\171"]) ? $_COOKIE["\164\162\x61\156\x73\151\145\156\164\137\x6b\x65\171"] : wp_cache_get("\x74\162\x61\156\x73\x69\x65\156\x74\137\x6b\145\x79");
                if (MoUtility::isBlank($Gg)) {
                    goto fG;
                }
                delete_site_transient($Gg . $O5);
                fG:
                goto Mj;
        }
        lt:
        Mj:
    }
    static function checkSession()
    {
        if (!(MOV_SESSION_TYPE == "\123\x45\x53\x53\111\117\116")) {
            goto bV;
        }
        if (!(session_id() == '' || !isset($_SESSION))) {
            goto e1;
        }
        session_start();
        e1:
        bV:
    }
}
