<?php


namespace OTP\Addons\UmSMSNotification\Helper;

use OTP\Helper\MoUtility;
use OTP\Objects\BaseMessages;
use OTP\Traits\Instance;
final class UltimateMemberSMSNotificationMessages extends BaseMessages
{
    use Instance;
    private function __construct()
    {
        define("\115\117\137\125\115\x5f\101\104\x44\x4f\x4e\x5f\x4d\x45\x53\x53\x41\107\105\123", serialize(array(self::NEW_UM_CUSTOMER_NOTIF_HEADER => mo_("\116\x45\127\x20\101\103\x43\x4f\x55\116\x54\x20\116\117\x54\x49\106\111\103\x41\x54\x49\117\x4e"), self::NEW_UM_CUSTOMER_NOTIF_BODY => mo_("\x43\x75\x73\164\x6f\155\x65\162\x73\x20\x61\162\145\x20\x73\145\x6e\x74\40\141\40\x6e\x65\167\40\141\143\143\x6f\x75\156\164\x20\123\115\x53\x20\x6e\157\164\x69\146\151\x63\141\164\151\157\x6e" . "\x20\x77\x68\145\x6e\40\164\x68\x65\171\40\163\x69\147\x6e\40\x75\160\40\x6f\156\40\x74\150\x65\40\163\x69\164\145\x2e"), self::NEW_UM_CUSTOMER_SMS => mo_("\124\x68\141\x6e\153\x73\x20\146\157\x72\40\x63\162\145\141\164\x69\x6e\147\x20\141\x6e\40\x61\143\143\157\x75\x6e\164\x20\x6f\156\x20\173\163\x69\164\x65\55\156\141\155\145\x7d\56" . "\x25\x30\x61\x59\157\165\x72\40\165\x73\x65\162\x6e\141\155\145\40\151\x73\x20\x7b\165\x73\x65\x72\x6e\141\x6d\x65\175\56\x25\x30\141\x4c\157\x67\x69\156\x20\x48\145\x72\145\72\40" . "\173\x61\x63\x63\157\165\156\164\160\x61\147\145\x2d\x75\x72\x6c\x7d"), self::NEW_UM_CUSTOMER_ADMIN_NOTIF_BODY => mo_("\101\144\155\x69\156\x73\x20\141\x72\x65\x20\x73\145\156\164\40\141\x20\x6e\145\x77\x20\141\x63\x63\157\165\x6e\x74\x20\123\x4d\123\40\x6e\157\164\x69\x66\x69\143\x61\x74\151\x6f\x6e\x20\167\150\x65\156" . "\x20\x61\x20\165\x73\145\x72\x20\163\x69\x67\156\163\x20\x75\x70\x20\157\156\x20\164\150\x65\40\x73\151\x74\x65\x2e"), self::NEW_UM_CUSTOMER_ADMIN_SMS => mo_("\116\x65\x77\x20\x55\x73\145\162\40\103\x72\145\141\x74\x65\144\x20\157\156\40\x7b\x73\x69\164\x65\x2d\156\x61\x6d\145\x7d\56\x25\60\x61\125\x73\x65\162\156\141\x6d\145\72\40" . "\x7b\x75\163\x65\162\x6e\x61\x6d\x65\175\x2e\x25\60\141\x50\x72\x6f\146\x69\x6c\145\x20\120\141\x67\145\72\x20\173\x61\x63\143\x6f\x75\156\164\x70\x61\147\145\x2d\165\162\154\175"))));
    }
    public static function showMessage($bm, $tT = array())
    {
        $Ug = '';
        $bm = explode("\x20", $bm);
        $d2 = unserialize(MO_UM_ADDON_MESSAGES);
        $I2 = unserialize(MO_MESSAGES);
        $d2 = array_merge($d2, $I2);
        foreach ($bm as $al) {
            if (!MoUtility::isBlank($al)) {
                goto pd;
            }
            return $Ug;
            pd:
            $oh = $d2[$al];
            foreach ($tT as $O5 => $Xd) {
                $oh = str_replace("\x7b\x7b" . $O5 . "\175\x7d", $Xd, $oh);
                w8:
            }
            bX:
            $Ug .= $oh;
            wd:
        }
        bb:
        return $Ug;
    }
}
